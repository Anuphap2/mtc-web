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
}
