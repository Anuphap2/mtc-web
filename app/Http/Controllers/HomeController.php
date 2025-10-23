<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * หน้าแรก
     */
    public function index()
    {
        // ดึงข่าวล่าสุด (พร้อม category) มาแสดง
        $posts = Post::with('category')->latest()->paginate(6);
        return view('home', compact('posts'));
    }

    /**
     * หน้าอ่านข่าว (ใช้ Route Model Binding)
     */
    public function show(Post $post)
    {
        // โหลด category มาด้วย
        $post->load('category');
        return view('post-show', compact('post'));
    }

    /**
     * หน้าแสดงข่าวตามประเภท (ใช้ Route Model Binding)
     */
    public function category(Category $category)
    {
        // ดึงข่าวเฉพาะใน category นี้
        $posts = $category->posts()->latest()->paginate(6);
        return view('category-show', compact('category', 'posts'));
    }
}