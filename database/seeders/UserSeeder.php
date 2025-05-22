<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'telephone' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // atau bcrypt('password123')
            'foto' => 'default.jpg',
        ]);

         // Tambahkan user lain jika diperlukan
        User::factory()->count(5)->create(); // jika kamu punya UserFactory
    }
}
