<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // อนุญาตให้กรอก 3 ฟิลด์นี้
    protected $fillable = ['name', 'url', 'order'];
}