<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobApplication;
class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $fillable = [
        'title',
        'description',
        'location',
        'is_active'
    ];

    public function applications()
    {
        return $this->hasMany(Job_application::class, 'career_id');
    }
}