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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code')->unique();

            // discount rule
            $table->enum('discount_type', ['fixed', 'percentage']);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 15, 2)->nullable();

            // voucher type
            $table->enum('voucher_type', ['admin', 'affiliate']);

            // usage control
            $table->integer('max_usage')->nullable();
            $table->integer('used_count')->default(0);

            // lifecycle
            $table->boolean('is_active')->default(true);
            $table->timestamp('expired_at')->nullable();

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
        Schema::dropIfExists('vouchers');
    }
};
