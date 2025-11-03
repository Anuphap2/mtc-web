<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    /**
     * หน้าแรก
     * - Slider ข่าวเด่น (featured)
     * - ข่าวแยกตาม Category
     */
    public function index(): View
    {
        // Slider ข่าวเด่น 5 ข่าวล่าสุด
        $featuredPosts = Post::with('category')
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();

        // Categories ที่มีข่าว พร้อมโหลด 3 ข่าวล่าสุดของแต่ละ Category
        $categoriesWithPosts = Category::whereHas('posts')
            ->with([
                'posts' => fn($q) => $q->with('category')->latest()->take(3) // เพิ่ม with('category') ใน Eager Loading ซ้อน
            ])
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredPosts', 'categoriesWithPosts'));
    }

    /**
     * แสดงข่าวทั้งหมดแบบแบ่งหน้า
     */
    public function allPosts(): View
    {
        $posts = Post::with('category')
            ->latest()
            ->paginate(12);

        return view('all-posts', compact('posts'));
    }

    /**
     * หน้าอ่านข่าว (Route Model Binding)
     * - แสดง related posts (จากหมวดหมู่เดียวกัน) ยกเว้นข่าวตัวเอง
     */
    public function show(Post $post): View
    {
        // โหลด Category ของโพสต์หลัก (สำหรับแสดงผลใน View)
        $post->load('category');

        $relatedPosts = collect(); // สร้าง Collection ว่างไว้ก่อน

        // [ปรับปรุง] ตรวจสอบก่อนว่าโพสต์นี้มีหมวดหมู่หรือไม่
        if ($post->category_id) {
            // [แก้ไข] ดึงข่าวจาก category_id ของโพสต์ปัจจุบัน
            $relatedPosts = $this->_getPostsByCategory(
                categoryId: $post->category_id,
                excludeId: $post->id,
                limit: 3
            );
        }
        // ถ้าโพสต์ไม่มีหมวดหมู่ $relatedPosts จะเป็น Collection ว่าง
        // (ใน View post-show.blade.php ควรมี @if($relatedPosts->count()) ... @endif)

        return view('post-show', compact('post', 'relatedPosts'));
    }

    /**
     * หน้าแสดงข่าวตาม Category
     */
    public function category(Category $category): View
    {
        $posts = $category->posts()
            ->with('category') // เพิ่ม with('category') เพื่อประสิทธิภาพ
            ->latest()
            ->paginate(9);

        return view('category-show', compact('category', 'posts'));
    }

    /**
     * ฟังก์ชัน private: ดึงข่าวตาม Category ID
     *
     * @param int $categoryId
     * @param int|null $paginate
     * @param int|null $excludeId
     * @param int|null $limit
     * @return LengthAwarePaginator|Collection
     */
    private function _getPostsByCategory(int $categoryId, ?int $paginate = null, ?int $excludeId = null, ?int $limit = null): LengthAwarePaginator|Collection
    {
        $query = Post::with('category')
            ->where('category_id', $categoryId)
            ->latest();

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return match (true) {
            $paginate !== null => $query->paginate($paginate),
            $limit !== null => $query->take($limit)->get(),
            default => $query->get(),
        };
    }
}
