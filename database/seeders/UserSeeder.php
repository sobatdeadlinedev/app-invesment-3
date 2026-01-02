<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'phone' => '081234567890',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        // Create member user
        $member = User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'phone' => '081234567892',
            'password' => bcrypt('password123'),
        ]);
        $member->assignRole('member');
    }
}
