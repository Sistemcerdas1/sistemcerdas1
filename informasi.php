<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menjamin body dan html mengisi seluruh layar dan memungkinkan scroll */
        body {
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: linear-gradient(135deg, #808080, #F8F9F9); /* Gradien abu-abu ke putih lembut */
    position: relative;
    overflow-y: auto;  /* Allow scrolling */
}

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #333; /* Sidebar menjadi abu-abu gelap */
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: -250px;
            bottom: 0;
            color: white;
            transition: left 0.5s ease-in-out; /* Efek transisi saat sidebar terbuka */
            z-index: 9;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #fff;
        }

        .sidebar ul li:hover {
            background-color: #495057; /* Warna hover sidebar */
            cursor: pointer;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .content {
            flex: 1;
            width: 100%;
            padding: 20px;
            overflow-y: auto;  /* Enable scrolling */
            height: auto;  /* Ensure content area grows with content */
            box-sizing: border-box;
            padding-bottom: 60px;
            position: relative;
            z-index: 1; /* Konten tetap di atas logo */
        }

        .content.margin-left {
            margin-left: 270px;
        }

        .toggle-sidebar-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        background-color: #555; /* Mengubah warna latar belakang tombol menjadi abu-abu gelap */
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
        border-radius: 5px; /* Menambahkan sudut membulat pada tombol */
        font-size: 20px; /* Memperbesar ukuran font untuk tampilan lebih jelas */
        }

        .toggle-sidebar-btn:hover {
    background-color: #444; /* Efek hover menjadi sedikit lebih gelap */
}

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            width: 100%;
            margin-top: auto; /* Memastikan footer selalu di bawah */
        }

    </style>
</head>
<button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li onclick="loadDashboard()"><a href="log.php">Dashboard</a></li>
            <li onclick="loadLampControl()"><a href="control.php">Kontrol Lampu</a></li>
            <li><a href="grafik2.php">Grafik</a></li>
            <li><a href="informasi.php">Informasi</a></li>
            <li onclick="logout()"><a href="index.php">Log Out</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        <div class="container my-4">
            <h1 class="text-center mb-4">Informasi Website</h1>

            <div class="mb-4">
                <h2>Tentang Website</h2>
                <p>Website ini juga mendukung integrasi dengan perangkat IoT untuk memudahkan pengelolaan lahan secara otomatis. Dengan antarmuka yang ramah pengguna, Anda dapat memantau semua data secara terpusat, mengatur parameter lingkungan seperti intensitas cahaya, kelembapan, dan suhu melalui kontrol jarak jauh. Fitur analisis data memungkinkan Anda untuk memahami tren pertumbuhan tanaman, mengidentifikasi potensi masalah lebih awal, dan mengambil keputusan yang lebih tepat. Dengan kemudahan ini, pertanian sawi Anda tidak hanya menjadi lebih efisien, tetapi juga lebih ramah lingkungan dan hemat energi. Website ini membantu Anda mencapai hasil maksimal dengan upaya minimal.</p>
            </div>

            <div class="mb-4">
                <h2>Tentang Pengembang</h2>
                <p>Selain itu, tim pengembang juga berkomitmen untuk terus mengembangkan dan meningkatkan platform ini dengan pembaruan berkala. Mereka selalu berusaha untuk mengintegrasikan feedback pengguna untuk memperbaiki pengalaman menggunakan website ini. Setiap anggota tim memiliki latar belakang yang kuat dalam bidang teknologi dan pertanian, memastikan bahwa solusi yang dihadirkan tidak hanya inovatif, tetapi juga aplikatif untuk kebutuhan nyata di lapangan. Tim ini berencana untuk membawa lebih banyak fitur pintar, termasuk analitik berbasis AI dan solusi pemantauan berbasis cloud, untuk lebih mendukung pertanian yang lebih cerdas dan berkelanjutan.</p>
                <ul>
                    <li><strong>Nama Tim:</strong> Smart System for Mustard Plant Growth</li>
                    <li><strong>Email:</strong> aerrenharinal283@gmail.com</li>
                    <li><strong>Kontak:</strong> 0895 0242 1624</li>
                </ul>
                <h3>Anggota Tim:</h3>
                <ul>
                    <li>
                        <img src="eko.jpeg" alt="Eko Bilal Saputra" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                        Eko Bilal Saputra - Programmer
                    </li>
                    <li>
                        <img src="erren.jpeg" alt="Muhammad Aerren Harinal" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                        Muhammad Aerren Harinal - Desainer UI/UX
                    </li>
                    <li>
                        <img src="melvin.jpeg" alt="Melvin Erdian" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                        Melvin Erdian - Perancang Sistem
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <h2>Visi dan Misi</h2>
                <p><strong>Visi:</strong> Mengintegrasikan teknologi dengan pertanian untuk mendukung pertumbuhan tanaman yang lebih efisien dan berkelanjutan.</p>
                <p><strong>Misi:</strong></p>
                <ul>
                    <li>Menyediakan platform monitoring dan kontrol pertanian yang terjangkau.</li>
                    <li>Mendukung para petani dengan teknologi modern yang user-friendly.</li>
                    <li>Mempermudah pengambilan keputusan melalui data real-time dan analitik.</li>
                </ul>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; Website Penyiraman Otomatis Tanaman Sawi </p>
    </footer>

    <script>
        const toggleSidebar = () => {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('show');
            content.classList.toggle('margin-left');
        };
    </script>
</body>
</html>
