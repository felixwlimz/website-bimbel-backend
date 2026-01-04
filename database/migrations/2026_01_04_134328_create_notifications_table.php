<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi user (nullable = broadcast)
            $table->uuid('user_id')->nullable();

            // Target role untuk broadcast
            $table->string('role_target')->nullable(); 
            // contoh: user | admin | super_admin

            $table->string('title');
            $table->text('message');

            $table->string('type'); 
            // payment | affiliate | system | content

            $table->string('action_url')->nullable();

            $table->boolean('is_read')->default(false);

            $table->timestamps();

            // FK
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            // Index penting
            $table->index(['user_id', 'role_target']);
            $table->index('type');
            $table->index('is_read');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
