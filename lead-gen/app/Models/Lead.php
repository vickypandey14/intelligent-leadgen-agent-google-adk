<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'query',
        'company_name',
        'website',
        'location',
        'industry',
        'score',
    ];
}
