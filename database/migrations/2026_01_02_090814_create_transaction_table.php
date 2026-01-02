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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('reference')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['deposit', 'withdrawal', 'commission']);
            $table->foreignId('wallet_id')->nullable()->constrained('wallets')->onDelete('set null');
            $table->decimal('withdrawal_fee', 15, 2)->nullable()->default(0);
            $table->foreignId('source_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes untuk performance
            $table->index('user_id');
            $table->index('type');
            $table->index('status');
            $table->index('reference');
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
