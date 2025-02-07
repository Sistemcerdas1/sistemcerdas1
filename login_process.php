<?php
require 'vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

// MQTT Konfigurasi
$server   = 'pf-ze0t95ara879nqe34fax.cedalo.cloud';
$port     = 1883;
$clientId = 'php_client_' . uniqid();
$username = 'data';
$password = 'Ekobilal12345@';

$statusFile = 'lamp_status.json';

if (!file_exists($statusFile)) {
    file_put_contents($statusFile, json_encode([
        'lampu1' => false,
        'lampu2' => false,
        'lampu3' => false,
        'lampu4' => false,
    ]));
}

ob_start(); // Mulai output buffering

// ** Proses Pendaftaran Pengguna **
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    $dbServername = "sql211.infinityfree.com	";
    $dbUsername = "if0_38096229";
    $dbPassword = "Erenwibu12345";
    $dbName = "if0_38096229_iot2";

//     $host = "sql211.infinityfree.com";  // Host database (biasanya 'localhost' jika di server lokal)
// $username = "if0_38096229";   // Nama pengguna MySQL
// $password = "Erenwibu12345";       // Kata sandi MySQL (kosong jika Anda menggunakan konfigurasi default)
// $dbname = "if0_38096229_iot2";  // Nama database yang ingin dihubungkan

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok'); window.history.back();</script>";
        exit;
    }

    $check_user_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username atau email sudah digunakan'); window.history.back();</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO users (fullname, username, email, password) VALUES ('$fullname', '$username', '$email', '$hashed_password')";

    if ($conn->query($insert_query) === TRUE) {
        echo <script>
                alert('Pendaftaran berhasil! Anda akan diarahkan ke halaman login.');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Terjadi kesalahan saat pendaftaran. Silakan coba lagi.'); window.history.back();</script>";
        exit();
    }

    $conn->close();
    exit();
}

ob_end_flush(); // Akhiri output buffering
?>
