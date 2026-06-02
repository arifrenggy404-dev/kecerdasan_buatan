<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Course;
use App\Models\CourseOffering;
use App\Models\Lecturer;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Gedung & Ruangan
        $buildingC = Building::create(['name' => 'GEDUNG C']);
        
        $rooms = [
            ['name' => 'Ruang C 2.1', 'type' => 'theory', 'building_id' => $buildingC->id],
            ['name' => 'Ruang C 2.2', 'type' => 'theory', 'building_id' => $buildingC->id],
            ['name' => 'Ruang LAB KOMPUTER C 2.3', 'type' => 'lab', 'building_id' => $buildingC->id],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        // 2. Dosen
        $lecturers = [
            ['name' => 'DENISIUS UMBU PATI SKM., M.Kes'],
            ['name' => 'AMELIA FLORIDA KIHA S.Pt., M.Sc'],
            ['name' => 'YONCE MELYANUS KILLA S.P., M. P'],
            ['name' => 'ARIS UMBU HINA PARI S.AP., M.AP'],
            ['name' => 'MARSELINUS HAMBAKODU S.Pt, M.Si'],
            ['name' => 'Dosen Pengampu 6'],
            ['name' => 'Dosen Pengampu 7'],
            ['name' => 'Dosen Pengampu 8'],
        ];

        foreach ($lecturers as $l) {
            Lecturer::create($l);
        }

        // 3. Mata Kuliah & Plotting
        // Kita buat data contoh sesuai instruksi semester dari dosen
        $coursesData = [
            // Semester 2 (Angka pertama setelah spasi adalah 1)
            ['name' => 'Kewarganegaraan', 'code' => 'MKW21 104', 'sks' => 2, 'type' => 'theory', 'semester' => 2, 'lecturer_idx' => 0],
            ['name' => 'Fisika Dasar', 'code' => 'PTK21 102', 'sks' => 3, 'type' => 'theory', 'semester' => 2, 'lecturer_idx' => 1],
            ['name' => 'Ekologi Sabana', 'code' => 'PTK21 107', 'sks' => 2, 'type' => 'theory', 'semester' => 2, 'lecturer_idx' => 2],
            
            // Semester 4 (Angka pertama setelah spasi adalah 2)
            ['name' => 'Statistika', 'code' => 'PTK21 210', 'sks' => 3, 'type' => 'lab', 'semester' => 4, 'lecturer_idx' => 3],
            ['name' => 'Kesehatan Ternak', 'code' => 'PTK21 209', 'sks' => 3, 'type' => 'theory', 'semester' => 4, 'lecturer_idx' => 4],
            ['name' => 'Ilmu Reproduksi Ternak', 'code' => 'PTK21 208', 'sks' => 3, 'type' => 'theory', 'semester' => 4, 'lecturer_idx' => 5],
            
            // Semester 6 (Angka pertama setelah spasi adalah 3)
            ['name' => 'Kebijakan Pembangunan Peternakan', 'code' => 'PTK21 307', 'sks' => 2, 'type' => 'theory', 'semester' => 6, 'lecturer_idx' => 6],
            ['name' => 'Teknologi dan Rekayasa Ilmu Pangan', 'code' => 'PTK21 319', 'sks' => 3, 'type' => 'lab', 'semester' => 6, 'lecturer_idx' => 7],
        ];

        $allLecturers = Lecturer::all();

        foreach ($coursesData as $data) {
            $course = Course::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'sks' => $data['sks'],
                'type' => $data['type'],
                'semester' => $data['semester'],
            ]);

            CourseOffering::create([
                'course_id' => $course->id,
                'lecturer_id' => $allLecturers[$data['lecturer_idx']]->id,
                'sks' => $data['sks'],
                'type' => $data['type'],
            ]);
        }
    }
}
