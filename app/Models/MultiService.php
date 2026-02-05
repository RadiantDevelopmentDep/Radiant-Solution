<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiService extends Model
{
    protected $table = 'multi_services';

    protected $fillable = ['name', 'email', 'services', 'message','status'];

    protected $casts = [
        'services' => 'array',
    ];
}