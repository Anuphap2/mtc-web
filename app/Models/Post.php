<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'embed_link',
        'pdf_path',
        'category_id',
        'is_featured', // <-- เพิ่มบรรทัดนี้
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean', // <-- เพิ่มบรรทัดนี้
    ];


    /**
     * ความสัมพันธ์: 1 Post อยู่ใน 1 Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
