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
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        // Create member user (verified)
        $member = User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'phone' => '081234567892',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'is_verified' => true,
        ]);
        $member->assignRole('member');

        // Create member user (unverified) - untuk testing approval flow
        $unverifiedMember = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'phone' => '081234567893',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'is_verified' => false,
        ]);
        $unverifiedMember->assignRole('member');
    }
}
