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
    Schema::table('job_applications', function (Blueprint $table) {
        $table->enum('status', ['pending', 'reviewed', 'interview', 'onboard', 'rejected'])
              ->default('pending')
              ->after('cover_letter');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            //
        });
    }
};
