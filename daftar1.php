<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "iot";

    $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid'); window.history.back();</script>";
        exit;
    }

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
        echo "<script>
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
?>
