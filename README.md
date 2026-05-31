<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistem Penjadwalan Universitas (Algoritma Genetika)

Aplikasi berbasis Laravel untuk menghasilkan jadwal perkuliahan otomatis tanpa bentrok menggunakan optimasi Algoritma Genetika.

---

## 🚀 Cara Kerja Sistem (Algoritma Genetika)

Sistem penjadwalan ini bekerja menggunakan Algoritma Genetika (AG), yaitu teknik optimasi yang meniru proses evolusi alam (seleksi alam Darwin) untuk menemukan solusi terbaik dari jutaan kemungkinan kombinasi jadwal.

Berikut adalah penjelasan detail cara kerjanya, dari persiapan data hingga menghasilkan jadwal yang sempurna:

### 1. Representasi Data (Kromosom & Gen)
Dalam algoritma ini, jadwal diibaratkan sebagai makhluk hidup:
*   **Gen:** Adalah satu unit jadwal untuk satu mata kuliah. Isinya meliputi: ID Mata Kuliah, ID Dosen, ID Hari, ID Jam, dan ID Ruangan.
*   **Kromosom:** Adalah kumpulan dari seluruh "Gen" (seluruh jadwal mata kuliah dalam satu semester). Satu kromosom mewakili satu solusi jadwal lengkap.

### 2. Tahap Inisialisasi (Populasi Awal)
Sistem tidak hanya membuat satu jadwal, melainkan 60 jadwal (Populasi) sekaligus secara acak di awal.
*   **Smart Initialization:** Agar proses lebih cepat, sejak awal sistem sudah diarahkan untuk memilih ruangan yang tipenya cocok (misal: Mata kuliah praktikum hanya akan mengambil ruangan tipe "Lab").

### 3. Tahap Evaluasi (Fungsi Fitness)
Inilah "otak" dari sistem. Setiap jadwal yang dibuat akan dinilai kualitasnya menggunakan rumus Fitness. Semakin sedikit bentrok, semakin tinggi nilai fitness-nya.
Sistem memberikan Hukuman (Penalti) jika terjadi pelanggaran:
*   **Bentrok Dosen (5000 poin):** Jika seorang dosen mengajar di dua tempat berbeda pada jam yang sama.
*   **Bentrok Ruangan (5000 poin):** Jika dua mata kuliah menempati satu ruangan pada jam yang sama.
*   **Tipe Ruangan Tidak Cocok (10000 poin):** Jika kuliah teori dilakukan di Lab, atau sebaliknya.
*   **Melebihi Jam Operasional (10000 poin):** Jika durasi kuliah (SKS) melampaui batas jam pulang kampus.

**Rumus Fitness:** `Fitness = 1 / (1 + Total Penalti)`
*   Jika Fitness = 1.0, berarti Nol Bentrok (Jadwal Sempurna).

### 4. Tahap Evolusi (Perbaikan Jadwal)
Jika jadwal belum sempurna (Fitness < 1.0), sistem akan melakukan proses evolusi untuk menciptakan generasi baru yang lebih baik:

1.  **Seleksi (Tournament Selection):** Sistem mengambil beberapa jadwal secara acak, lalu memilih yang terbaik (fitness tertinggi) untuk dijadikan "orang tua".
2.  **Pindah Silang (Crossover):** Dua jadwal "orang tua" yang bagus digabungkan gen-nya (sebagian jadwal diambil dari Orang Tua A, sebagian dari B) untuk menciptakan jadwal "anak" yang diharapkan mewarisi kebaikan kedua induknya.
3.  **Mutasi (Mutation):** Untuk mencegah algoritma "stagnan", sistem akan mengubah sedikit data secara acak (misalnya memindahkan satu mata kuliah ke hari lain atau ruangan lain). Ini seperti mencoba kemungkinan baru secara spontan.
4.  **Elitisme:** Sistem akan selalu menjaga 10% jadwal terbaik dari generasi sebelumnya agar tidak hilang atau rusak selama proses evolusi.

### 5. Konvergensi (Hasil Akhir)
Proses (Evaluasi -> Seleksi -> Crossover -> Mutasi) ini diulang-ulang secara terus-menerus hingga:
*   Ditemukan jadwal dengan Fitness 1.0 (Tidak ada satu pun bentrok).
*   Atau mencapai batas maksimal generasi (1000 generasi).

---

### 💡 Mengapa Sistem Ini "Cerdas"?
Sistem ini cerdas karena ia tidak mencoba semua kemungkinan secara buta (yang bisa memakan waktu bertahun-tahun), melainkan ia "belajar" dari kesalahan. Setiap kali ada bentrok, nilai fitness turun, dan jadwal tersebut dibuang atau diperbaiki melalui mutasi sampai ditemukan kombinasi yang benar-benar pas antara ketersediaan Dosen, Ruangan, dan Waktu.
