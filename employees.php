<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata halaman -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Karyawan</title>
    <!-- Menghubungkan file CSS untuk styling -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Bagian Header -->
    <header>
        <h1>Manajemen Karyawan</h1>
        <nav>
            <!-- Navigasi ke halaman lain -->
            <ul>
                <li><a href="index.php">Halaman Utama</a></li>
                <li><a href="Inventory.php">Manajemen Inventori</a></li>
                <li><a href="CookiesForm.php">Manajemen Cookies</a></li>
            </ul>
        </nav>
    </header>

    <!-- Konten utama -->
    <main>
        <h2>Tambah / Edit Karyawan</h2>
        <!-- Form untuk menambah atau mengedit data karyawan -->
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

        <h2>Daftar Karyawan</h2>
        <!-- Tabel untuk menampilkan daftar karyawan -->
        <table id="employeeTable">
            <thead>
                <!-- Header tabel -->
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data karyawan akan diisi oleh JavaScript -->
            </tbody>
        </table>
    </main>

    <footer>
        <!-- Footer halaman -->
        <p>&copy; 2024 Toko Mebel</p>
    </footer>

    <!-- Script JavaScript -->
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

        // Fungsi untuk menambah atau mengedit karyawan
        document.getElementById('employeeForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            // Mendapatkan nilai dari form
            const name = document.getElementById('employeeName').value;
            const position = document.getElementById('employeePosition').value;
            const index = document.getElementById('employeeIndex').value;

            const employees = JSON.parse(localStorage.getItem('employees')) || [];

            if (index !== "") {
                // Jika index tidak kosong, berarti sedang mengedit data karyawan
                employees[index].name = name;
                employees[index].position = position;
            } else {
                // Menambahkan data karyawan baru
                employees.push({ name, position });
            }

            // Menyimpan data ke localStorage
            localStorage.setItem('employees', JSON.stringify(employees));

            // Mengosongkan form
            document.getElementById('employeeName').value = '';
            document.getElementById('employeePosition').value = '';
            document.getElementById('employeeIndex').value = '';

            // Memuat ulang daftar karyawan
            loadEmployees();
        });

        // Fungsi untuk menghapus karyawan
        function deleteEmployee(index) {
            const employees = JSON.parse(localStorage.getItem('employees')) || [];
            employees.splice(index, 1); // Menghapus data berdasarkan index

            // Menyimpan data yang diperbarui ke localStorage
            localStorage.setItem('employees', JSON.stringify(employees));

            // Memuat ulang daftar karyawan
            loadEmployees();
        }

        // Fungsi untuk mengedit karyawan
        function editEmployee(index) {
            const employees = JSON.parse(localStorage.getItem('employees')) || [];
            const employee = employees[index];

            // Mengisi form dengan data karyawan yang akan diedit
            document.getElementById('employeeName').value = employee.name;
            document.getElementById('employeePosition').value = employee.position;
            document.getElementById('employeeIndex').value = index; // Menyimpan index karyawan yang sedang diedit
        }

        // Memuat data karyawan saat halaman pertama kali dibuka
        loadEmployees();
    </script>
</body>
</html>
