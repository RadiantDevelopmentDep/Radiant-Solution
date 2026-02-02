<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'name',
        'slug',
        'description',
    ];

    /* 
    |---------------------------------------
    | Relationships
    |---------------------------------------
    */

    // Service → Category
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    // Service → Many Sub Services
    public function subServices()
    {
        return $this->hasMany(SubService::class);
    }
}
