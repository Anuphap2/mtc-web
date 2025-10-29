<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * แสดงรายการ Category
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * ฟอร์มสร้าง Category ใหม่
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * บันทึก Category ใหม่
     */
    public function store(Request $request)
    {
        $data = $this->validateCategory($request);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'สร้างประเภทข่าวสำเร็จ');
    }

    /**
     * ฟอร์มแก้ไข Category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * อัปเดต Category
     */
    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request, $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'อัปเดตประเภทข่าวสำเร็จ');
    }

    /**
     * ลบ Category
     */
    public function destroy(Category $category)
    {
        // ตรวจสอบว่ามี post หรือไม่ก่อนลบ (ถ้าต้องการป้องกัน)
        // if ($category->posts()->exists()) {
        //     return redirect()->route('admin.categories.index')
        //                      ->with('error', 'ไม่สามารถลบประเภทข่าวที่มีข่าวอยู่ได้');
        // }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'ลบประเภทข่าวสำเร็จ');
    }

    

    /** ----------------- Private Helper ----------------- */

    /**
     * Validate Category
     *
     * @param Request $request
     * @param int|null $ignoreId
     * @return array
     */
    private function validateCategory(Request $request, int $ignoreId = null): array
    {
        $uniqueRule = $ignoreId
            ? Rule::unique('categories')->ignore($ignoreId)
            : Rule::unique('categories');

        return $request->validate([
            'name' => ['required', 'string', 'max:255', $uniqueRule],
        ]);
    }
}
