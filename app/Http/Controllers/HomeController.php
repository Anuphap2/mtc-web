<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    /**
     * หน้าแรก
     * แสดงข่าวแยกตามประเภท และ สไลด์ข่าวเด่น
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        // 1. ดึงข่าวเด่นสำหรับ Slider (เพิ่มเงื่อนไข is_featured = true)
        // สมมติว่าดึงมา 5 ข่าวล่าสุดที่เป็น featured
        $featuredPosts = Post::with('category')
            ->where('is_featured', true) // <-- เงื่อนไขใหม่
            ->latest()
            ->take(5) // <-- เอาแค่ 5 ข่าว
            ->get();

        // 2. ดึง Categories ทั้งหมด ที่มีข่าวอย่างน้อย 1 ข่าว
        //    พร้อมโหลดข่าวล่าสุดของแต่ละ Category มาจำนวนหนึ่ง (เช่น 3 ข่าว)
        $categoriesWithPosts = Category::whereHas('posts') // เอาเฉพาะ Category ที่มี post
            ->with([
                'posts' => function ($query) {
                    $query->latest()->take(3); // โหลด post ล่าสุด 3 อัน
                }
            ])
            ->orderBy('name', 'asc') // เรียงตามชื่อ Category
            ->get();

        // 3. ส่งข้อมูลไปที่ View
        return view('home', compact('featuredPosts', 'categoriesWithPosts'));
    }


    public function allPosts(): \Illuminate\Contracts\View\View
    {
        // ดึงข่าวทั้งหมด ล่าสุดก่อน แบบแบ่งหน้า
        $posts = Post::with('category')
            ->latest()
            ->paginate(12); // แสดง 12 ข่าวต่อหน้า

        return view('all-posts', compact('posts')); // ใช้ view ใหม่ชื่อ all-posts.blade.php
    }
    
    // (show, category, _getPostsByCategory methods remain the same)
    /**
     * หน้าอ่านข่าว (ใช้ Route Model Binding)
     * แสดงข่าวที่เกี่ยวข้องเฉพาะประเภท "ประชาสัมพันธ์" (Category ID = 2)
     */
    public function show(Post $post): \Illuminate\Contracts\View\View
    {
        $post->load('category');
        // ดึงข่าวเกี่ยวข้อง ID 2 (ไม่เอาข่าวตัวเอง, 3 ข่าว)
        // **ปรับปรุง: ใช้ฟังก์ชัน _getPostsByCategory ที่มีอยู่**
        $relatedPosts = $this->_getPostsByCategory(categoryId: 2, excludeId: $post->id, limit: 3);
        return view('post-show', compact('post', 'relatedPosts'));
    }

    /**
     * หน้าแสดงข่าวตามประเภท (ใช้ Route Model Binding)
     */
    public function category(Category $category): \Illuminate\Contracts\View\View
    {
        $posts = $category->posts()->latest()->paginate(9);
        return view('category-show', compact('category', 'posts'));
    }

    /**
     * ฟังก์ชันสำหรับดึงข่าวตาม Category ID (ใช้ภายใน Controller นี้)
     */
    private function _getPostsByCategory(int $categoryId, ?int $paginate = null, ?int $excludeId = null, ?int $limit = null): LengthAwarePaginator|Collection
    {
        $query = Post::with('category')
            ->where('category_id', $categoryId)
            ->latest();
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        if ($paginate !== null) {
            return $query->paginate($paginate);
        } elseif ($limit !== null) {
            return $query->take($limit)->get();
        } else {
            return $query->get();
        }
    }
}