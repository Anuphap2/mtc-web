<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create', [
            'parentMenus' => $this->getParentMenus()
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateMenu($request);
        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success', 'สร้างเมนูสำเร็จ');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', [
            'menu' => $menu,
            'parentMenus' => $this->getParentMenus($menu->id)
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $this->validateMenu($request, $menu->id);
        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', 'อัปเดตเมนูสำเร็จ');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'ลบเมนูสำเร็จ');
    }

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

    private function getParentMenus(int $excludeId = null)
    {
        $query = Menu::orderBy('name', 'asc')->select('id', 'name');
        if ($excludeId) $query->where('id', '!=', $excludeId);
        return $query->get();
    }

    public function actionButtons(Menu $menu): string
    {
        $editUrl = route('admin.menus.edit', $menu->id);
        $deleteUrl = route('admin.menus.destroy', $menu->id);

        return <<<HTML
<div class="flex items-center justify-center space-x-3">
    <a href="{$editUrl}" class="text-indigo-600 hover:text-indigo-900" title="แก้ไข">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
        </svg>
    </a>
    <button type="button" onclick="openDeleteModal('{$deleteUrl}', '{$menu->name}')" class="text-red-600 hover:text-red-900" title="ลบ">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
    </button>
</div>
HTML;
    }
}
