<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Sensor</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Styling untuk Body */
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #808080, #F8F9F9);
            position: relative;
            overflow-y: auto;
        }

        /* Sidebar styling */
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
            background-color: #495057;
            cursor: pointer;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        /* Konten utama */
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

        .content.margin-left {
            margin-left: 270px;
        }

        /* Tombol toggle sidebar */
        .toggle-sidebar-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #555;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
            border-radius: 5px;
            font-size: 20px;
        }

        .toggle-sidebar-btn:hover {
            background-color: #444;
        }

        /* Styling grafik */
        #chart-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100%;
            height: auto;
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

    <!-- Grafik Line untuk Temperature, pH Tanah 1, dan pH Tanah 2 -->
    <div id="chart-container">
        <canvas id="temperatureChart"></canvas>
    </div>
    <div id="chart-container">
        <canvas id="ph1Chart"></canvas>
    </div>
    <div id="chart-container">
        <canvas id="ph2Chart"></canvas>
    </div>

    <footer>
        &copy; Website Penyiraman Otomatis Tanaman Sawi
    </footer>

    <script>
        /* Fungsi Toggle Sidebar */
        const toggleSidebar = () => {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            sidebar.classList.toggle('show');
            content.classList.toggle('margin-left');
        };

        // Inisialisasi grafik untuk Temperature
        const ctxTemp = document.getElementById('temperatureChart').getContext('2d');
        const temperatureChart = new Chart(ctxTemp, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Temperature (°C)',
                    data: [],
                    borderColor: '#ff6b6b',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                    },
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Inisialisasi grafik untuk pH Tanah 1
        const ctxPh1 = document.getElementById('ph1Chart').getContext('2d');
        const ph1Chart = new Chart(ctxPh1, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'pH Tanah 1',
                    data: [],
                    borderColor: '#ffd6a5',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                    },
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Inisialisasi grafik untuk pH Tanah 2
        const ctxPh2 = document.getElementById('ph2Chart').getContext('2d');
        const ph2Chart = new Chart(ctxPh2, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'pH Tanah 2',
                    data: [],
                    borderColor: '#fdffb6',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                    },
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // Fungsi untuk memperbarui grafik dengan data terbaru
        function updateChart() {
            $.ajax({
                url: 'get_sensor_data.php', // File PHP yang mengambil data dari DB
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const temp = data.temperature;
                    const ph1 = data.phTanah1;
                    const ph2 = data.phTanah2;
                    const time = Date.now(); // Menggunakan waktu sekarang sebagai label untuk X

                    // Update data grafik untuk Temperature
                    temperatureChart.data.labels.push(time);
                    temperatureChart.data.datasets[0].data.push(temp);
                    temperatureChart.update();

                    // Update data grafik untuk pH Tanah 1
                    ph1Chart.data.labels.push(time);
                    ph1Chart.data.datasets[0].data.push(ph1);
                    ph1Chart.update();

                    // Update data grafik untuk pH Tanah 2
                    ph2Chart.data.labels.push(time);
                    ph2Chart.data.datasets[0].data.push(ph2);
                    ph2Chart.update();
                }
            });
        }

        // Panggil fungsi updateChart setiap 2 detik
        setInterval(updateChart, 2000);
        updateChart(); // Panggil sekali di awal untuk menampilkan data pertama
    </script>
</body>

</html>
