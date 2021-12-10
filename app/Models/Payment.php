<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'aid',
        'user_id',
        'order_id',
        'item_code',
        'item_name',
        'approved_at',
        'total',
        'quantity',
        'order_status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function menus(){
        return $this->belongsToMany(Menu::class)->withPivot(['count']);
    }

    public function delivery(){
        return $this->hasOne(Delivery::class);
    }

}
