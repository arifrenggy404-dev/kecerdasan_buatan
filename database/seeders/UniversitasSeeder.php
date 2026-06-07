<?php

namespace Database\Seeders;

use App\Models\Gedung;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class UniversitasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Gedung
        $gedungData = [
            ['nama' => 'GEDUNG A (Dekanat)'],
            ['nama' => 'GEDUNG B (Saintek)'],
            ['nama' => 'GEDUNG C (Laboratorium)'],
        ];

        $gedungs = [];
        foreach ($gedungData as $g) {
            $gedungs[] = Gedung::create($g);
        }

        // 2. Data Ruangan
        $ruanganData = [
            // Gedung A
            ['nama' => 'Ruang A.1.1', 'tipe' => 'teori', 'gedung_id' => $gedungs[0]->id],
            ['nama' => 'Ruang A.1.2', 'tipe' => 'teori', 'gedung_id' => $gedungs[0]->id],
            ['nama' => 'Aula Utama', 'tipe' => 'teori', 'gedung_id' => $gedungs[0]->id],
            
            // Gedung B
            ['nama' => 'Ruang B.2.1', 'tipe' => 'teori', 'gedung_id' => $gedungs[1]->id],
            ['nama' => 'Ruang B.2.2', 'tipe' => 'teori', 'gedung_id' => $gedungs[1]->id],
            ['nama' => 'Ruang B.2.3', 'tipe' => 'teori', 'gedung_id' => $gedungs[1]->id],
            
            // Gedung C
            ['nama' => 'Lab Komputer 1', 'tipe' => 'praktikum', 'gedung_id' => $gedungs[2]->id],
            ['nama' => 'Lab Komputer 2', 'tipe' => 'praktikum', 'gedung_id' => $gedungs[2]->id],
            ['nama' => 'Lab Bahasa', 'tipe' => 'praktikum', 'gedung_id' => $gedungs[2]->id],
        ];

        foreach ($ruanganData as $r) {
            Ruangan::create($r);
        }

        // 3. Data Dosen
        $dosenData = [
            ['nama' => 'Prof. Dr. Ir. Budi Santoso, M.T.'],
            ['nama' => 'Dr. Siti Aminah, S.Kom., M.Cs.'],
            ['nama' => 'Hendra Wijaya, S.T., M.T.'],
            ['nama' => 'Rina Permata, S.Si., M.Si.'],
            ['nama' => 'Andi Pratama, M.Kom.'],
            ['nama' => 'Maya Sari, S.Pd., M.Hum.'],
            ['nama' => 'Bambang Heru, Ph.D.'],
            ['nama' => 'Dewi Lestari, M.T.'],
            ['nama' => 'Eko Prasetyo, S.Kom.'],
            ['nama' => 'Fitriani, M.Sc.'],
        ];

        $dosens = [];
        foreach ($dosenData as $d) {
            $dosens[] = Dosen::create($d);
        }

        // 4. Data Mata Kuliah & Plotting Kelas
        $kurikulum = [
            // Semester 2
            ['nama' => 'Pancasila', 'kode' => 'MKU101', 'sks' => 2, 'tipe' => 'teori', 'semester' => 2, 'dosen_idx' => 5],
            ['nama' => 'Kalkulus Dasar', 'kode' => 'MAT201', 'sks' => 3, 'tipe' => 'teori', 'semester' => 2, 'dosen_idx' => 3],
            ['nama' => 'Algoritma & Pemrograman', 'kode' => 'TIF201', 'sks' => 4, 'tipe' => 'praktikum', 'semester' => 2, 'dosen_idx' => 1],
            ['nama' => 'Bahasa Inggris I', 'kode' => 'MKU102', 'sks' => 2, 'tipe' => 'teori', 'semester' => 2, 'dosen_idx' => 5],
            
            // Semester 4
            ['nama' => 'Basis Data', 'kode' => 'TIF401', 'sks' => 3, 'tipe' => 'praktikum', 'semester' => 4, 'dosen_idx' => 4],
            ['nama' => 'Sistem Operasi', 'kode' => 'TIF402', 'sks' => 3, 'tipe' => 'teori', 'semester' => 4, 'dosen_idx' => 8],
            ['nama' => 'Statistika Informatika', 'kode' => 'MAT401', 'sks' => 3, 'tipe' => 'teori', 'semester' => 4, 'dosen_idx' => 0],
            ['nama' => 'Arsitektur Komputer', 'kode' => 'TIF403', 'sks' => 3, 'tipe' => 'teori', 'semester' => 4, 'dosen_idx' => 2],
            
            // Semester 6
            ['nama' => 'Kecerdasan Buatan', 'kode' => 'TIF601', 'sks' => 3, 'tipe' => 'teori', 'semester' => 6, 'dosen_idx' => 1],
            ['nama' => 'Rekayasa Perangkat Lunak', 'kode' => 'TIF602', 'sks' => 3, 'tipe' => 'teori', 'semester' => 6, 'dosen_idx' => 7],
            ['nama' => 'Jaringan Komputer', 'kode' => 'TIF603', 'sks' => 3, 'tipe' => 'praktikum', 'semester' => 6, 'dosen_idx' => 8],
            ['nama' => 'Metodologi Penelitian', 'kode' => 'TIF604', 'sks' => 2, 'tipe' => 'teori', 'semester' => 6, 'dosen_idx' => 6],
            
            // Semester 8
            ['nama' => 'Etika Profesi', 'kode' => 'MKU801', 'sks' => 2, 'tipe' => 'teori', 'semester' => 8, 'dosen_idx' => 9],
            ['nama' => 'Kewirausahaan IT', 'kode' => 'TIF801', 'sks' => 2, 'tipe' => 'teori', 'semester' => 8, 'dosen_idx' => 0],
        ];

        foreach ($kurikulum as $mkData) {
            $mk = MataKuliah::create([
                'nama' => $mkData['nama'],
                'kode' => $mkData['kode'],
                'sks' => $mkData['sks'],
                'tipe' => $mkData['tipe'],
                'semester' => $mkData['semester'],
            ]);

            // Buat 2 kelas untuk setiap mata kuliah (Kelas A dan Kelas B)
            foreach (['A', 'B'] as $ab) {
                Kelas::create([
                    'mata_kuliah_id' => $mk->id,
                    'dosen_id' => $dosens[$mkData['dosen_idx']]->id,
                    'sks' => $mkData['sks'],
                    'tipe' => $mkData['tipe'],
                    'nama' => "Kelas $ab",
                ]);
            }
        }
    }
}
