<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'nama'       => 'Admin KampusCare',
            'email'      => 'admin@kampuscare.com',
            'password'   => Hash::make('admin123'),
            'jabatan'    => 'Lektor',
            'is_active'  => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}