<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');
            $table->string('referral_code');
            $table->timestamp('used_at');
            $table->timestamps();

            // Indexes
            $table->index('referrer_id');
            $table->index('referred_id');
            $table->index('referral_code');

            // Ensure a user can only use one referral code
            $table->unique('referred_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_usages');
    }
};
