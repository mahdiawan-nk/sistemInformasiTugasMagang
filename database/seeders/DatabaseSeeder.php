<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $users = [
            // ADMIN
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@kampus.ac.id',
                'phone_number' => '081234567890',
                'asal_perguruan_tinggi' => null,
                'jenis_kelamin' => 'Laki-laki',
                'status' => 'Aktif',
                'role' => 'Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@kampus.ac.id',
                'phone_number' => '081111111111',
                'asal_perguruan_tinggi' => null,
                'jenis_kelamin' => 'Perempuan',
                'status' => 'Aktif',
                'role' => 'Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],

            // MAHASISWA
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@student.ac.id',
                'phone_number' => '082233445566',
                'asal_perguruan_tinggi' => 'Politeknik Kampar',
                'jenis_kelamin' => 'Laki-laki',
                'status' => 'Aktif',
                'role' => 'Mahasiswa',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Siti Aisyah',
                'email' => 'siti@student.ac.id',
                'phone_number' => '081122334455',
                'asal_perguruan_tinggi' => 'Universitas Riau',
                'jenis_kelamin' => 'Perempuan',
                'status' => 'Aktif',
                'role' => 'Mahasiswa',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@student.ac.id',
                'phone_number' => '089988776655',
                'asal_perguruan_tinggi' => 'Politeknik Negeri',
                'jenis_kelamin' => 'Laki-laki',
                'status' => 'Tidak Aktif',
                'role' => 'Mahasiswa',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $item) {
            User::updateOrCreate(
                ['email' => $item['email']],
                $item
            );
        }
    }
}
