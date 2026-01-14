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
            [
                'key' => 'app_wallet_address',
                'value' => [
                    'name' => 'bep 20',
                    'number' => '1234567890'
                ],
            ],
            [
                'key' => 'app_email',
                'value' => ['value' => 'jamesbond130694@gmail.com'],
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
