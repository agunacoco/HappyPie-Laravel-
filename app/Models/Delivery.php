<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'payment_id',
        'addr1',
        'addr2',
        'detailaddr',
        'phone',
        "receiver",
    ];
}
