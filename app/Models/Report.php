<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'title',
        'location',
        'time',
        'picture',
        'status',
        'user_id',
    ];
}
