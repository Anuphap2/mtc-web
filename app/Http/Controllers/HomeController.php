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
     * ---------------------------------------------------------
     * หน้าแรก
     * - แสดงข่าวเด่น (Featured)
     * - แสดงข่าวตามหมวดหมู่
     * ---------------------------------------------------------
     */
    public function index(): View
    {

        // ✅ ข่าวเด่น (5 ข่าวล่าสุด)
        $featuredPosts = Post::select('id', 'title', 'image_path', 'category_id', 'created_at')
            ->with('category:id,name')
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();

        // ✅ ดึงหมวดหมู่ที่มีข่าว และโหลดข่าวล่าสุดของแต่ละหมวด (3 ข่าว)
        $categoriesWithPosts = Category::whereHas('posts')
            ->with([
                'posts' => fn($q) => $q
                    ->select('id', 'title', 'image_path', 'category_id', 'created_at')
                    ->latest()
                    ->take(3)
            ])
            ->orderBy('name')
            ->get();

        return view('home', compact('featuredPosts', 'categoriesWithPosts'));
    }

    /**
     * ---------------------------------------------------------
     * แสดงข่าวทั้งหมด (แบบแบ่งหน้า)
     * ---------------------------------------------------------
     */
    public function allPosts(): View
    {
        $posts = Post::select('id', 'title', 'image_path', 'created_at', 'category_id')
            ->with('category:id,name')
            ->latest()
            ->paginate(12);

        return view('all-posts', compact('posts'));
    }

    /**
     * ---------------------------------------------------------
     * หน้าอ่านข่าว (แสดงข่าวที่เกี่ยวข้อง)
     * ---------------------------------------------------------
     */
    public function show($id): View
    {
        // 1. ดึงข้อมูลโพสต์หลัก (ใช้ id เพราะ URL พู่กันมาเป็น id)
        $post = Post::findOrFail($id);
        $post->load('category:id,name');

        // 2. ดึง "ประกาศวิทยาลัยเทคนิคแม่สอด" 3 อันล่าสุด
        $announcements = Post::whereHas('category', function ($q) {
            $q->where('name', 'ประกาศวิทยาลัยเทคนิคแม่สอด');
        })->where('id', '!=', $id)->latest()->take(3)->get();

        // 3. ดึง "กิจกรรมและประชาสัมพันธ์" 3 อันล่าสุด 
        // และส่งไปในชื่อ $relatedPosts เพื่อให้หน้า Blade เดิมทำงานได้ทันที
        $relatedPosts = Post::whereHas('category', function ($q) {
            $q->where('name', 'กิจกรรมและประชาสัมพันธ์');
        })->where('id', '!=', $id)->latest()->take(3)->get();

        // เปลี่ยนจาก posts.show เป็น post-show ตามไฟล์ที่คุณมีจริง
        return view('post-show', compact('post', 'announcements', 'relatedPosts'));
    }
    /**
     * ---------------------------------------------------------
     * หน้าแสดงข่าวตามหมวดหมู่ (Category)
     * ---------------------------------------------------------
     */
    public function category(Category $category): View
    {
        $posts = $category->posts()
            ->select('id', 'title', 'image_path', 'created_at', 'category_id')
            ->with('category:id,name')
            ->latest()
            ->paginate(9);

        return view('category-show', compact('category', 'posts'));
    }

    /**
     * ---------------------------------------------------------
     * Private Helper: ดึงข่าวจาก Category ที่ระบุ
     * ---------------------------------------------------------
     *
     * @param int $categoryId หมวดหมู่
     * @param int|null $paginate จำนวนต่อหน้า (ถ้ามี)
     * @param int|null $excludeId ID ข่าวที่ต้องการละเว้น
     * @param int|null $limit จำนวนสูงสุด (ถ้าไม่ใช้ paginate)
     * @return LengthAwarePaginator|Collection
     */
    private function _getPostsByCategory(
        int $categoryId,
        ?int $paginate = null,
        ?int $excludeId = null,
        ?int $limit = null
    ): LengthAwarePaginator|Collection {
        $query = Post::select('id', 'title', 'image_path', 'category_id', 'created_at')
            ->where('category_id', $categoryId)
            ->latest();

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $paginate
            ? $query->paginate($paginate)
            : $query->take($limit ?? 3)->get();
    }
}
