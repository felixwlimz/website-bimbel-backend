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
        Schema::create('answer_sheets', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->uuid('package_id');
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onDelete('cascade');

            // lifecycle
            $table->enum('status', ['started', 'submitted', 'expired'])
                ->default('started');

            // timing
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            // result (diisi saat submit)
            $table->integer('total_score')->nullable();
            $table->boolean('passing')->nullable();

            $table->timestamps();

            // Optional: cegah multiple attempt aktif
            $table->unique(['user_id', 'package_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_sheets');
    }
};
