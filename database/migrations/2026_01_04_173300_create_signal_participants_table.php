<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signal_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signal_id')->constrained('trading_signals')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('bet_amount', 15, 2);
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->decimal('fee_amount', 15, 2)->default(0);
            $table->enum('status', ['joined', 'settled'])->default('joined');
            $table->timestamp('joined_at');
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();

            $table->index(['signal_id', 'user_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signal_participants');
    }
};
