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
