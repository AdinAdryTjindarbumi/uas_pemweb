<?php
session_start();
header('Content-Type: application/json');

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'toko_mebel';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => $conn->connect_error]));
}

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

$conn->close();
?>
