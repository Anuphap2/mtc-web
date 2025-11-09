<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // 1. เพิ่ม Cache
use Illuminate\Support\Str; // 2. เพิ่ม Str
use Intervention\Image\Laravel\Facades\Image; // 3. เพิ่ม Image
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /* =========================================================
     * 🧭 หน้า Index
     * ========================================================= */
    public function index()
    {
        return view('admin.posts.index');
    }

    /* =========================================================
     * 📊 DataTables AJAX
     * ========================================================= */
    public function getPostsData(Request $request)
    {
        if (!$request->ajax())
            abort(403, 'Direct access forbidden.');

        try {
            $categories = Category::pluck('name', 'id');
            $query = Post::query()->select('posts.*');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category_name', fn($row) => isset($categories[$row->category_id])
                    ? "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800'>"
                    . e($categories[$row->category_id]) . "</span>"
                    : "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800'>N/A</span>")
                ->orderColumn('category_name', fn($query, $order) =>
                    $query->join('categories', 'posts.category_id', '=', 'categories.id')
                        ->orderBy('categories.name', $order)
                        ->select('posts.*'))
                ->addColumn('image', fn($row) => $row->image_path
                    // (ใช้ asset() เพราะเราจะย้ายไฟล์ไปที่ public/storage)
                    ? "<img src='" . asset("storage/{$row->image_path}") . "' class='h-12 w-16 object-cover rounded-md shadow-sm'>"
                    : "<span class='flex items-center justify-center h-12 w-16 bg-gray-50 rounded-md text-gray-400 text-xs italic'>ไม่มีรูป</span>")
                ->addColumn('featured', fn($row) =>
                    $row->is_featured
                    ? "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800'>เด่น</span>"
                    : "<span class='px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600'>ทั่วไป</span>")
                ->addColumn('action', fn($row) => $this->actionButtons($row))
                ->editColumn('created_at', fn($row) => $row->created_at?->translatedFormat('j M Y, H:i') ?? '-')
                ->rawColumns(['action', 'image', 'featured', 'category_name'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('DataTables Error (Posts): ' . $e->getMessage());
            return response()->json(['error' => 'Could not retrieve data. Server error.'], 500);
        }
    }

    /* =========================================================
     * 🆕 Create & Store
     * ========================================================= */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        // Upload files (ใช้ handleFile ที่แก้ไขแล้ว)
        $data['image_path'] = $this->handleFile($request, null, 'image', 'posts/images');
        $data['pdf_path'] = $this->handleFile($request, null, 'pdf', 'posts/pdfs');
        $data['is_featured'] = $request->boolean('is_featured');

        Post::create($data);

        $this->clearCache(); // ล้าง Cache

        return redirect()->route('admin.posts.index')->with('success', 'สร้างข่าวสำเร็จ');
    }

    /* =========================================================
     * ✏️ Edit & Update
     * ========================================================= */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request);
        $data['is_featured'] = $request->boolean('is_featured');

        // [!! แก้ไข Bug !!]
        // อัปเดตไฟล์และกำหนดค่าลงใน $data ก่อนที่จะ update
        $data['image_path'] = $this->handleFile($request, $post, 'image', 'posts/images');
        $data['pdf_path'] = $this->handleFile($request, $post, 'pdf', 'posts/pdfs', $request->boolean('remove_pdf'));

        $post->update($data); // อัปเดตข้อมูลทั้งหมด

        $this->clearCache(); // ล้าง Cache

        return redirect()->route('admin.posts.index')->with('success', 'อัปเดตข่าวสำเร็จ');
    }

    /* =========================================================
     * 🗑️ Delete & Bulk Delete
     * ========================================================= */
    public function destroy(Post $post)
    {
        try {
            $this->deleteFile($post->image_path);
            $this->deleteFile($post->pdf_path);
            $post->delete();

            $this->clearCache(); // ล้าง Cache

            return redirect()->route('admin.posts.index')->with('success', 'ลบข่าวสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Delete post error: ' . $e->getMessage());
            return redirect()->route('admin.posts.index')->with('error', 'เกิดข้อผิดพลาดในการลบ');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $request->ids)->get(['image_path', 'pdf_path']);
        foreach ($posts as $p) {
            $this->deleteFile($p->image_path);
            $this->deleteFile($p->pdf_path);
        }

        $deletedCount = Post::destroy($request->ids);
        $this->clearCache(); // ล้าง Cache

        return redirect()->route('admin.posts.index')
            ->with('success', "ลบ {$deletedCount} รายการสำเร็จ");
    }

    /* =========================================================
     * 🧩 Private Helpers
     * ========================================================= */
    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB (เพิ่ม webp)
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // รองรับ PDF 10MB
            'remove_pdf' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);
    }

    private function actionButtons(Post $row): string
    {
        $edit = route('admin.posts.edit', $row->id);
        $delete = route('admin.posts.destroy', $row->id);

        return <<<HTML
<div class="flex items-center space-x-3">
    <a href="{$edit}" class="text-indigo-600 hover:text-indigo-900" title="แก้ไข">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
        </svg>
    </a>
    <button type="button" onclick="openDeleteModal('{$delete}', '{$row->title}')" class="text-red-600 hover:text-red-900" title="ลบ">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
    </button>
</div>
HTML;
    }

    // [!! แก้ไข !!] อัปเดต handleFile ให้รองรับ Intervention Image
    private function handleFile(Request $request, ?Post $post, string $field, string $folder, bool $remove = false): ?string
    {
        $key = $field . '_path';
        $destinationPath = public_path("storage/{$folder}");

        // 1. ถ้ามีไฟล์ใหม่อัปโหลด
        if ($request->hasFile($field)) {
            // 1.1 ลบไฟล์เก่า (ถ้ามี)
            $this->deleteFile($post?->{$key});

            $file = $request->file($field);

            // 1.2 ถ้าเป็นรูปภาพ (image) ให้บีบอัด
            if ($field === 'image') {
                $filename = Str::uuid() . '.webp';
                $path = "{$folder}/{$filename}";

                // สร้าง Directory ถ้ายังไม่มี
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // บีบอัด, Resize และแปลงเป็น WebP
                $image = Image::read($file->getRealPath());
                $image->scaleDown(width: 1200); // Resize ให้ความกว้างไม่เกิน 1200px
                $image->toWebp(75)->save($destinationPath . '/' . $filename); // แปลงเป็น WebP 75%

                return $path;
            }

            // 1.3 ถ้าเป็นไฟล์อื่น (เช่น pdf) ให้ย้ายไฟล์ปกติ
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            return "{$folder}/{$fileName}";
        }

        // 2. ถ้าสั่งลบไฟล์ (เช่น ติ๊ก 'ลบ PDF')
        if ($remove) {
            $this->deleteFile($post?->{$key});
            return null;
        }

        // 3. ไม่มีการเปลี่ยนแปลง (ใช้ไฟล์เดิม)
        return $post?->{$key} ?? null;
    }

    private function deleteFile(?string $filePath): void
    {
        if ($filePath && file_exists(public_path("storage/{$filePath}"))) {
            try {
                unlink(public_path("storage/{$filePath}"));
            } catch (\Exception $e) {
                Log::error("Could not delete file: {$filePath}. Error: " . $e->getMessage());
            }
        }
    }

    // [!! เพิ่มใหม่ !!] ฟังก์ชันสำหรับล้าง Cache
    private function clearCache(): void
    {
        Cache::forget('featured_posts');
        Cache::forget('categories_with_posts');
        Cache::forget('director_message');
        Cache::forget('main_menus');
        // เพิ่ม key cache อื่นๆ ที่เกี่ยวข้องกับ Post/Category ที่นี่
    }
}