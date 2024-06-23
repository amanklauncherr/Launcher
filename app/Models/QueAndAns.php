<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueAndAns extends Model
{
    use HasFactory;
    protected $fillable=[
        'Question',
        'Answer'
    ];
}
