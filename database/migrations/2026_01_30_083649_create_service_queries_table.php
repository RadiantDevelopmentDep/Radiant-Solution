<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('service_queries', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->text('message');
        $table->string('service_slug');
        $table->string('service_category');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_queries');
    }
};
