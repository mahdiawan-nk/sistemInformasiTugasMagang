<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Membuat Landing Page Company Profile',
                'description' => 'Buat landing page menggunakan HTML, CSS, dan JavaScript dengan desain modern.',
                'point' => 100,
            ],
            [
                'title' => 'Implementasi CRUD Laravel',
                'description' => 'Buat fitur CRUD sederhana menggunakan Laravel untuk data mahasiswa.',
                'point' => 80,
            ],
            [
                'title' => 'Desain UI Dashboard Admin',
                'description' => 'Desain dashboard admin menggunakan Figma atau Tailwind CSS.',
                'point' => 90,
            ],
            [
                'title' => 'Membuat REST API Laravel',
                'description' => 'Buat API untuk manajemen data produk lengkap dengan autentikasi.',
                'point' => 110,
            ],
            [
                'title' => 'Integrasi API ke Frontend',
                'description' => 'Integrasikan API Laravel ke frontend menggunakan fetch.',
                'point' => 85,
            ],
            [
                'title' => 'Membuat Form Validation',
                'description' => 'Implementasi validasi form di Laravel dan JavaScript.',
                'point' => 70,
            ],
            [
                'title' => 'Optimasi Query Database',
                'description' => 'Analisa dan optimasi query agar lebih efisien.',
                'point' => 95,
            ],
            [
                'title' => 'Membuat Fitur Upload File',
                'description' => 'Implementasi upload file dan penyimpanan di storage Laravel.',
                'point' => 75,
            ],
            [
                'title' => 'Membuat Sistem Login',
                'description' => 'Buat sistem login dengan autentikasi Laravel.',
                'point' => 100,
            ],
            [
                'title' => 'Membuat Dashboard Statistik',
                'description' => 'Buat dashboard dengan chart menggunakan Chart.js.',
                'point' => 120,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create([
                'title' => $task['title'],
                'description' => $task['description'],
                'point' => $task['point'],

                // Deadline max 7 hari dari sekarang
                'deadline_post' => Carbon::now()->addDays(rand(3, 7)),

                // Belum diambil
                'deadline_taken' => null,
                'user_id' => null,

                // Belum ada submission
                'submission_file' => null,
                'submission_date' => null,

                // Belum evaluasi
                'final_point' => null,
                'evaluation_notes' => null,

                // Status available
                'status' => 'available',
            ]);
        }
    }
}
