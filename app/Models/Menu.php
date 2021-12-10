<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menuK',
        'menuE',
        'content',
        'image',
        'price',
        'user_id',
    ];

    public function categories(){
        return $this->hasMany(Category::class); 
    }

    public function payments(){
        return $this->belongsToMany(Payment::class)->withPivot(['count']);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot([
            'count'
        ])->withTimestamps();
    }

}
