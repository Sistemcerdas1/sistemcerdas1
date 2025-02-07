<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda jika berbeda
$password = "";      // Ganti dengan password database Anda jika ada
$dbname = "iot"; // Nama database yang benar

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data terbaru
$sql = "SELECT temperature, humidity, phTanah1, phTanah2, second, minute, hour, day, month, year FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data dari hasil query
    $row = $result->fetch_assoc();
    // Mengembalikan data dalam format JSON
    echo json_encode($row);
} else {
    echo json_encode([]);
}

// Menutup koneksi
$conn->close();
?>