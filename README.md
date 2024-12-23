# Aplikasi Web Manajemen Toko Mebel

Aplikasi ini adalah sistem manajemen untuk toko mebel, yang mencakup pengelolaan data karyawan dan inventory. Aplikasi ini dibangun menggunakan PHP dan JavaScript, dengan data yang disimpan di dalam database MySQL. Di sini, kami menggunakan berbagai teknik pengelolaan state, pengelolaan session, dan manipulasi DOM pada sisi klien.

## Bagian 1: Client-side Programming

### 1.1 Manipulasi DOM dengan JavaScript

Aplikasi ini mencakup form input untuk menambah data inventory dan karyawan, dengan minimal 4 elemen input pada form. Data yang dimasukkan pada form akan diproses dan ditampilkan di dalam tabel HTML setelah data berhasil dimasukkan ke dalam sistem.

- **Form Inventory**: Memungkinkan pengguna untuk memasukkan nama bahan, kategori, jumlah, dan harga bahan ke dalam tabel.
- **Form Karyawan**: Mengizinkan pengguna untuk memasukkan nama dan posisi karyawan.

### 1.2 Event Handling

Beberapa event ditangani dengan JavaScript untuk memastikan input yang diterima dari pengguna adalah valid sebelum dikirimkan ke server:
- **Validasi Form**: Menggunakan event `submit` untuk memvalidasi setiap input form (baik inventory maupun karyawan). Input yang tidak valid akan menyebabkan form tidak terkirim dan menampilkan pesan kesalahan.
- **Manipulasi DOM**: Event `change` digunakan untuk menyesuaikan tampilan form berdasarkan pilihan aksi pengguna, seperti menampilkan dan menyembunyikan elemen form sesuai dengan aksi (`set`, `get`, `delete`).

## Bagian 2: Server-side Programming

### 2.1 Pengelolaan Data dengan PHP

Data dari form dikirimkan melalui metode `POST` untuk diproses oleh PHP. PHP melakukan validasi data yang diterima sebelum menyimpan informasi tersebut ke dalam database.

- **Validasi Input**: Semua data yang diterima dari form akan diverifikasi oleh PHP untuk memastikan tidak ada nilai yang kosong atau tidak valid (seperti harga atau jumlah yang tidak positif).
- **Menyimpan Data**: Data yang telah tervalidasi akan disimpan ke dalam database MySQL.
- **Mencatat Data Pengguna**: Data tambahan seperti jenis browser dan alamat IP pengguna juga disimpan untuk keperluan log.

### 2.2 Objek PHP Berbasis OOP

Sistem ini juga menggunakan prinsip pemrograman berbasis objek (OOP) dengan membuat objek PHP yang mengelola data karyawan. Objek ini memiliki dua metode utama:

- **addEmployee**: Menambahkan data karyawan baru ke dalam sesi (simulasi penyimpanan data).
- **getAllEmployees**: Mengambil semua data karyawan yang ada dari sesi.
- **deleteEmployee**: Menghapus karyawan berdasarkan nama.

## Bagian 3: Database Management

### 3.1 Pembuatan Tabel Database

Aplikasi ini menggunakan database MySQL untuk menyimpan data inventory dan karyawan. Tabel yang dibuat di dalam database adalah sebagai berikut:

- **Tabel `inventory`**: Menyimpan data bahan, kategori, jumlah, dan harga.
- **Tabel `employees`**: Menyimpan data karyawan, termasuk nama dan posisi.

### 3.2 Konfigurasi Koneksi Database

Aplikasi ini menghubungkan ke database `toko_mebel` dengan menggunakan kredensial yang ditentukan pada file konfigurasi PHP. Koneksi ini dilakukan dengan menggunakan ekstensi `mysqli` untuk PHP.

### 3.3 Manipulasi Data pada Database

- **CRUD pada Inventory**: Mengelola data bahan (create, read, update, delete) menggunakan query SQL.
- **CRUD pada Karyawan**: Mengelola data karyawan (create, read, delete) menggunakan query SQL yang terpisah.

## Bagian 4: State Management

### 4.1 State Management dengan Session (10%)

Aplikasi menggunakan PHP session untuk menyimpan dan melacak data pengguna selama sesi berlangsung. Fungsi `session_start()` digunakan untuk memulai sesi di server, dan informasi seperti daftar karyawan disimpan dalam variabel sesi.

- **Penyimpanan Sesi**: Data yang dimasukkan melalui form (baik untuk karyawan maupun inventory) disimpan dalam sesi untuk memudahkan akses dan pengelolaan.

### 4.2 Pengelolaan State dengan Cookie dan Browser Storage (10%)

Selain menggunakan sesi, aplikasi ini juga menggunakan cookies untuk menyimpan data di sisi klien. Cookie digunakan untuk menyimpan informasi yang lebih permanen, misalnya pengaturan preferensi pengguna.

- **Cookie Functions**:
  - `setCookie()`: Untuk menetapkan cookie dengan nilai tertentu.
  - `getCookie()`: Untuk mendapatkan nilai dari cookie yang telah diset.
  - `eraseCookie()`: Untuk menghapus cookie.

Selain cookies, aplikasi ini memanfaatkan browser storage untuk menyimpan data secara lokal di perangkat pengguna, sehingga tidak perlu mengirim data ulang ke server untuk setiap permintaan.

## Bagian 5: Hosting Aplikasi Web

### Langkah-langkah Hosting Aplikasi Web

Untuk meng-host aplikasi ini, saya menggunakan **InfinityFree**, sebuah layanan hosting web gratis. Berikut adalah langkah-langkah yang saya lakukan untuk meng-host aplikasi ini:

1. **Persiapkan Berkas**: Meng-upload semua berkas aplikasi (PHP, CSS, JavaScript) ke server hosting menggunakan FTP.
2. **Pemasangan Database**: Membuat database baru di InfinityFree dan meng-upload file SQL untuk membuat tabel yang diperlukan.
3. **Koneksi ke Database**: Memastikan kredensial database (username, password, host) dikonfigurasi dengan benar di file PHP.

### Penyedia Hosting Web: InfinityFree

InfinityFree adalah layanan hosting yang saya pilih karena menyediakan hosting web gratis dengan dukungan PHP dan MySQL. Dengan batasan yang cukup baik untuk aplikasi web skala kecil, layanan ini cocok untuk proyek ini.

### Keamanan Aplikasi Web

- **Penggunaan HTTPS**: Menggunakan HTTPS untuk mengenkripsi komunikasi antara klien dan server.
- **Validasi Input**: Semua data yang diterima dari pengguna diverifikasi baik di sisi klien (JavaScript) maupun di sisi server (PHP) untuk menghindari serangan seperti XSS dan SQL Injection.
- **Penggunaan Session dan Cookies dengan Hati-hati**: Data sensitif disimpan dalam session untuk memastikan bahwa informasi tetap aman selama sesi berlangsung.

### Konfigurasi Server

Di server hosting, saya menggunakan PHP dan MySQL untuk mendukung aplikasi web ini. Server diatur untuk mendukung komunikasi antara aplikasi dan database, serta menjalankan skrip PHP yang memproses input dari pengguna dan menyimpan data ke dalam database.

## Cara Menggunakan Aplikasi

1. **Clone atau Download Repositori ini**.
2. **Upload ke Web Hosting** yang mendukung PHP dan MySQL.
3. **Konfigurasi Database** sesuai dengan petunjuk di bagian `Database Management`.
4. **Akses Aplikasi melalui Browser** untuk mulai menggunakan fitur manajemen inventory dan karyawan.

## Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).
