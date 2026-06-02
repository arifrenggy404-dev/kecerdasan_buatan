<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistem Penjadwalan Universitas (Algoritma Genetika)

Aplikasi berbasis Laravel untuk menghasilkan jadwal perkuliahan otomatis tanpa bentrok menggunakan optimasi Algoritma Genetika. Sistem ini dirancang untuk menangani kompleksitas penjadwalan akademik dengan mempertimbangkan keterbatasan dosen, ruangan, dan waktu secara dinamis.

**🌐 Demo Link:** [https://algoritmagenetik.up.railway.app/](https://algoritmagenetik.up.railway.app/)

---

## 🚀 Cara Kerja Sistem (Algoritma Genetika)

Sistem penjadwalan ini menggunakan Algoritma Genetika (AG), sebuah metode metaheuristik yang meniru proses evolusi biologi untuk memecahkan masalah optimasi kombinatorial yang kompleks.

Berikut adalah penjelasan teknis detail mengenai tahapan algoritmanya:

### 1. Representasi Data (Kromosom & Gen)
*   **Gen:** Mewakili satu unit jadwal untuk satu `CourseOffering` (Mata Kuliah). Data gen meliputi:
    *   `offering_id`: ID Mata Kuliah yang ditawarkan.
    *   `lecturer_id`: Dosen pengampu.
    *   `room_idx`: Indeks ruangan yang dipilih.
    *   `day_idx`: Indeks hari yang dipilih.
    *   `slot_idx`: Indeks jam mulai (berdasarkan ketersediaan slot SKS).
*   **Kromosom:** Kumpulan dari seluruh Gen yang membentuk satu solusi jadwal lengkap untuk satu periode/semester.

### 2. Konfigurasi Dinamis (Environment)
Sebelum algoritma berjalan, sistem menyiapkan lingkungan berdasarkan data dari tabel `settings`:
*   **Active Days:** Hari-hari aktif perkuliahan (misal: Senin-Jumat).
*   **Operational Hours:** Jam mulai dan berakhir operasional kampus.
*   **Blackout Hours (Specific Days):** Waktu jeda atau kegiatan khusus (misal: ibadah atau rapat rutin) di mana tidak boleh ada perkuliahan pada hari tertentu atau setiap hari.
*   **SKS Duration & Zero Gap:** Durasi satu SKS dalam menit (misal: 50 menit). Sistem menggunakan perhitungan waktu kontinu (3 SKS = 150 menit) tanpa jeda antar slot untuk akurasi jam selesai.

### 3. Inisialisasi Populasi
*   **Ukuran Populasi:** 100 individu (kromosom) per generasi.
*   **TimeSlot Refresh:** Setiap kali proses generate dimulai, sistem menghapus dan membuat ulang seluruh `TimeSlot` di database untuk mencegah "Slot Hantu" dari pengaturan lama yang bisa mengacaukan perhitungan waktu.
*   **Smart Initialization:** Saat pembentukan populasi awal, sistem secara otomatis hanya memilih ruangan yang tipenya cocok dengan tipe mata kuliah (Teori vs Praktikum/Lab). Selain itu, sistem secara proaktif menghindari slot waktu *blackout* sejak awal pembentukan individu untuk mempercepat konvergensi.

### 4. Evaluasi (Fungsi Fitness)
Setiap individu dinilai kualitasnya berdasarkan kepatuhan terhadap batasan (*constraints*). Sistem menggunakan **Hard Constraints** dengan penalti berat (1.000.000 poin) untuk setiap pelanggaran:
1.  **Bentrok Dosen:** Seorang dosen tidak boleh mengajar di dua kelas berbeda pada waktu yang sama.
2.  **Bentrok Ruangan:** Satu ruangan tidak boleh digunakan oleh dua kelas berbeda pada waktu yang sama.
3.  **Bentrok Semester:** Dua mata kuliah dalam satu semester yang sama tidak boleh dijadwalkan pada waktu yang sama (menjamin mahasiswa tidak memiliki jadwal ganda).
4.  **Kesesuaian Tipe Ruangan:** Mata kuliah praktikum harus di Laboratorium, dan teori di ruang kelas biasa.
5.  **Pelanggaran Waktu Blackout:** Jadwal tidak boleh menempati rentang waktu terlarang (Blackout) secara keseluruhan maupun sebagian durasi kelas.
6.  **Slot Overflow:** Durasi mata kuliah (SKS) tidak boleh melebihi batas jam operasional harian.

**Rumus Fitness:**  
`Fitness = 1 / (1 + Total Penalti)`  

### 5. Proses Evolusi
Sistem melakukan iterasi hingga maksimal **3000 generasi** untuk mencari solusi optimal:

*   **Elitisme (10%):** 10 individu terbaik dari generasi sekarang langsung dibawa ke generasi berikutnya tanpa perubahan untuk menjaga kualitas genetik.
*   **Seleksi (Tournament Selection):** Menggunakan ukuran turnamen 5 untuk memilih orang tua dengan fitness terbaik.
*   **Crossover (Single Point):** Menggabungkan gen dari dua orang tua pada titik acak untuk menciptakan keturunan baru.
*   **Mutasi Adaptif:** 
    *   **Normal:** Peluang mutasi gen sebesar 5%.
    *   **Adaptive Mutation:** Jika setelah 500 generasi tidak ditemukan solusi sempurna, laju mutasi ditingkatkan menjadi 20% untuk keluar dari optimum lokal.
    *   **Swap Mutation:** Terdapat peluang 5% di setiap langkah mutasi untuk menukar seluruh blok hari, waktu, dan ruangan antar dua mata kuliah secara acak.

### 6. Konvergensi & Output (Zero Tolerance)
Sistem menerapkan kebijakan **Zero Tolerance**. Algoritma hanya akan menyimpan hasil ke database jika ditemukan individu dengan **Fitness = 1.0 (Nol Bentrok)**. Jika hingga generasi maksimal solusi sempurna belum ditemukan, sistem tidak akan menyimpan jadwal apa pun untuk menjamin integritas data.

---

### 💡 Mengapa Menggunakan Algoritma Genetika?
Masalah penjadwalan adalah masalah *NP-Hard* di mana mencoba semua kombinasi secara manual sangatlah mustahil. Algoritma Genetika mampu melakukan pencarian ruang solusi secara paralel dan efisien, memastikan ketersediaan sumber daya kampus (dosen dan ruangan) digunakan secara optimal tanpa adanya konflik jadwal.
