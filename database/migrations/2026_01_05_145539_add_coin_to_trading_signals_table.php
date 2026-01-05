<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trading_signals', function (Blueprint $table) {
            $table->string('coin', 20)->after('title')->default('BTC'); // BTC, ETH, DOGE, dll
            $table->index('coin');
        });
    }

    public function down(): void
    {
        Schema::table('trading_signals', function (Blueprint $table) {
            $table->dropIndex(['coin']);
            $table->dropColumn('coin');
        });
    }
};
