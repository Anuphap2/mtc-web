<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import
use Illuminate\Database\Eloquent\Relations\HasMany; // Import

class Menu extends Model
{
    use HasFactory;

    // เพิ่ม 'parent_id' เข้าไปใน $fillable
    protected $fillable = ['name', 'url', 'order', 'parent_id'];

    /**
     * ความสัมพันธ์: หาเมนูแม่ (Parent)
     * (เมนูย่อย 1 อัน เป็นของ เมนูแม่ 1 อัน)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * ความสัมพันธ์: หาเมนูย่อย (Children)
     * (เมนูแม่ 1 อัน มี เมนูย่อยได้หลายอัน)
     */
    public function children(): HasMany
    {
        // ต้องเรียงตาม 'order' ด้วย
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function actionButtons(): string
    {
        $editUrl = route('admin.menus.edit', $this->id);
        $deleteUrl = route('admin.menus.destroy', $this->id);

        return <<<HTML
<div class="flex items-center justify-center space-x-3">
    <a href="{$editUrl}" class="text-indigo-600 hover:text-indigo-900" title="แก้ไข">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
        </svg>
    </a>
    <button type="button" onclick="openDeleteModal('{$deleteUrl}', '{$this->name}')" class="text-red-600 hover:text-red-900" title="ลบ">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
    </button>
</div>
HTML;
    }
}
