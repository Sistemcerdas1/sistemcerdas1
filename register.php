<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <!-- Memuat Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menambahkan gradient latar belakang abu-abu putih lembut */
        body {
            background: linear-gradient(to right, #f0f0f0, #d3d3d3);
        }

        /* Menyesuaikan ukuran logo dan membuatnya bulat */
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

        /* Warna latar belakang untuk form pendaftaran */
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

        /* Warna tombol daftar */
        .btn-primary {
            background-color: #6c757d; /* Warna abu-abu lembut untuk tombol */
            border-color: #6c757d;
        }

        .btn-primary:hover {
            background-color: #5a6268; /* Warna sedikit lebih gelap saat hover */
            border-color: #545b62;
        }

        /* Tautan login */
        .card-footer a {
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <!-- Logo di bagian atas dengan ukuran diperbesar dan bulat -->
                <img src="EcoMear.jpg" alt="Logo" class="logo">

                <h5 class="card-title text-center">Pendaftaran Akun</h5>
                <form action="daftar1.php" method="POST">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>

                <!-- Tautan kembali ke login -->
                <div class="mt-3 text-center">
                    <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
