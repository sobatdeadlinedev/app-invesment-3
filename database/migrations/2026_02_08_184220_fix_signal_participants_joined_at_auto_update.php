<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Hapus ON UPDATE CURRENT_TIMESTAMP dari joined_at
        DB::statement('
            ALTER TABLE signal_participants 
            MODIFY COLUMN joined_at TIMESTAMP NULL DEFAULT NULL
        ');
        
        echo "✅ Fixed: joined_at no longer auto-updates\n";
    }

    public function down()
    {
        // Rollback (not recommended)
        DB::statement('
            ALTER TABLE signal_participants 
            MODIFY COLUMN joined_at TIMESTAMP NOT NULL 
            DEFAULT CURRENT_TIMESTAMP 
            ON UPDATE CURRENT_TIMESTAMP
        ');
    }
};