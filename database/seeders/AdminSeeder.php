<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role' => 'admin',
            'email' => 'admin@luxvault.com',
            'password' => Hash::make('admin123'),
            'status' => 'active',
            'blocked' => false,
            'created_at' => now(),
        ]);
    }
}

