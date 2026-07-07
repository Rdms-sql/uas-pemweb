<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID'); // locale Indonesia

        $prodis = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi', 'Teknik Sipil'];

        for ($i = 1; $i <= 15; $i++) {
            $tanggal = now()->subDays(rand(1, 60))->format('ymd');

            DB::table('mahasiswas')->insert([
                'nim'           => $tanggal . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama'          => $faker->name(),
                'email'         => 'mhs' . $i . '@kampuscare.com',
                'password'      => Hash::make('mahasiswa123'),
                'program_studi' => $prodis[array_rand($prodis)],
                'semester'      => rand(1, 8),
                'no_telepon'    => $faker->phoneNumber(),
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}