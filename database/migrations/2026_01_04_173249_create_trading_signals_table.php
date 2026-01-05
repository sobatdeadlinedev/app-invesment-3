<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trading_signals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('entry_price', 15, 2)->nullable();
            $table->decimal('target_price', 15, 2)->nullable();
            $table->decimal('stop_loss', 15, 2)->nullable();
            $table->enum('status', ['open', 'closed', 'settled'])->default('open');
            $table->enum('result', ['win', 'loss'])->nullable();
            $table->decimal('rate_of_return', 5, 2)->nullable()->comment('Dalam persen, contoh: 60.00');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_signals');
    }
};
