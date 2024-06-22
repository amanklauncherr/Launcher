<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'company_address',
        'company_email',
        'company_contact',
        'company_timing',
    ];
}
