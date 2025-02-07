<?php
if (isset($_GET['message']) && $_GET['message'] === 'success') {
    echo '<div class="alert alert-success">Pendaftaran berhasil. Silakan login.</div>';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Memuat Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menambahkan gradient latar belakang abu-abu putih lembut */
        body {
            background: linear-gradient(to right, #f0f0f0, #d3d3d3);
        }

        /* Memperbesar ukuran logo dan membuatnya bulat */
        .logo {
            width: 120px;
            height: 120px;
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%; /* Membuat logo bulat */
        }

        /* Memberikan padding dan efek bayangan pada card */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Warna latar belakang untuk form login */
        .card-body {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
        }

        /* Menyesuaikan warna form input */
        .form-control {
            background-color: #f8f9fa; /* Warna abu-abu lembut untuk input */
            border: 1px solid #ccc; /* Border ringan */
        }

        /* Warna tombol login */
        .btn-primary {
            background-color: #6c757d; /* Warna abu-abu lembut untuk tombol */
            border-color: #6c757d;
        }

        .btn-primary:hover {
            background-color: #5a6268; /* Warna sedikit lebih gelap saat hover */
            border-color: #545b62;
        }

        /* Tautan daftar */
        .card-footer a {
            color: #6c757d;
        }
    </style>
</head>

<body>

    <!-- Membuat layout untuk halaman login dengan Flexbox -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <!-- Logo di bagian atas dengan ukuran diperbesar dan bulat -->
                <img src="EcoMear.jpg" alt="Logo" class="logo">

                <!-- Pesan sukses jika diarahkan dari halaman pendaftaran -->
                <?php
                if (isset($_GET['message']) && $_GET['message'] === 'success') {
                    echo '<div class="alert alert-success text-center" role="alert">
                              Pendaftaran berhasil! Silakan login menggunakan akun Anda.
                          </div>';
                }
                ?>

                <!-- Judul form login -->
                <h5 class="card-title text-center">Login</h5>
                <form action="login_logic.php" method="POST">
                    <!-- Field untuk memasukkan username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <!-- Field untuk memasukkan password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- Tombol untuk login -->
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <!-- Tautan untuk mendaftar -->
                <div class="mt-3 text-center">
                    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
