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
