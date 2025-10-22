<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // เพิ่ม Rule สำหรับ validation

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'embed_link' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // <-- เพิ่ม validation สำหรับ PDF (10MB)
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts/images', 'public'); // เก็บรูปใน posts/images
        }

        $pdfPath = null; // <-- เพิ่มตัวแปร pdfPath
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('posts/pdfs', 'public'); // <-- เก็บ PDF ใน posts/pdfs
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'embed_link' => $request->embed_link,
            'image_path' => $imagePath,
            'pdf_path' => $pdfPath, // <-- เพิ่ม pdf_path ตอนสร้าง
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
            'embed_link' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // <-- เพิ่ม validation สำหรับ PDF
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            // ลบรูปเก่า (ถ้ามี)
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts/images', 'public');
        }

        $pdfPath = $post->pdf_path; // <-- เพิ่มการจัดการ PDF
        if ($request->hasFile('pdf')) {
            // ลบ PDF เก่า (ถ้ามี)
            if ($post->pdf_path) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $pdfPath = $request->file('pdf')->store('posts/pdfs', 'public');
        } elseif ($request->boolean('remove_pdf')) { // <-- เพิ่มเงื่อนไขสำหรับลบ PDF
             if ($post->pdf_path) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $pdfPath = null;
        }


        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'embed_link' => $request->embed_link,
            'image_path' => $imagePath,
            'pdf_path' => $pdfPath, // <-- เพิ่ม pdf_path ตอนอัปเดต
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'อัปเดตข่าวสำเร็จ');
    }

    public function destroy(Post $post)
    {
        // ลบรูป (ถ้ามี)
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        // ลบ PDF (ถ้ามี)
        if ($post->pdf_path) {
            Storage::disk('public')->delete($post->pdf_path);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'ลบข่าวสำเร็จ');
    }
}