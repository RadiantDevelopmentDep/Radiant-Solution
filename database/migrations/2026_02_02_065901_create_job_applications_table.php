<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained()->onDelete('cascade');
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('resume_path'); 
            $table->text('cover_letter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
