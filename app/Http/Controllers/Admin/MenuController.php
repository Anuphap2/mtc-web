<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('children', 'parent')
                     ->orderByRaw('ISNULL(parent_id), parent_id ASC')
                     ->orderBy('order', 'asc')
                     ->paginate(15);

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.create', [
            'parentMenus' => $this->getParentMenus()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateMenu($request);

        Menu::create($data);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'สร้างเมนูสำเร็จ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', [
            'menu' => $menu,
            'parentMenus' => $this->getParentMenus($menu->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $this->validateMenu($request, $menu->id);

        $menu->update($data);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'อัปเดตเมนูสำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
                         ->with('success', 'ลบเมนูสำเร็จ');
    }

    /**
     * Validate menu data.
     */
    private function validateMenu(Request $request, int $ignoreId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'parent_id' => array_filter([
                'nullable',
                'integer',
                Rule::exists('menus', 'id'),
                $ignoreId ? Rule::notIn([$ignoreId]) : null
            ]),
        ]);
    }

    /**
     * Get parent menus for dropdown.
     */
    private function getParentMenus(int $excludeId = null)
    {
        $query = Menu::orderBy('name', 'asc')->select('id', 'name');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
    }
}
