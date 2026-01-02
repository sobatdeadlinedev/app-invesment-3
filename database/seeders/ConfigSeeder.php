<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                'key' => 'app_name',
                'value' => ['value' => 'My Website'],
            ],
            [
                'key' => 'app_logo',
                'value' => ['value' => 'Website logo here'],
            ],
            [
                'key' => 'app_announcement',
                'value' => ['value' => ''],
            ],
        ];

        foreach ($configs as $config) {
            Config::updateOrCreate(
                ['key' => $config['key']],
                ['value' => $config['value']]
            );
        }
    }
}
