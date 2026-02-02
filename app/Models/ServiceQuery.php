<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'service_slug',
        'service_category',
        'Status'
    ];
}
