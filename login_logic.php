<?php
session_start();
require 'db.php'; // Pastikan file ini berisi koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan Password harus diisi.';
        header('Location: login.php');
        exit();
    }

    // Query untuk memeriksa username dan password
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan data ke sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Arahkan ke halaman dashboard atau halaman lain
            header('Location: log.php');
            exit();
        } else {
            $_SESSION['error'] = 'Password salah.';
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Username tidak ditemukan.';
        header('Location: index.php');
        exit();
    }
}
?>
