<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create mahasiswa record for user id 6 (mhs@gmail.com)
        $mahasiswa = Mahasiswa::create([
            'user_id' => 6,
            'nim' => '2021001',
            'angkatan' => 2021,
        ]);

        // Link existing tugas akhir to this mahasiswa
        $tugasAkhir = TugasAkhir::all();
        foreach ($tugasAkhir as $tugas) {
            $mahasiswa->tugasAkhir()->attach($tugas->id);
        }
    }
}
