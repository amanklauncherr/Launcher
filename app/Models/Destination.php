<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'thumbnail_image',
        'images',
        'short_description',
        'description',
    ];
}
