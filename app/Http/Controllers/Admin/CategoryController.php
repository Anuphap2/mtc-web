<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
// Removed Str and Rule imports as slug is removed

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate only name
        $request->validate([
            'name' => 'required|string|max:255|unique:categories', // Added unique check here
        ]);

        // Create with only name
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'สร้างประเภทข่าวสำเร็จ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate only name, check uniqueness ignoring self
        $request->validate([
            'name' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('categories')->ignore($category->id)],
        ]);

        // Update only name
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'อัปเดตประเภทข่าวสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Optional: Add check if category has posts before deleting
        // if ($category->posts()->count() > 0) {
        //     return redirect()->route('admin.categories.index')->with('error', 'ไม่สามารถลบประเภทข่าวที่มีข่าวอยู่ได้');
        // }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'ลบประเภทข่าวสำเร็จ');
    }
}
