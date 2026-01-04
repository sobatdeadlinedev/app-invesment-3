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
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Basic Verification Fields
            $table->string('full_name')->nullable();
            $table->string('identity_number')->nullable();
            $table->enum('identity_type', ['KTP', 'SIM', 'Paspor'])->nullable();
            $table->string('identity_photo_path')->nullable();
            $table->string('selfie_with_identity_path')->nullable();

            // Timestamps untuk tracking
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            // Index untuk performa
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_verifications');
    }
};
