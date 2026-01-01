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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('affiliate_id');
            $table->foreign('affiliate_id')
                ->references('id')
                ->on('affiliates')
                ->onDelete('cascade');

            $table->decimal('amount', 15, 2);

            // snapshot rekening
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');

            // lifecycle
            $table->enum('status', [
                'pending',    // diajukan affiliate
                'approved',   // disetujui admin
                'paid',       // dana dikirim
                'rejected'
            ])->default('pending');

            // approval
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal');
    }
};
