<?php
// Ganti dengan konfigurasi database Anda
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "riwayat_kontrol";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil pesan log dari POST
if (isset($_POST['message'])) {
    $message = $_POST['message'];

    // Ambil tanggal dan waktu saat ini
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    // Masukkan log ke dalam tabel
    $sql = "INSERT INTO log_aktivitas (tanggal, waktu, status_lampu) VALUES ('$tanggal', '$waktu', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Log berhasil disimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
