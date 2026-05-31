# Kecerdasan Buatan - Sistem Penjadwalan Universitas

Aplikasi penjadwalan mata kuliah universitas berbasis Laravel yang menggunakan Algoritma Genetika untuk menghasilkan jadwal bebas bentrok bagi dosen dan ruangan.

## Ringkasan Proyek

*   **Framework:** Laravel 13 (PHP 8.3)
*   **Frontend:** Tailwind CSS 4, Vite
*   **Testing:** Pest PHP
*   **Logika Inti:** `app/Services/GeneticAlgorithmService.php` menangani optimasi penjadwalan.
*   **Model Data:**
    *   `Lecturer`: Data dosen.
    *   `Building` & `Room`: Lokasi fisik untuk perkuliahan.
    *   `Course`: Mata kuliah dengan SKS dan tipe (teori/praktikum).
    *   `CourseOffering`: Instansi spesifik dari mata kuliah (misal: "Kelas A") yang ditugaskan ke dosen.
    *   `Schedule`: Jadwal yang dihasilkan, diidentifikasi dengan `batch_id`.
    *   `Setting`: Konfigurasi global (hari aktif, jam operasional, durasi SKS).

## Membangun dan Menjalankan

### Prasyarat
*   PHP 8.3+
*   Composer
*   Node.js & npm
*   MySQL Server

### Pengaturan (Setup)
1.  **Instal Dependensi:**
    ```bash
    composer install
    npm install
    ```
2.  **Konfigurasi Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3.  **Database Setup:**
    Pastikan database bernama `kecerdasan_buatan` telah dibuat di MySQL, kemudian jalankan:
    ```bash
    php artisan migrate --seed
    ```

4.  **Build Aset:**
    ```bash
    npm run build
    ```

### Pengembangan
Jalankan server pengembangan dan Vite watcher secara bersamaan:
```bash
npm run dev
```

### Pengujian (Testing)
Jalankan suite pengujian menggunakan Pest:
```bash
php artisan test
```

## Konvensi Pengembangan

*   **Algoritma Genetika:** `GeneticAlgorithmService` adalah inti dari logika penjadwalan. Menggunakan pendekatan berbasis populasi dengan *tournament selection*, *crossover*, dan *mutation* untuk meminimalkan penalti (bentrok dosen/ruangan).
*   **Service Layer:** Logika bisnis untuk penjadwalan dienkapsulasi di dalam `app/Services`.
*   **Eloquent Models:** Menggunakan model Eloquent Laravel standar untuk persistensi data.
*   **Syarat Bebas Bentrok:** `ScheduleController` hanya menyimpan jadwal yang dihasilkan jika mencapai nilai fitness 1.0 (nol bentrok).
*   **Slot Dinamis:** Entri `TimeSlot` dikelola secara otomatis berdasarkan `Setting` (durasi SKS dan jam operasional) di dalam `GeneticAlgorithmService`.
*   **Agentic Development:** Proyek ini menggunakan `laravel/boost`. Gunakan alat dan skill yang tersedia untuk tugas-tugas spesifik Laravel.

## File Penting
*   `app/Services/GeneticAlgorithmService.php`: Implementasi inti Algoritma Genetika.
*   `app/Http/Controllers/ScheduleController.php`: Mengelola pembuatan dan tampilan jadwal.
*   `database/migrations/`: Mendefinisikan skema penjadwalan universitas.
*   `app/Models/Setting.php`: Menangani pengaturan aplikasi yang dinamis.
