<?php
session_start();
require_once 'includes/CookieHandler.php'; // File eksternal untuk menangani operasi cookie

// Membuat objek CookieHandler
$cookieHandler = new CookieHandler();

// Menangani aksi pengaturan cookie
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_action'])) {
    $action = $_POST['action'];
    $cookieName = $_POST['cookieName'];
    $cookieValue = isset($_POST['cookieValue']) ? $_POST['cookieValue'] : null;

    switch ($action) {
        case 'set':
            if ($cookieName && $cookieValue) {
                // Mengatur cookie dengan durasi 1 jam
                $cookieHandler->setCookie($cookieName, $cookieValue, 3600);
                echo "<script>alert('Cookie berhasil diset!');</script>";
            }
            break;
        
        case 'get':
            // Mengambil nilai cookie berdasarkan nama
            $cookieData = $cookieHandler->getCookie($cookieName);
            echo "<script>alert('Nilai Cookie: " . htmlspecialchars($cookieData) . "');</script>";
            break;
        
        case 'delete':
            // Menghapus cookie berdasarkan nama
            $cookieHandler->deleteCookie($cookieName);
            echo "<script>alert('Cookie berhasil dihapus!');</script>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengelolaan Cookies</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Form Pengelolaan Cookies</h1>
        <nav>
            <!-- Navigasi ke halaman lain -->
            <ul>
                <li><a href="index.php">Halaman Utama</a></li>
                <li><a href="inventory.php">Manajemen Inventory</a></li>
                <li><a href="employees.php">Manajemen Karyawan</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Form untuk pengelolaan cookie -->
        <form method="POST">
            <label for="action">Pilih Aksi:</label>
            <select id="action" name="action" required>
                <option value="set">Set Cookie</option>
                <option value="get">Get Cookie</option>
                <option value="delete">Delete Cookie</option>
            </select>

            <br>

            <!-- Input untuk nama cookie -->
            <label for="cookieName">Nama Cookie:</label>
            <input type="text" id="cookieName" name="cookieName" required>

            <!-- Input untuk nilai cookie -->
            <label for="cookieValue">Nilai Cookie:</label>
            <input type="text" id="cookieValue" name="cookieValue">

            <!-- Tombol submit -->
            <button type="submit" name="submit_action">Lakukan Aksi</button>
        </form>

        <script>
            // Menyesuaikan form berdasarkan aksi yang dipilih
            const actionSelect = document.getElementById('action');
            const cookieValueField = document.getElementById('cookieValue');

            // Perbarui tampilan input 'cookieValue' untuk aksi 'get' atau 'delete'
            actionSelect.addEventListener('change', function() {
                cookieValueField.style.display = (this.value === 'set') ? 'block' : 'none';
            });

            // Memicu perubahan saat pertama kali halaman dimuat
            actionSelect.dispatchEvent(new Event('change'));
        </script>
    </main>

    <footer>
        <p>&copy; 2024 Toko Mebel</p>
    </footer>
</body>
</html>
