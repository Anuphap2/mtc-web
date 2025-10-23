<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
// Use DataTables Facade
use Yajra\DataTables\Facades\DataTables;
// Optional: Use Log facade for debugging
use Illuminate\Support\Facades\Log; // <-- เพิ่ม Log


class PostController extends Controller
{
    /**
     * แสดงหน้า Index (เตรียมสำหรับ DataTables)
     */
    public function index()
    {
        // View นี้จะถูก Populate ด้วย DataTables ผ่าน AJAX
        return view('admin.posts.index');
    }

     /**
     * Function สำหรับดึงข้อมูลให้ DataTables (AJAX)
     */
    public function getPostsData(Request $request)
    {
        // ตรวจสอบว่าเป็น AJAX request ที่ DataTables คาดหวังหรือไม่
        if ($request->ajax()) {
            try { // <-- เพิ่ม try-catch เพื่อจัดการข้อผิดพลาด
                // ดึงข้อมูล posts พร้อม category, เรียงล่าสุด, เลือกเฉพาะคอลัมน์จากตาราง posts
                $data = Post::with('category')->latest()->select('posts.*');

                // สร้าง Response ของ DataTables
                return DataTables::of($data)
                    ->addIndexColumn() // เพิ่มคอลัมน์ลำดับ (DT_RowIndex)
                    ->addColumn('category_name', function ($row) {
                        // แสดงชื่อ Category (ถ้ามี)
                        return $row->category ? $row->category->name : '<span class="text-xs text-red-500">N/A</span>';
                    })
                     ->addColumn('image', function ($row) {
                         // แสดงรูปภาพ ถ้ามีและไฟล์ tồn tạiจริง
                        if ($row->image_path && Storage::disk('public')->exists($row->image_path)) {
                            return '<img src="' . Storage::url($row->image_path) . '" alt="Image" class="h-16 w-auto max-w-[100px] object-contain rounded shadow">'; // ปรับ Style รูปภาพ
                        }
                        return '<span class="text-gray-400 text-xs italic">ไม่มีรูป</span>'; // ข้อความถ้าไม่มีรูป
                    })
                     ->addColumn('featured', function ($row) {
                         // แสดงไอคอน check ถ้าเป็น is_featured
                        return $row->is_featured
                            ? '<svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
                            : '';
                    })
                    ->addColumn('action', function ($row) {
                        // --- เพิ่มปุ่ม Edit และ Delete ---
                        $editUrl = route('admin.posts.edit', $row->id);
                        $deleteUrl = route('admin.posts.destroy', $row->id);
                        $csrfToken = csrf_token(); // Get CSRF token

                        // ใช้ Icons และจัดวางปุ่ม
                        $btn = '<div class="flex items-center space-x-2 justify-start">'; // จัดชิดซ้าย
                        // Edit Button
                        $btn .= '<a href="' . $editUrl . '" title="แก้ไข" class="text-indigo-600 hover:text-indigo-900">';
                        $btn .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>';
                        $btn .= '</a> ';
                        // Delete Button (using form for DELETE method)
                        $btn .= '<form action="' . $deleteUrl . '" method="POST" class="inline-block" onsubmit="return confirm(\'ยืนยันการลบข่าวนี้?\');">';
                        $btn .= '<input type="hidden" name="_token" value="' . $csrfToken . '">'; // Add CSRF token
                        $btn .= '<input type="hidden" name="_method" value="DELETE">';       // Add METHOD spoofing
                        $btn .= '<button type="submit" title="ลบ" class="text-red-600 hover:text-red-900">';
                        $btn .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>';
                        $btn .= '</button>';
                        $btn .= '</form>';
                        $btn .= '</div>';
                        return $btn;
                        // --- จบส่วนเพิ่มปุ่ม ---
                    })
                    ->addColumn('checkbox', function ($row) {
                        // Checkbox สำหรับ Bulk Delete
                        return '<input type="checkbox" name="ids[]" value="' . $row->id . '" class="post-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0">'; // Added focus:ring-offset-0
                    })
                    ->editColumn('created_at', function ($row) {
                         // จัดรูปแบบวันที่ให้อ่านง่ายขึ้น (ใช้ Carbon)
                        return $row->created_at ? $row->created_at->translatedFormat('j M Y, H:i') : '-'; // เช่น 23 ต.ค. 2025, 13:28
                     })
                    // ระบุคอลัมน์ที่มี HTML เพื่อให้ DataTables แสดงผลถูกต้อง
                    ->rawColumns(['action', 'image', 'featured','checkbox', 'category_name'])
                    ->make(true); // สร้าง JSON response

            } catch (\Exception $e) {
                // Log ข้อผิดพลาดไว้ดูบน Server
                Log::error('DataTables Error (Posts): ' . $e->getMessage());
                // ส่ง JSON error กลับไปให้ DataTables (จะแสดงใน Console ของ Browser)
                return response()->json(['error' => 'Could not retrieve data. Server error.'], 500);
            }
        }
        // ป้องกันการเข้าถึง URL นี้โดยตรง
        abort(403, 'Direct access forbidden.');
    }

    // --- (create, store, edit, update - ควรตรวจสอบ 'is_featured' ให้ครบ) ---
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // (เพิ่ม is_featured ใน validation และ create() ถ้ายังไม่มี)
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'is_featured' => 'nullable|boolean', // Added
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('posts/images', 'public') : null;
        $pdfPath = $request->hasFile('pdf') ? $request->file('pdf')->store('posts/pdfs', 'public') : null;

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'embed_link' => $validated['embed_link'],
            'image_path' => $imagePath,
            'pdf_path' => $pdfPath,
            'is_featured' => $request->boolean('is_featured'), // Added
        ]);
        return redirect()->route('admin.posts.index')->with('success', 'สร้างข่าวสำเร็จ');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
         // (เพิ่ม is_featured ใน validation และ update() ถ้ายังไม่มี)
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'is_featured' => 'nullable|boolean', // Added
            'remove_pdf' => 'nullable|boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'embed_link' => $validated['embed_link'],
            'is_featured' => $request->boolean('is_featured'), // Added
        ];

        // Handle Image
        if ($request->hasFile('image')) {
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('posts/images', 'public');
        }

        // Handle PDF
        if ($request->hasFile('pdf')) {
             if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $updateData['pdf_path'] = $request->file('pdf')->store('posts/pdfs', 'public');
        } elseif ($request->boolean('remove_pdf')) {
             if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $updateData['pdf_path'] = null;
        }
        // If neither new PDF nor remove checked, pdf_path remains unchanged

        $post->update($updateData);

        return redirect()->route('admin.posts.index')->with('success', 'อัปเดตข่าวสำเร็จ');
    }

    /**
     * ลบ Post (รองรับ AJAX จากปุ่ม Delete ปกติ)
     */
    public function destroy(Post $post)
    {
         try {
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }
            if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $post->delete();

            // ถ้าเป็นการเรียกผ่าน AJAX (เช่น จาก DataTables) ให้ส่ง JSON กลับ
             if(request()->ajax()){
                // อาจไม่จำเป็นถ้าใช้ onsubmit="confirm(...)" แล้ว redirect ผ่าน form
                // แต่ถ้าทำ AJAX delete เต็มรูปแบบ จะส่ง JSON response
                // return response()->json(['success' => 'ลบข่าวสำเร็จ']);
             }
            // ถ้าเป็นการเรียกปกติ (กด Submit Form) ให้ Redirect
            return redirect()->route('admin.posts.index')->with('success', 'ลบข่าวสำเร็จ');

         } catch (\Exception $e) {
             Log::error('Delete post error: ' . $e->getMessage());
              if(request()->ajax()){
                 return response()->json(['error' => 'เกิดข้อผิดพลาดในการลบ'], 500);
             }
            return redirect()->route('admin.posts.index')->with('error', 'เกิดข้อผิดพลาดในการลบ: ' . $e->getMessage());
         }
    }

    /**
     * ลบ Posts หลายรายการพร้อมกัน (Bulk Delete)
     */
    public function bulkDestroy(Request $request)
    {
        // Validate ว่ามี ids ส่งมา และเป็น array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:posts,id', // เช็คว่าทุก id มีในตาราง posts
        ]);

        $postIds = $request->input('ids');

        if (empty($postIds)) {
             return redirect()->route('admin.posts.index')->with('error', 'กรุณาเลือกรายการที่ต้องการลบ');
        }

        try {
            // ดึงข้อมูล Posts ที่จะลบ เพื่อลบไฟล์ด้วย
            $postsToDelete = Post::whereIn('id', $postIds)->get();

            foreach ($postsToDelete as $post) {
                // ลบรูปภาพ (ถ้ามี)
                if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                    Storage::disk('public')->delete($post->image_path);
                }
                // ลบ PDF (ถ้ามี)
                if ($post->pdf_path && Storage::disk('public')->exists($post->pdf_path)) {
                    Storage::disk('public')->delete($post->pdf_path);
                }
            }

            // ลบข้อมูลออกจากฐานข้อมูล
            $deletedCount = Post::destroy($postIds); // destroy returns the number of records deleted

            return redirect()->route('admin.posts.index')->with('success', 'ลบ ' . $deletedCount . ' รายการสำเร็จ');

        } catch (\Exception $e) {
            Log::error('Bulk delete posts error: ' . $e->getMessage()); // Log error
            return redirect()->route('admin.posts.index')->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $e->getMessage()); // Show error message
        }
    }
}

