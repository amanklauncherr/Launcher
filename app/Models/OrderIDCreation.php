<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIDCreation extends Model
{
    use HasFactory;

    protected $fillable=[
        'OrderDetails',
        'OrderID'
    ];
}
