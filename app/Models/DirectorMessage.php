<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectorMessage extends Model
{
    protected $fillable = ['name', 'position', 'image', 'message'];
}
