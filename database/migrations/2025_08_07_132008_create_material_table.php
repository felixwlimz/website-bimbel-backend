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
        Schema::create('material', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->string('title');
            $table->string('drive_link');
            $table->boolean('preview');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
