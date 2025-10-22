<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str
use Illuminate\Validation\Rule; // Import Rule

class CategoryController extends Controller
{
    /**
     * แสดงหน้าตาราง
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * แสดงหน้าฟอร์มสำหรับสร้าง
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * บันทึกข้อมูล
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug), // ใช้ Str::slug เพื่อให้เป็น URL ที่สวยงาม
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'สร้างประเภทข่าวสำเร็จ');
    }

    /**
     * แสดงหน้าฟอร์มสำหรับแก้ไข
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * อัปเดตข้อมูล
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // ตรวจสอบ slug ว่าซ้ำหรือไม่ โดย "ยกเว้น" ID ของตัวเอง
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'อัปเดตประเภทข่าวสำเร็จ');
    }

    /**
     * ลบข้อมูล
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'ลบประเภทข่าวสำเร็จ');
    }
}