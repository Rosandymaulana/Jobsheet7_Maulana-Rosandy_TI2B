<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matkul = [
            [
                'nama_matkul' => 'Pemrogaman Berbasis Objek',
                'sks' => 3,
                'jam' => 6,
                'semester' => 4,
            ],
            [
                'nama_matkul' => 'Pemrogaman Web Lanjut',
                'sks' => 3,
                'jam' => 6,
                'semester' => 4,
            ],
            [
                'nama_matkul' => 'Basis Data Lanjut',
                'sks' => 3,
                'jam' => 4,
                'semester' => 4,
            ],
            [
                'nama_matkul' => 'Praktikum Basis Data Lanjut',
                'sks' => 3,
                'jam' => 6,
                'semester' => 4,
            ],
        ];

        DB::table('matakuliah')->insert($matkul);

        DB::table('mahasiswa_matakuliah')->insert([
            [
                'mahasiswa_id' => '1',
                'matakuliah_id' => 1,
                'nilai' => 'A',
            ],
            [
                'mahasiswa_id' => '1',
                'matakuliah_id' => 2,
                'nilai' => 'A',
            ],
            [
                'mahasiswa_id' => '1',
                'matakuliah_id' => 3,
                'nilai' => 'A',
            ],
            [
                'mahasiswa_id' => '1',
                'matakuliah_id' => 4,
                'nilai' => 'A',
            ],
        ]);
    }
}
