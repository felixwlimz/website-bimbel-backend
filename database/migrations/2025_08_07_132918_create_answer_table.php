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
        Schema::create('answer', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('answer_sheet_id');
            $table->foreign('answer_sheet_id')->references('id')->on('answer_sheets')->onDelete('cascade');
            $table->uuid('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
