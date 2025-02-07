<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Data Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #808080, #F8F9F9);
            position: relative;
            overflow-y: auto;
        }

        .sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: #333;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: -250px;
            bottom: 0;
            color: white;
            transition: left 0.5s ease-in-out;
            z-index: 9999; /* Sidebar di atas konten lain */
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
            background-color: #495057;
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
            overflow-y: auto;
            height: auto;
            box-sizing: border-box;
            padding-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        /* Tombol untuk toggle sidebar */
.toggle-sidebar-btn {
    position: fixed; /* Gunakan fixed agar tetap di tempat meski halaman discroll */
    top: 20px;
    left: 20px;
    background-color: #555;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1050; /* Pastikan tombol berada di atas semua elemen, termasuk sidebar */
    border-radius: 5px;
    font-size: 20px;
}

.toggle-sidebar-btn:hover {
    background-color: #444;
}

/* Sidebar yang muncul */
.sidebar {
    min-height: 100vh;
    width: 250px;
    background-color: #333;
    padding-top: 20px;
    position: fixed;
    top: 0;
    left: -250px; /* Sidebar disembunyikan pada posisi ini */
    bottom: 0;
    color: white;
    transition: left 0.5s ease-in-out;
    z-index: 1000; /* Pastikan sidebar di bawah tombol */
}

.sidebar.show {
    left: 0; /* Sidebar muncul dengan mengubah posisi kiri menjadi 0 */
}


        .card-overview {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .card {
            flex: 1 1 calc(25% - 20px);
            min-width: 200px;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        table th {
            position: sticky;
            top: 0;
            background-color: #343a40;
            color: #fff;
        }

        .new-data {
            background-color: rgb(60, 241, 15);
            animation: highlight 3s ease-in-out;
        }

        @keyframes highlight {
            0% {
                background-color: rgb(15, 241, 109);
            }

            100% {
                background-color: #ffffff;
            }
        }

        .chart-container {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
            height: 400px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            width: 100%;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .card-overview {
                display: block;
                text-align: center;
            }

            .card {
                flex: 1 1 100%;
                margin-bottom: 20px;
            }

            .toggle-sidebar-btn {
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 999;
            }

            .table-container {
                max-height: 300px;
            }

            .chart-container {
                max-width: 100%;
                margin: 0 auto;
            }
        }

        @media (max-width: 576px) {
            .card-overview {
                padding: 0 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Toggle Sidebar Button -->
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

    <!-- Main Content -->
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Dashboard Log</a>
            </div>
        </nav>

        <div class="container my-4">
            <h1 class="text-center mb-4">Dashboard Data Log</h1>

            <!-- Overview Cards -->
            <div class="card-overview mb-4">
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <img src="temprature.png" alt="Temperature Logo" class="img-fluid mb-2" style="max-height: 50px;">
                        <h5 class="card-title"></h5>
                        <p class="card-text fs-3" id="temp-overview"><?php echo $data['temperature'] . "°C"; ?></p>
                    </div>
                </div>
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <img src="humidity.png" alt="Humidity Logo" class="img-fluid mb-2" style="max-height: 50px;">
                        <h5 class="card-title"></h5>
                        <p class="card-text fs-3" id="humidity-overview"><?php echo $data['humidity'] . "%"; ?></p>
                    </div>
                </div>
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <img src="phtanah.png" alt="pH Tanah 1 Logo" class="img-fluid mb-2" style="max-height: 50px;">
                        <h5 class="card-title"></h5>
                        <p class="card-text fs-3" id="ph1-overview"><?php echo $data['ph_tanah1']; ?></p>
                    </div>
                </div>
                <div class="card bg-light text-center">
                    <div class="card-body">
                        <img src="phtanah.png" alt="pH Tanah 2 Logo" class="img-fluid mb-2" style="max-height: 50px;">
                        <h5 class="card-title"></h5>
                        <p class="card-text fs-3" id="ph2-overview"><?php echo $data['ph_tanah2']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-container mb-4">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Menit</th>
                            <th>Detik</th>
                            <th>Temperature (&deg;C)</th>
                            <th>Humidity (%)</th>
                            <th>pH Tanah 1</th>
                            <th>pH Tanah 2</th>
                        </tr>
                    </thead>
                    <tbody id="log-body">
                        <tr>
                            <td colspan="10" class="text-center">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Grafik -->
            <div class="chart-container" id="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; Website Penyiraman Otomatis Tanaman Sawi</p>
    </footer>

    <script>
        const labels = [];  // Menyimpan label dalam format "Menit:Detik"
        const temperatureData = [];
        const humidityData = [];
        const ph1Data = [];
        const ph2Data = [];

        const fetchData = () => {
            fetch('http://localhost/sistemcerdas1/end.php') // Ganti dengan URL PHP Anda
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('log-body');
                    
                    // Ambil waktu saat data diterima (misalnya dari server)
                    const currentDate = new Date();
                    const currentTime = `${currentDate.getMinutes()}:${currentDate.getSeconds()}`;  // Format Menit:Detik
                    
                    // Menambahkan data ke tabel log
                    const row =
                        `<tr class="new-data">
                            <td>${data.year}</td>
                            <td>${data.month}</td>
                            <td>${data.day}</td>
                            <td>${data.hour}</td>
                            <td>${data.minute}</td>
                            <td>${data.second}</td>
                            <td>${data.temperature}°C</td>
                            <td>${data.humidity}%</td>
                            <td>${data.phTanah1}</td>
                            <td>${data.phTanah2}</td>
                        </tr>`;

                    tableBody.insertAdjacentHTML('afterbegin', row);

                    while (tableBody.rows.length > 5) {
                        tableBody.deleteRow(tableBody.rows.length - 1);
                    }

                    // Update indikator
                    document.getElementById('temp-overview').textContent = `${data.temperature}°C`;
                    document.getElementById('humidity-overview').textContent = `${data.humidity}%`;
                    document.getElementById('ph1-overview').textContent = data.phTanah1;
                    document.getElementById('ph2-overview').textContent = data.phTanah2;

                    // Update data grafik
                    temperatureData.push(data.temperature);
                    humidityData.push(data.humidity);
                    ph1Data.push(data.phTanah1);
                    ph2Data.push(data.phTanah2);

                    // Update label menggunakan waktu terbaru dalam format "Menit:Detik"
                    labels.push(currentTime);

                    // Limit the data length (keeping only the latest 6 data points)
                    if (temperatureData.length > 6) {
                        temperatureData.shift();
                        humidityData.shift();
                        ph1Data.shift();
                        ph2Data.shift();
                        labels.shift();
                    }

                    // Update grafik
                    myChart.update();
                })
                .catch(error => console.error('Error fetching data:', error));
        };

        // Panggil fetchData secara berkala
        setInterval(fetchData, 5000);
        window.onload = fetchData;

        // Konfigurasi Grafik
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (°C)',
                    data: temperatureData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false,
                },
                {
                    label: 'Humidity (%)',
                    data: humidityData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    fill: false,
                },
                {
                    label: 'pH Tanah 1',
                    data: ph1Data,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    fill: false,
                },
                {
                    label: 'pH Tanah 2',
                    data: ph2Data,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                }
            ]
        };

        const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        animation: {
            duration: 1000,  // Durasi animasi dalam milidetik
            easing: 'easeInOutQuad'  // Easing function untuk transisi yang lebih halus
        },
        plugins: {
            title: {
                display: true,
                text: 'Grafik Suhu, Kelembaban, dan pH Tanah'
            }
        }
    }
};


        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        // Fungsi untuk menampilkan atau menyembunyikan sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
    </script>

</body>

</html>
