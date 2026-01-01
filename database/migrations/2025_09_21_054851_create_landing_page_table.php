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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('slug')->unique();

            // content
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();

            // type & position
            $table->enum('type', [
                'hero',
                'section',
                'banner',
                'testimonial'
            ])->default('section');

            $table->unsignedInteger('order')->default(0);

            // publish lifecycle
            $table->enum('status', ['draft', 'published'])
                ->default('draft');

            // audit
            $table->uuid('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
