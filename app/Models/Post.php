<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    // อนุญาตให้กรอกทุกฟิลด์นี้
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'embed_link',
        'category_id',
    ];

    /**
     * ความสัมพันธ์: 1 Post อยู่ใน 1 Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}