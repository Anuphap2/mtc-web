<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * หน้า Index (DataTables AJAX)
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * ดึงข้อมูลสำหรับ DataTables
     */
    public function getPostsData(Request $request)
    {
        if (!$request->ajax()) {
            abort(403, 'Direct access forbidden.');
        }

        try {
            $query = Post::with('category')->select('posts.*');

            return DataTables::of($query)
                ->addIndexColumn()

                // 1. [ปรับปรุง] ใช้ Badge สำหรับ Category
                ->addColumn('category_name', function ($row) {
                    if ($row->category) {
                        // สี Badge อาจจะเปลี่ยนตาม Category ID หรือสุ่ม
                        return '<span class="px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800">' . $row->category->name . '</span>';
                    }
                    return '<span class="px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">N/A</span>';
                })

                // 2. [แก้ไขบั๊ก] เปลี่ยนจาก join(...) เป็น leftJoin(...)
                ->orderColumn('category_name', function ($query, $order) {
                    // ใช้ leftJoin เพื่อให้ข่าวที่ไม่มีหมวดหมู่ยังคงแสดงอยู่
                    $query->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                        ->orderBy('categories.name', $order)
                        ->select('posts.*'); // select('posts.*') ยังจำเป็นอยู่
                })

                // 3. [ปรับปรุง] ปรับสไตล์รูปภาพให้มีขนาดคงที่
                ->addColumn(
                    'image',
                    function ($row) {
                        if ($row->image_path && Storage::disk('public')->exists($row->image_path)) {
                            // ใช้ h-12 w-16 (4:3 ratio) และ object-cover จะดูเนี้ยบในตาราง
                            return '<img src="' . Storage::url($row->image_path) . '" alt="' . e($row->title) . '" class="h-12 w-16 object-cover rounded-md shadow-sm">';
                        }
                        return '<span class="flex items-center justify-center h-12 w-16 bg-gray-50 rounded-md text-gray-400 text-xs italic">ไม่มีรูป</span>';
                    }
                )

                // 4. [ปรับปรุง] ใช้ Badge สำหรับ Featured
                ->addColumn(
                    'featured',
                    function ($row) {
                        if ($row->is_featured) {
                            return '<span class="px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">เด่น</span>';
                        }
                        return '<span class="px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-100 text-gray-600">ทั่วไป</span>';
                    }
                )

                ->addColumn('action', fn($row) => $this->actionButtons($row))
                ->editColumn('created_at', fn($row) => $row->created_at?->translatedFormat('j M Y, H:i') ?? '-')
                ->rawColumns(['action', 'image', 'featured', 'category_name'])
                ->make(true);

        } catch (\Exception $e) {
            Log::error('DataTables Error (Posts): ' . $e->getMessage());
            return response()->json(['error' => 'Could not retrieve data. Server error.'], 500);
        }
    }

    /**
     * สร้างข่าว
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        $data['image_path'] = $this->storeFile($request, 'image', 'posts/images');
        $data['pdf_path'] = $this->storeFile($request, 'pdf', 'posts/pdfs');
        $data['is_featured'] = $request->boolean('is_featured');

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'สร้างข่าวสำเร็จ');
    }

    /**
     * แก้ไขข่าว
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request);

        $data['is_featured'] = $request->boolean('is_featured');

        // จัดการไฟล์
        $this->updateFile($request, $post, 'image', 'posts/images');
        $this->updateFile($request, $post, 'pdf', 'posts/pdfs', $request->boolean('remove_pdf'));

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'อัปเดตข่าวสำเร็จ');
    }

    /**
     * ลบข่าวเดี่ยว
     */
    public function destroy(Post $post)
    {
        try {
            $this->deleteFile($post->image_path);
            $this->deleteFile($post->pdf_path);

            $post->delete();

            return redirect()->route('admin.posts.index')->with('success', 'ลบข่าวสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Delete post error: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')->with('error', 'เกิดข้อผิดพลาดในการลบ');
        }
    }

    /**
     * ลบหลายข่าวพร้อมกัน
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $request->ids)->get();

        foreach ($posts as $post) {
            $this->deleteFile($post->image_path);
            $this->deleteFile($post->pdf_path);
        }

        $deletedCount = Post::destroy($request->ids);

        return redirect()->route('admin.posts.index')->with('success', 'ลบ ' . $deletedCount . ' รายการสำเร็จ');
    }

    /** ----------------- Private Helper Methods ----------------- */

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'remove_pdf' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);
    }

    private function actionButtons(Post $row): string
    {
        $editUrl = route('admin.posts.edit', $row->id);
        $deleteUrl = route('admin.posts.destroy', $row->id);
        $csrf = csrf_token();

        // [ปรับปรุง]
        // - ลบ class="justify-start" (เพราะเป็น default ของ flex)
        // - ลบ class="inline-block" ออกจาก form (เพราะ flex-container จัดการอยู่แล้ว)
        return <<<HTML
<div class="flex items-center space-x-3">
    <a href="{$editUrl}" title="แก้ไข" class="text-indigo-600 hover:text-indigo-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
        </svg>
    </a>
    <form action="{$deleteUrl}" method="POST" onsubmit="return confirm('ยืนยันการลบข่าวนี้?');">
        <input type="hidden" name="_token" value="{$csrf}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" title="ลบ" class="text-red-600 hover:text-red-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </button>
    </form>
</div>
HTML;
    }

    private function storeFile(Request $request, string $field, string $path): ?string
    {
        return $request->hasFile($field) ? $request->file($field)->store($path, 'public') : null;
    }

    private function updateFile(Request $request, Post $post, string $field, string $path, bool $remove = false): void
    {
        if ($request->hasFile($field)) {
            $this->deleteFile($post->{$field . '_path'});
            $post->{$field . '_path'} = $request->file($field)->store($path, 'public');
        } elseif ($remove) {
            $this->deleteFile($post->{$field . '_path'});
            $post->{$field . '_path'} = null;
        }
    }

    private function deleteFile(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
