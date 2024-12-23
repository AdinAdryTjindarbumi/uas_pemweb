# Aplikasi Web Manajemen Toko Mebel

Aplikasi ini adalah sistem manajemen untuk toko mebel, yang mencakup pengelolaan data karyawan dan inventory. Aplikasi ini dibangun menggunakan PHP dan JavaScript, dengan data yang disimpan di dalam database MySQL. Di sini, kami menggunakan berbagai teknik pengelolaan state, pengelolaan session, dan manipulasi DOM pada sisi klien.

https://toko-mebel.wuaze.com

## Bagian 1: Client-side Programming

### 1.1 Manipulasi DOM dengan JavaScript

Aplikasi ini mencakup form input untuk menambah data inventory dan karyawan, dengan minimal 4 elemen input pada form. Data yang dimasukkan pada form akan diproses dan ditampilkan di dalam tabel HTML setelah data berhasil dimasukkan ke dalam sistem.

- **HTML Form untuk Inventory** (untuk menerima input seperti nama bahan, kategori, jumlah, dan harga)
    ```html
     <form id="inventoryForm" method="POST">
            <!-- Input nama barang -->
            <label for="itemName">Nama Barang:</label>
            <input type="text" id="itemName" name="itemName" value="<?= isset($item['name']) ? $item['name'] : '' ?>" required>
            <!-- Input kategori barang -->
            <label for="itemCategory">Kategori:</label>
            <input type="text" id="itemCategory" name="itemCategory" value="<?= isset($item['category']) ? $item['category'] : '' ?>" required>
            <!-- Input jumlah barang -->
            <label for="itemQuantity">Jumlah:</label>
            <input type="number" id="itemQuantity" name="itemQuantity" value="<?= isset($item['quantity']) ? $item['quantity'] : '' ?>" required>
            <!-- Input harga barang -->
            <label for="itemPrice">Harga:</label>
            <input type="number" id="itemPrice" name="itemPrice" value="<?= isset($item['price']) ? $item['price'] : '' ?>" required>
            <!-- Input ID barang (tersembunyi) -->
            <input type="hidden" name="itemId" value="<?= isset($item['id']) ? $item['id'] : '' ?>">
            <!-- Tombol submit -->
            <button type="submit" name="<?= isset($item['id']) ? 'update_inventory' : 'submit_inventory' ?>">
                <?= isset($item['id']) ? 'Perbarui Barang' : 'Tambah Barang' ?>
            </button>
      </form>
    ```
- **HTML Form untuk Karyawan** (untuk menerima input seperti nama dan posisi karyawan)
    ```html
     <form id="employeeForm">
            <!-- Input tersembunyi untuk menyimpan indeks karyawan saat proses edit -->
            <input type="hidden" id="employeeIndex" name="employeeIndex" value="">
            <label for="employeeName">Nama Karyawan:</label>
            <input type="text" id="employeeName" name="employeeName" required>
            <label for="employeePosition">Jabatan:</label>
            <input type="text" id="employeePosition" name="employeePosition" required>
            <!-- Tombol untuk menyimpan data karyawan -->
            <button type="submit">Simpan Karyawan</button>
     </form>
    ```
### 1.2 Event Handling

Beberapa event ditangani dengan JavaScript untuk memastikan input yang diterima dari pengguna adalah valid sebelum dikirimkan ke server:
- **Validasi Form**: Menggunakan event `submit` untuk memvalidasi setiap input form (baik inventory maupun karyawan). Input yang tidak valid akan menyebabkan form tidak terkirim dan menampilkan pesan kesalahan.
  ```javascript
   const inventoryForm = document.getElementById("inventoryForm");
    if (inventoryForm) {
      // Validasi form Mahasiswa sebelum disubmit
      inventoryForm.addEventListener("submit", (e) => {
        const itemName = document.getElementById("itemName").value.trim();
        const itemCategory = document.getElementById("itemCategory").value.trim();
        const itemQuantity = document.getElementById("itemQuantity").value.trim();
        const itemPrice = document.getElementById("itemPrice").value.trim();
  
        // Validasi untuk nama Nama Bahan, Kategori, Jumlah, Harga
        if (!itemName) {
          e.preventDefault(); // Mencegah form dikirim
          alert("Nama Bahan wajib diisi!");
          return;
    }
  ```
- **Manipulasi DOM**: Event `change` digunakan untuk menyesuaikan tampilan form berdasarkan pilihan aksi pengguna, seperti menampilkan dan menyembunyikan elemen form sesuai dengan aksi (`set`, `get`, `delete`).
    ```javascript
     document.addEventListener("DOMContentLoaded", () => {
      // Form Karyawan
      const employeeForm = document.getElementById("employeeForm");
      if (employeeForm) {
        // Validasi form karyawan sebelum disubmit
        employeeForm.addEventListener("submit", (e) => {
          const employeeName = document.getElementById("employeeName").value.trim();
          const employeePosition = document
            .getElementById("employeePosition")
            .value.trim();
    
          // Validasi untuk Nama karywan dan Jabatan
          if (!employeeName) {
            e.preventDefault(); // Mencegah form dikirim
            alert("Nama Karyawan wajib diisi!");
            return;
          }
    
          if (!employeePosition) {
            e.preventDefault(); // Mencegah form dikirim
            alert("Jabatan Karyawan wajib diisi!");
            return;
          }
    
          // Cek apakah nama karyawan mengandung angka atau karakter khusus (misalnya hanya huruf dan spasi yang diperbolehkan)
          if (!/^[a-zA-Z\s]+$/.test(employeeName)) {
            e.preventDefault();
            alert("Nama hanya boleh mengandung huruf dan spasi.");
            return;
          }
    
          // Cek apakah Jabatan mengandung angka atau karakter khusus
          if (!/^[a-zA-Z\s]+$/.test(employeePosition)) {
            e.preventDefault();
            alert("Jabatan hanya boleh mengandung huruf dan spasi.");
            return;
          }
        });
      }
  ```

## Bagian 2: Server-side Programming

### 2.1 Pengelolaan Data dengan PHP

Data dari form dikirimkan melalui metode `POST` untuk diproses oleh PHP. PHP melakukan validasi data yang diterima sebelum menyimpan informasi tersebut ke dalam database.

- **Validasi Input**: Semua data yang diterima dari form akan diverifikasi oleh PHP untuk memastikan tidak ada nilai yang kosong atau tidak valid (seperti harga atau jumlah yang tidak positif).
- **Menyimpan Data**: Data yang telah tervalidasi akan disimpan ke dalam database MySQL.
- **Mencatat Data Pengguna**: Data tambahan seperti jenis browser dan alamat IP pengguna juga disimpan untuk keperluan log.
#### **Kode terkait**:
 ```php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['itemName'])) {
        // Validasi input inventory
        $name = trim($_POST['itemName']);
        $category = trim($_POST['itemCategory']);
        $quantity = (int)$_POST['itemQuantity'];
        $price = (int)$_POST['itemPrice'];

        if (empty($name) || empty($category) || $quantity <= 0 || $price <= 0) {
            die(json_encode(['success' => false, 'error' => 'Input tidak valid!']));
        }

        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO inventory (name, category, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name, $category, $quantity, $price);

        if (!$stmt->execute()) {
            die(json_encode(['success' => false, 'error' => $stmt->error]));
        }

        echo json_encode(['success' => true]);
    } elseif (isset($_POST['employeeName'])) {
        // Validasi input employee
        $name = trim($_POST['employeeName']);
        $position = trim($_POST['employeePosition']);

        if (empty($name) || empty($position)) {
            die(json_encode(['success' => false, 'error' => 'Input tidak valid!']));
        }

        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO employees (name, position) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $position);

        if (!$stmt->execute()) {
            die(json_encode(['success' => false, 'error' => $stmt->error]));
        }

        echo json_encode(['success' => true]);
      }
    }
  ```

### 2.2 Objek PHP Berbasis OOP

Sistem ini juga menggunakan prinsip pemrograman berbasis objek (OOP) dengan membuat objek PHP yang mengelola data karyawan. Objek ini memiliki dua metode utama:

- **addEmployee**: Menambahkan data karyawan baru ke dalam sesi (simulasi penyimpanan data).
- **getAllEmployees**: Mengambil semua data karyawan yang ada dari sesi.
- **deleteEmployee**: Menghapus karyawan berdasarkan nama.
#### **Kode terkait**:
  ```php
    <?php
      class Employee {
          // Properti untuk menyimpan data karyawan dalam array
          private $employees;
      
          // Konstruktor untuk inisialisasi
          public function __construct() {
              // Jika data karyawan sudah ada di localStorage (disimulasikan dengan sesi PHP)
              if (isset($_SESSION['employees'])) {
                  $this->employees = $_SESSION['employees'];
              } else {
                  $this->employees = [];
              }
          }
      
          // Menambahkan karyawan baru
          public function addEmployee($name, $position) {
              $newEmployee = [
                  'name' => $name,
                  'position' => $position
              ];
              
              // Menambahkan karyawan ke array
              $this->employees[] = $newEmployee;
      
              // Menyimpan data ke session (simulasi penyimpanan ke localStorage)
              $_SESSION['employees'] = $this->employees;
          }
      
          // Mendapatkan semua data karyawan
          public function getAllEmployees() {
              return $this->employees;
          }
      
          // Menghapus karyawan berdasarkan nama
          public function deleteEmployee($name) {
              foreach ($this->employees as $index => $employee) {
                  if ($employee['name'] == $name) {
                      unset($this->employees[$index]);
                      $_SESSION['employees'] = $this->employees; // Menyimpan perubahan
                      return true;
                  }
              }
              return false;
          }
      }
      ?>
  ```
## Bagian 3: Database Management

### 3.1 Pembuatan Tabel Database

Aplikasi ini menggunakan database MySQL untuk menyimpan data inventory dan karyawan. Tabel yang dibuat di dalam database adalah sebagai berikut:

- **Tabel `inventory`**: Menyimpan data bahan, kategori, jumlah, dan harga.
- **Tabel `employees`**: Menyimpan data karyawan, termasuk nama dan posisi.
#### **Kode terkait**:
  ```sql
    -- Membuat database 'toko_mebel'
    CREATE DATABASE IF NOT EXISTS toko_mebel;
    
    -- Menggunakan database 'toko_mebel'
    USE toko_mebel;
    
    -- Tabel untuk menyimpan data inventory
    CREATE TABLE IF NOT EXISTS inventory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        quantity INT NOT NULL,
        price INT NOT NULL
    );
    
    -- Tabel untuk menyimpan data employees
    CREATE TABLE IF NOT EXISTS employees (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        position VARCHAR(255) NOT NULL
    );
  ```

### 3.2 Konfigurasi Koneksi Database

Aplikasi ini menghubungkan ke database `toko_mebel` dengan menggunakan kredensial yang ditentukan pada file konfigurasi PHP. Koneksi ini dilakukan dengan menggunakan ekstensi `mysqli` untuk PHP.
#### **Kode terkait**:
```php
  <?php
  // Koneksi ke database
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'toko_mebel';
  
  // Membuat koneksi ke database menggunakan mysqli
  $conn = new mysqli($host, $user, $password, $database);
  // Mengecek apakah koneksi berhasil
  if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
  }
```

### 3.3 Manipulasi Data pada Database

- **CRUD pada Inventory**: Mengelola data bahan (create, read, update, delete) menggunakan query SQL.
- **CRUD pada Karyawan**: Mengelola data karyawan (create, read, delete) menggunakan query SQL yang terpisah.
#### **Kode terkait**:
```php
  // Proses mengambil data untuk diedit (Read for Update)
  if (isset($_GET['edit'])) {
      $id = $_GET['edit'];
      $result = $conn->query("SELECT * FROM inventory WHERE id = $id");
      $item = $result->fetch_assoc(); // Mengambil data barang yang akan diedit
  }
  
  // Proses pengiriman formulir untuk memperbarui data (Update)
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_inventory'])) {
      $id = $_POST['itemId'];
      $itemName = $conn->real_escape_string($_POST['itemName']);
      $itemCategory = $conn->real_escape_string($_POST['itemCategory']);
      $itemQuantity = (int) $_POST['itemQuantity'];
      $itemPrice = (float) $_POST['itemPrice'];
      
      // Query untuk memperbarui data pada tabel `inventory`
      $query = "UPDATE inventory SET name = '$itemName', category = '$itemCategory', quantity = '$itemQuantity', price = '$itemPrice' WHERE id = $id";
      
      // Mengeksekusi query dan memberikan notifikasi
      if ($conn->query($query) === TRUE) {
          echo "<script>alert('Barang berhasil diperbarui'); window.location = 'inventory.php';</script>";
      } else {
          echo "<script>alert('Error: " . $conn->error . "');</script>";
      }
  }
  
  // Proses penghapusan data (Delete)
  if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      // Query untuk menghapus data berdasarkan ID
      $conn->query("DELETE FROM inventory WHERE id = $id");
      echo "<script>alert('Barang berhasil dihapus'); window.location = 'inventory.php';</script>";
  }
```

## Bagian 4: State Management

### 4.1 State Management dengan Session

Aplikasi menggunakan PHP session untuk menyimpan dan melacak data pengguna selama sesi berlangsung. Fungsi `session_start()` digunakan untuk memulai sesi di server, dan informasi seperti daftar karyawan disimpan dalam variabel sesi.

- **Penyimpanan Sesi**: Data yang dimasukkan melalui form (baik untuk karyawan maupun inventory) disimpan dalam sesi untuk memudahkan akses dan pengelolaan.
#### **Kode terkait**:
```php
  <?php
  session_start();
  header('Content-Type: application/json');
```

### 4.2 Pengelolaan State dengan Cookie dan Browser Storage

Selain menggunakan sesi, aplikasi ini juga menggunakan cookies untuk menyimpan data di sisi klien. Cookie digunakan untuk menyimpan informasi yang lebih permanen, misalnya pengaturan preferensi pengguna.

- **Cookie Functions**:
  - `setCookie()`: Untuk menetapkan cookie dengan nilai tertentu.
  - `getCookie()`: Untuk mendapatkan nilai dari cookie yang telah diset.
  - `eraseCookie()`: Untuk menghapus cookie.
#### **Kode terkait**:
```php
  <?php
  class CookieHandler {
      // Menetapkan cookie dengan waktu kedaluwarsa
      public function setCookie($name, $value, $expire = 3600, $path = "/") {
          // Mengatur cookie dan mengatur waktu kedaluwarsa
          setcookie($name, $value, time() + $expire, $path);
      }
  
      // Mendapatkan nilai dari cookie
      public function getCookie($name) {
          // Memeriksa apakah cookie ada dan mengembalikan nilainya
          return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
      }
  
      // Menghapus cookie
      public function deleteCookie($name, $path = "/") {
          // Menghapus cookie dengan menetapkan waktu kedaluwarsa ke masa lalu
          setcookie($name, '', time() - 3600, $path);
      }
  }
  ?>
```

Selain cookies, aplikasi ini memanfaatkan browser storage untuk menyimpan data secara lokal di perangkat pengguna, sehingga tidak perlu mengirim data ulang ke server untuk setiap permintaan.

```javascript
  <script>
        // Fungsi untuk memuat data karyawan dari localStorage
        function loadEmployees() {
            const employees = JSON.parse(localStorage.getItem('employees')) || [];
            const tableBody = document.getElementById('employeeTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = ''; // Menghapus data tabel sebelumnya

            employees.forEach((employee, index) => {
                // Menambahkan baris baru untuk setiap karyawan
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${employee.name}</td>
                    <td>${employee.position}</td>
                    <td>
                        <!-- Tombol edit dan hapus -->
                        <a onclick="editEmployee(${index})">Edit</a> |
                        <a onclick="deleteEmployee(${index})">Hapus</a>
                    </td>
                `;
            });
        }
```

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
3. **Konfigurasi Database** sesuai dengan petunjuk di bagian `Database Management.
4. **Akses Aplikasi melalui Browser** untuk mulai menggunakan fitur manajemen inventory dan karyawan.

## Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).
