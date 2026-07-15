<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@penggajian.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('User admin berhasil dibuat!');
        $this->command->info('Email: admin@penggajian.com');
        $this->command->info('Password: password123');
    }
}