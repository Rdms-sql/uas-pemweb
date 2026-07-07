<?php

namespace Database\Seeders;

use App\Models\Agen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgenSeeder extends Seeder
{
    public function run(): void
    {
        $agens = [

            // ===========================
            // LEVEL 1 - PUSLIA
            // ===========================
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.agen1@kampuscare.com',
                'password' => 'budi123',
                'level_agen' => 1,
                'unit_kerja' => 'Puslia',
                'no_telepon' => '081234567001',
            ],
            [
                'nama' => 'Siti Rahma',
                'email' => 'siti.agen1@kampuscare.com',
                'password' => 'siti123',
                'level_agen' => 1,
                'unit_kerja' => 'Puslia',
                'no_telepon' => '081234567002',
            ],

            // ===========================
            // LEVEL 2 - BAAK
            // ===========================
            [
                'nama' => 'Ahmad Fauzi S. Pd, M.M',
                'email' => 'ahmad.agen2@kampuscare.com',
                'password' => 'ahmad123',
                'level_agen' => 2,
                'unit_kerja' => 'BAAK',
                'no_telepon' => '081234567003',
            ],
            [
                'nama' => 'Dewi Lestari S.M.',
                'email' => 'dewi.agen2@kampuscare.com',
                'password' => 'dewi123',
                'level_agen' => 2,
                'unit_kerja' => 'BAAK',
                'no_telepon' => '081234567004',
            ],

            // ===========================
            // LEVEL 3 - WAKIL REKTOR
            // ===========================
            [
                'nama' => 'Prof. Andrew Joestar',
                'email' => 'andrew@kampuscare.com',
                'password' => '089668689086',
                'level_agen' => 3,
                'unit_kerja' => 'Wakil Rektor Bidang Akademik',
                'no_telepon' => '081234567005',
            ],
        ];

        foreach ($agens as $agen) {

            Agen::updateOrCreate(

                [
                    'email' => $agen['email'],
                ],

                [
                    'nama'        => $agen['nama'],
                    'password'    => Hash::make($agen['password']),
                    'level_agen'  => $agen['level_agen'],
                    'unit_kerja'  => $agen['unit_kerja'],
                    'no_telepon'  => $agen['no_telepon'],
                    'is_active'   => true,
                    'is_verified' => true,
                ]
            );
        }
    }
}