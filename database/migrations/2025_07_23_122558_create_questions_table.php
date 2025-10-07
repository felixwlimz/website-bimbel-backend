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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judulSoal');
            $table->enum('jenisSoal', ['teks', 'gambar', 'audio']);
            $table->uuid('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->text('isiSoal');
            $table->string('mediaSoal')->nullable();
            $table->integer('bobot');
            $table->string('jawabanBenar');
            $table->text('pembahasan');
            $table->string('subMateri');
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
