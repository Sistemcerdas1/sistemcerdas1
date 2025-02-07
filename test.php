<?php
// Konfigurasi database

$host = "sql211.infinityfree.com";  // Host database (biasanya 'localhost' jika di server lokal)
$username = "if0_38096229";   // Nama pengguna MySQL
$password = "Erenwibu12345";       // Kata sandi MySQL (kosong jika Anda menggunakan konfigurasi default)
$dbname = "if0_38096229_iot2";  // Nama database yang ingin dihubungkan

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);  // Menampilkan pesan kesalahan jika gagal koneksi
} else {
    echo "Koneksi berhasil!";
}

// Menutup koneksi
$conn->close();
?>
