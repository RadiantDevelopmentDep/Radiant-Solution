<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Career;
class Job_application extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'applicant_name',
        'applicant_email',
        'resume_path',
        'cover_letter',
        'status'
    ];

   
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id');
    }
}