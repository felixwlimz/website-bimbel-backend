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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // ownership
            $table->uuid('user_id');
            $table->uuid('package_id');

            // voucher (optional)
            $table->uuid('voucher_id')->nullable();

            // affiliate trace (optional)
            $table->uuid('affiliate_id')->nullable();

            // invoice
            $table->string('invoice_number')->unique();

            // pricing snapshot
            $table->decimal('original_amount', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2);

            // payment
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();

            // lifecycle
            $table->enum('status', [
                'pending',
                'paid',
                'expired',
                'failed'
            ])->default('pending');

            // timing
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();

            // constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
