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
            'name' => 'Admin',
            'telephone' => '083111694569',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), 
            'foto' => 'default.jpg',
            'role'=> 'admin',
        ]);
        User::factory()->count(5)->create(); 
    }
}
