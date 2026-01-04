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
        Schema::create('affiliate_bank_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('affiliate_id');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');

            $table->timestamps();

            $table->foreign('affiliate_id')
                ->references('id')
                ->on('affiliates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_bank_accounts');
    }
};
