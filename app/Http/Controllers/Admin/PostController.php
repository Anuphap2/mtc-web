<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage

class PostController extends Controller
{
    public function index()
    {
        // ใช้ with('category') เพื่อแก้ปัญหา N+1 Query
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all(); // ดึง Category ทั้งหมดไปให้ View
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // บันทึกไฟล์ลง storage/app/public/posts
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'embed_link' => $request->embed_link,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'สร้างข่าวสำเร็จ');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $post->image_path; // ใช้รูปเดิมเป็นค่าเริ่มต้น

        if ($request->hasFile('image')) {
            // ถ้ามีรูปใหม่มา ให้ลบรูปเก่า (ถ้ามี)
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            // บันทึกรูปใหม่
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'embed_link' => $request->embed_link,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'อัปเดตข่าวสำเร็จ');
    }

    public function destroy(Post $post)
    {
        // ลบรูปภาพออกจาก Storage ด้วย
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'ลบข่าวสำเร็จ');
    }
}