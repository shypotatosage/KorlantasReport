<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'location',
        'time',
        'report',
        'picture',
        'status',
        'user_id',
    ];
}
