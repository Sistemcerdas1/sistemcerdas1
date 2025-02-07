<?php
// Koneksi ke database
$host = "localhost";
$dbname = "iot";
$username = "root"; // Sesuaikan dengan username MySQL Anda
$password = ""; // Sesuaikan dengan password MySQL Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data sensor terbaru dari tabel sensor_data
    $stmt = $pdo->prepare("SELECT temperature, phTanah1, phTanah2, second, minute, hour, day, month, year FROM sensor_data ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    // Ambil data
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Format data sebagai JSON
    echo json_encode($data);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
