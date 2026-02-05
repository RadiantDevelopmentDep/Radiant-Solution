<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('multi_services', function (Blueprint $table) {
           
            $table->dropColumn('services');
        });

        Schema::table('multi_services', function (Blueprint $table) {
            $table->json('services')->after('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('multi_services', function (Blueprint $table) {
            $table->dropColumn('services');
        });
    }
};