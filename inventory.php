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

// Proses pengiriman formulir untuk menambahkan data baru (Create)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_inventory'])) {
    // Mengambil data dari formulir dengan proteksi terhadap SQL Injection
    $itemName = $conn->real_escape_string($_POST['itemName']);
    $itemCategory = $conn->real_escape_string($_POST['itemCategory']);
    $itemQuantity = (int) $_POST['itemQuantity'];
    $itemPrice = (float) $_POST['itemPrice'];
    
    // Query untuk menambahkan data baru ke tabel `inventory`
    $query = "INSERT INTO inventory (name, category, quantity, price) VALUES ('$itemName', '$itemCategory', '$itemQuantity', '$itemPrice')";
    
    // Mengeksekusi query dan memberikan notifikasi
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Barang berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

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

// Query untuk mendapatkan semua data inventory dari tabel
$query = "SELECT * FROM inventory";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Informasi metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Toko Mebel</title>
    <!-- Link ke file CSS dan JavaScript -->
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <!-- Header halaman -->
        <h1>Manajemen Inventory</h1>
        <nav>
            <!-- Navigasi ke halaman lain -->
            <ul>
            <li><a href="index.php">Halaman Utama</a></li>
            <li><a href="employees.php">Manajemen Karyawan</a></li>
            <li><a href="CookiesForm.php">Manajemen Cookies</a></li>
            </ul>
      </nav>
    </header>

    <main>
        <!-- Form untuk menambah atau mengedit data -->
        <h2>Tambah/Edit Barang</h2>
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

        <!-- Tabel daftar barang -->
        <h2>Daftar Barang</h2>
        <table id="inventoryTable">
            <thead>
                <!-- Header tabel -->
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <!-- Menampilkan data barang -->
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['quantity']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td>
                                <!-- Tombol edit dan hapus -->
                                <a href="inventory.php?edit=<?= $row['id'] ?>">Edit</a> | 
                                <a href="inventory.php?delete=<?= $row['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Jika tidak ada data -->
                    <tr>
                        <td colspan="5">Tidak ada data barang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <!-- Footer halaman -->
        <p>&copy; 2024 Toko Mebel</p>
    </footer>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
