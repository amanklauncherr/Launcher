<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'image',
        'short_description'
    ];
}
