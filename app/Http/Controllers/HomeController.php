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
                'posts' => fn($q) => $q->latest()->take(3)
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
     * - แสดง related posts (Category ID = 2) ยกเว้นข่าวตัวเอง
     */
    public function show(Post $post): View
    {
        $post->load('category');

        $relatedPosts = $this->_getPostsByCategory(
            categoryId: 2,
            excludeId: $post->id,
            limit: 3
        );

        return view('post-show', compact('post', 'relatedPosts'));
    }

    /**
     * หน้าแสดงข่าวตาม Category
     */
    public function category(Category $category): View
    {
        $posts = $category->posts()
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
