<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu; // Make sure Menu model is imported
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for validation

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงเมนูทั้งหมด พร้อมกับเมนูย่อย (ถ้ามี) และเมนูแม่ (ถ้ามี)
        // เรียงตาม parent_id ก่อน แล้วค่อยเรียงตาม order
        $menus = Menu::with('children', 'parent')
                     ->orderByRaw('ISNULL(parent_id), parent_id ASC') // Group submenus under parent
                     ->orderBy('order', 'asc')
                     ->paginate(15); // Adjust pagination as needed
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // --- เพิ่มส่วนนี้ ---
        // ดึงเมนูทั้งหมดมาเป็นตัวเลือกสำหรับ Parent (เอาเฉพาะ ID กับ Name ก็พอ)
        // เรียงตามชื่อเพื่อให้เลือกง่าย
        $parentMenus = Menu::orderBy('name', 'asc')->get(['id', 'name']);
        // --- จบส่วนเพิ่ม ---

        // --- แก้ไขบรรทัดนี้ ---
        return view('admin.menus.create', compact('parentMenus')); // ส่ง $parentMenus ไปด้วย
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- แก้ไข Validation ---
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            // เพิ่ม validation สำหรับ parent_id
            // nullable คืออนุญาตให้เป็นค่าว่าง (เมนูหลัก)
            // exists:menus,id คือถ้ามีค่า ต้องเป็น id ที่มีอยู่จริงในตาราง menus
            'parent_id' => 'nullable|integer|exists:menus,id',
        ]);
        // --- จบส่วนแก้ไข Validation ---

        // --- แก้ไข Create ---
        Menu::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'order' => $validated['order'],
            'parent_id' => $validated['parent_id'], // เพิ่ม parent_id
        ]);
        // --- จบส่วนแก้ไข Create ---

        return redirect()->route('admin.menus.index')->with('success', 'สร้างเมนูสำเร็จ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
         // --- เพิ่มส่วนนี้ ---
        // ดึงเมนูทั้งหมดมาเป็นตัวเลือกสำหรับ Parent
        // ยกเว้น! เมนูตัวเอง (ป้องกันการเลือกตัวเองเป็น Parent)
         $parentMenus = Menu::where('id', '!=', $menu->id) // ไม่เอาตัวเอง
                            ->orderBy('name', 'asc')->get(['id', 'name']);
        // --- จบส่วนเพิ่ม ---

        // --- แก้ไขบรรทัดนี้ ---
        return view('admin.menus.edit', compact('menu', 'parentMenus')); // ส่ง $parentMenus ไปด้วย
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // --- แก้ไข Validation ---
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            // parent_id ต้อง nullable หรือ มีอยู่จริง และ ไม่ใช่ id ของตัวเอง
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menus', 'id'),
                Rule::notIn([$menu->id]), // ห้ามเลือกตัวเองเป็น Parent
            ],
        ]);
         // --- จบส่วนแก้ไข Validation ---

        // --- แก้ไข Update ---
        $menu->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'order' => $validated['order'],
            'parent_id' => $validated['parent_id'], // เพิ่ม parent_id
        ]);
        // --- จบส่วนแก้ไข Update ---

        return redirect()->route('admin.menus.index')->with('success', 'อัปเดตเมนูสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // การลบจะ cascade ไปลบ children ด้วย (ถ้าตั้งค่า onDelete('cascade') ใน migration)
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'ลบเมนูสำเร็จ');
    }
}
