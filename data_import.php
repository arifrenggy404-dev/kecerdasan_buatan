<?php

use App\Models\Building;
use App\Models\Room;
use App\Models\Lecturer;
use App\Models\Course;
use App\Models\CourseOffering;

$building = Building::firstOrCreate(['name' => 'GEDUNG C']);

$rooms = [
    'Ruang C 1.2' => Room::firstOrCreate(['name' => 'Ruang C 1.2', 'building_id' => $building->id], ['type' => 'theory']),
    'Ruang C 2.1' => Room::firstOrCreate(['name' => 'Ruang C 2.1', 'building_id' => $building->id], ['type' => 'theory']),
    'Ruang LAB KOMPUTER C 2.3' => Room::firstOrCreate(['name' => 'Ruang LAB KOMPUTER C 2.3', 'building_id' => $building->id], ['type' => 'lab']),
];

$data = [
    ['MKW21 201', 'Kapita Selekta Sumba', 2, 'theory', 'Ruang C 1.2', 'DENISIUS UMBU PATI SKM., M.Kes'],
    ['PTK21 320', 'Ilmu Kesuburan Tanah dan Pemupukan', 3, 'theory', 'Ruang C 1.2', 'AMELIA FLORIDA KIHA S.Pt., M.Sc'],
    ['PTK21 320', 'Ilmu Kesuburan Tanah dan Pemupukan', 3, 'theory', 'Ruang C 1.2', 'YONCE MELYANUS KILLA S.P., M. P'],
    ['MKW21 104', 'Kewarganegaraan', 2, 'theory', 'Ruang C 2.1', 'ARIS UMBU HINA PARI S.AP., M.AP'],
    ['PTK21 209', 'Kesehatan Ternak', 3, 'theory', 'Ruang C 2.1', 'MARSELINUS HAMBAKODU S.Pt, M.Si'],
    ['MKW21 106', 'Etika Kristen dalam Bisnis', 2, 'theory', 'Ruang C 2.1', 'DESY ASNΑΤΗ SITANIAPESSY S.SI (Teol)., M.Si'],
    ['PTK21 315', 'Agrowisata Peternakan', 3, 'theory', 'Ruang C 2.1', 'MARSELINUS HAMBAKODU S.Pt, M.Si'],
    ['PTK21 307', 'Kebijakan Pembangunan Peternakan', 3, 'theory', 'Ruang C 2.1', 'IVEN PATU SIRAPPA S.Pt., M.Si'],
    ['PTK21 208', 'Ilmu Reproduksi Ternak', 3, 'theory', 'Ruang C 2.1', 'Dr. Ir. ALEXANDER KAKA S.Pt., M.Si'],
    ['PTK21 319', 'Teknologi dan Rekayasa Ilmu Pangan', 3, 'theory', 'Ruang C 2.1', 'YESSY TAMU INA SPt., MS.i'],
    ['PTK21 319', 'Teknologi dan Rekayasa Ilmu Pangan', 3, 'theory', 'Ruang C 2.1', 'YATRIS RAMBU TEGA S.Pi., M.P'],
    ['PTK21 107', 'Ekologi Sabana', 3, 'theory', 'Ruang C 2.1', 'MARSELINUS HAMBAKODU S.Pt, M.Si'],
    ['PTK21 208', 'Ilmu Reproduksi Ternak', 3, 'theory', 'Ruang C 2.1', 'ALEXANDER KAKA S.Pt., M.Si'],
    ['PTK21 105', 'Biokimia Ternak', 4, 'theory', 'Ruang C 2.1', 'AMELIA FLORIDA KIHA S.Pt., M.Sc'],
    ['PTK21 316', 'Perencanaan dan Evaluasi Peternakan', 3, 'theory', 'Ruang C 2.1', 'IVEN PATU SIRAPPA S.Pt., M.Si'],
    ['PTK21 108', 'Bahasa Inggris', 3, 'theory', 'Ruang C 2.1', 'SURYANI KURNIAWI KAHI LEBA КАРОЕ S.S.,M.Hum'],
    ['PTK21 102', 'Fisika Dasar', 3, 'theory', 'Ruang C 2.1', 'DENISIUS UMBU PATI SKM., M.Kes'],
    ['PTK21 306', 'Penyuluhan Pembangunan', 3, 'theory', 'Ruang C 2.1', 'IVEN PATU SIRAPPA S.Pt., M.Si'],
    ['PTK21 306', 'Penyuluhan Pembangunan', 3, 'theory', 'Ruang C 2.1', 'YESSY TAMU INA SPt., MS.i'],
    ['PTK21 317', 'Bioteknologi Reproduksi Mutakhir', 3, 'theory', 'Ruang C 2.1', 'ALEXANDER KAKA S.Pt., M.Si'],
    ['PTK21 106', 'Pengantar Ilmu dan Industri Peternakan', 3, 'theory', 'Ruang C 2.1', 'YESSY TAMU INA SPt., MS.i'],
    ['PTK21 313', 'Teknologi Pengolahan Pakan', 3, 'theory', 'Ruang C 2.1', 'I MADE ADI SUDARMA S.Pt., M.Si'],
    ['PTK21 310', 'Aplikasi Komputer', 2, 'lab', 'Ruang LAB KOMPUTER C 2.3', 'DENISIUS UMBU PATI SKM.,M.Kes'],
    ['PTK21 310', 'Aplikasi Komputer', 2, 'lab', 'Ruang LAB KOMPUTER C 2.3', 'TRI SARY DEWI NOVYANTI BERTHA MIRA S.T, M. Kom.'],
    ['PTK21 210', 'Statistika', 4, 'lab', 'Ruang LAB KOMPUTER C 2.3', 'DENISIUS UMBU PATI SKM.,M.Kes'],
    ['PTK21 210', 'Statistika', 4, 'lab', 'Ruang LAB KOMPUTER C 2.3', 'AMELIA FLORIDA KIHA S.Pt., M.Sc'],
    ['PTK21 207', 'Bahan Pakan dan Formulasi Ransum', 4, 'lab', 'Ruang LAB KOMPUTER C 2.3', 'I MADE ADI SUDARMA S.Pt., M.Si'],
];

foreach ($data as $d) {
    $course = Course::firstOrCreate(['code' => $d[0], 'name' => $d[1]], ['sks' => $d[2], 'type' => $d[3]]);
    $lecturer = Lecturer::firstOrCreate(['name' => $d[5]]);
    $room = $rooms[$d[4]];
    CourseOffering::create([
        'course_id' => $course->id,
        'lecturer_id' => $lecturer->id,
        'room_id' => $room->id,
        'sks' => $d[2],
        'type' => $d[3],
        'name' => $d[1] . ' (' . $d[5] . ')'
    ]);
}

echo "Data insertion completed successfully.";
