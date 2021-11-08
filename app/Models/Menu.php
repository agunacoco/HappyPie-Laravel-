<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu(k)',
        'menu(e)',
        'content',
        'image',
        '가격',
        'user_id',
    ];

}