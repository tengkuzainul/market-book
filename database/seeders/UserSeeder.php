<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Administrator Shop',
                'email' => 'admin@shopping.test',
                'password' => bcrypt('admin2025'),
                'role' => 'Administrator',
            ],
            [
                'name' => 'Customer Test',
                'email' => 'customer@shopping.test',
                'password' => bcrypt('password'),
                'role' => 'Customer',
            ],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
