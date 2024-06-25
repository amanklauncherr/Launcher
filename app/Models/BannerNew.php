<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerNew extends Model
{
    use HasFactory;
    protected $fillable=[
        'Banner_No',
        'Banner_heading',
        'Banner_image'
    ];
}
