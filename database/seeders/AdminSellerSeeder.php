<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class AdminSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $admin = Seller::where('email', 'admin_luxvault@gmail.com')->first();
        
        if (!$admin) {
            Seller::create([
                'fname' => 'Admin',
                'lname' => 'LuxVault',
                'email' => 'admin_luxvault@gmail.com',
                'phone' => null,
                'password' => Hash::make('admin@luxvault123'),
                'is_admin' => true,
            ]);
            
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
