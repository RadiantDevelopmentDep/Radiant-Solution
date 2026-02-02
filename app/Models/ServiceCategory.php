<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    /* 
    |---------------------------------------
    | Relationships
    |---------------------------------------
    */

    // Category → Many Services
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
