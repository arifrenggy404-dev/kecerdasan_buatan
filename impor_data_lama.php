<?php

/**
 * Script untuk memindahkan data dari database lama (English) ke database baru (Indonesian).
 * Jalankan via terminal: php impor_data_lama.php
 */

// Konfigurasi Database
$db_lama = [
    'host' => '127.0.0.1',
    'dbname' => 'kecerdasan_buatan',
    'user' => 'root',
    'pass' => ''
];

$db_baru = [
    'host' => '127.0.0.1',
    'dbname' => 'test_kecerdasan_buatan',
    'user' => 'root',
    'pass' => ''
];

try {
    $pdo_lama = new PDO("mysql:host={$db_lama['host']};dbname={$db_lama['dbname']}", $db_lama['user'], $db_lama['pass']);
    $pdo_baru = new PDO("mysql:host={$db_baru['host']};dbname={$db_baru['dbname']}", $db_baru['user'], $db_baru['pass']);
    
    $pdo_lama->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_baru->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi berhasil. Memulai proses migrasi...\n";

    // 1. Bersihkan database baru (Opsional, tapi disarankan agar ID sinkron jika fresh)
    $pdo_baru->exec("SET FOREIGN_KEY_CHECKS = 0");
    $tables_to_clear = ['gedung', 'ruangan', 'dosen', 'mata_kuliah', 'kelas', 'hari', 'slot_waktu', 'jadwal', 'pengaturan', 'pengguna'];
    foreach ($tables_to_clear as $table) {
        $pdo_baru->exec("TRUNCATE TABLE $table");
    }
    echo "Database baru telah dibersihkan.\n";

    // 2. Migrasi Gedung (Buildings)
    echo "Memindahkan Gedung...";
    $stmt = $pdo_lama->query("SELECT * FROM buildings");
    $insert = $pdo_baru->prepare("INSERT INTO gedung (id, nama, created_at, updated_at) VALUES (?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['name'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 3. Migrasi Ruangan (Rooms)
    echo "Memindahkan Ruangan...";
    $stmt = $pdo_lama->query("SELECT * FROM rooms");
    $insert = $pdo_baru->prepare("INSERT INTO ruangan (id, gedung_id, nama, tipe, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Map type: theory -> teori, lab -> praktikum
        $tipe = ($row['type'] == 'lab') ? 'praktikum' : 'teori';
        $insert->execute([$row['id'], $row['building_id'], $row['name'], $tipe, $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 4. Migrasi Dosen (Lecturers)
    echo "Memindahkan Dosen...";
    $stmt = $pdo_lama->query("SELECT * FROM lecturers");
    $insert = $pdo_baru->prepare("INSERT INTO dosen (id, nama, created_at, updated_at) VALUES (?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['name'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 5. Migrasi Mata Kuliah (Courses)
    echo "Memindahkan Mata Kuliah...";
    $stmt = $pdo_lama->query("SELECT * FROM courses");
    $insert = $pdo_baru->prepare("INSERT INTO mata_kuliah (id, nama, kode, sks, tipe, semester, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tipe = ($row['type'] == 'lab') ? 'praktikum' : 'teori';
        $insert->execute([$row['id'], $row['name'], $row['code'], $row['sks'], $tipe, $row['semester'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 6. Migrasi Kelas (Course Offerings)
    echo "Memindahkan Kelas (Offerings)...";
    $stmt = $pdo_lama->query("SELECT * FROM course_offerings");
    $insert = $pdo_baru->prepare("INSERT INTO kelas (id, mata_kuliah_id, dosen_id, ruangan_id, sks, tipe, nama, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tipe = ($row['type'] == 'lab') ? 'praktikum' : 'teori';
        $insert->execute([$row['id'], $row['course_id'], $row['lecturer_id'], $row['room_id'], $row['sks'], $tipe, $row['name'] ?? 'Kelas A', $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 7. Migrasi Hari (Days)
    echo "Memindahkan Hari...";
    $stmt = $pdo_lama->query("SELECT * FROM days");
    $insert = $pdo_baru->prepare("INSERT INTO hari (id, nama, created_at, updated_at) VALUES (?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['name'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 8. Migrasi Slot Waktu (Time Slots)
    echo "Memindahkan Slot Waktu...";
    $stmt = $pdo_lama->query("SELECT * FROM time_slots");
    $insert = $pdo_baru->prepare("INSERT INTO slot_waktu (id, nama, jam_mulai, jam_selesai, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['name'], $row['start_time'], $row['end_time'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 9. Migrasi Jadwal (Schedules)
    echo "Memindahkan Jadwal Tergenerate...";
    $stmt = $pdo_lama->query("SELECT * FROM schedules");
    $insert = $pdo_baru->prepare("INSERT INTO jadwal (id, kelas_id, ruangan_id, hari_id, slot_waktu_mulai_id, id_batch, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['course_offering_id'], $row['room_id'], $row['day_id'], $row['start_time_slot_id'], $row['batch_id'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 10. Migrasi Pengaturan (Settings)
    echo "Memindahkan Pengaturan...";
    $stmt = $pdo_lama->query("SELECT * FROM settings");
    $insert = $pdo_baru->prepare("INSERT INTO pengaturan (id, kunci, nilai, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['key'], $row['value'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    // 11. Migrasi Pengguna (Users)
    echo "Memindahkan Pengguna...";
    $stmt = $pdo_lama->query("SELECT * FROM users");
    $insert = $pdo_baru->prepare("INSERT INTO pengguna (id, nama, email, email_verified_at, kata_sandi, remember_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['name'], $row['email'], $row['email_verified_at'], $row['password'], $row['remember_token'], $row['created_at'], $row['updated_at']]);
    }
    echo " Selesai.\n";

    $pdo_baru->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "\n>>> MIGRASI DATA SELESAI! <<<\n";
    echo "Seluruh data dari '{$db_lama['dbname']}' telah dipindahkan ke '{$db_baru['dbname']}'.\n";

} catch (PDOException $e) {
    die("ERROR: " . $e->getMessage() . "\n");
}
