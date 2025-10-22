<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // อนุญาตให้กรอก 2 ฟิลด์นี้
    protected $fillable = ['name', 'slug'];

    /**
     * ความสัมพันธ์: 1 Category มีได้หลาย Post
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}