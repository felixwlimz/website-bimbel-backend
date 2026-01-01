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

            $table->uuid('package_id');
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onDelete('cascade');

            // content
            $table->string('title');
            $table->text('content');

            // media
            $table->enum('media_type', ['none', 'image', 'audio', 'video'])
                ->default('none');
            $table->string('media_path')->nullable();

            // scoring
            $table->unsignedInteger('weight')->default(1);

            // classification
            $table->uuid('sub_topic_id')->nullable();

            // explanation
            $table->text('explanation')->nullable();

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
