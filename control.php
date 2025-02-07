<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Control Lampu</title>
    <style>
        /* Gaya untuk body halaman */
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

        .content {
            flex: 1;
            width: 100%;
            padding: 20px;
            overflow-y: auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center; /* Menyusun konten di tengah */
            margin-bottom: 100px; /* Memberikan jarak pada footer */
        }

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

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            justify-content: center;
        }

        .lamp-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .lamp-box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .lamp-box label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .lamp-box img {
            width: 40px;
            margin-bottom: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .log-container {
            width: 100%;
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }

        .log-entry {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        #log {
            max-height: 300px;
            overflow-y: auto; /* Membuat log dapat di-scroll jika terlalu panjang */
        }
    </style>
</head>

<body>
    <!-- Tombol Toggle Sidebar -->
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

    <!-- Konten -->
    <div class="content" id="content">
        <h1>Dashboard Control Lampu</h1>
        <div class="container">
            <!-- Lampu 1 -->
            <div class="lamp-box">
                <img src="pump.png" alt="Lampu 1 Logo">
                <label for="lampu1">Pompa 1</label>
                <label class="switch">
                    <input type="checkbox" id="lampu1" onclick="publishMessage('lampu1', this.checked)">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Lampu 2 -->
            <div class="lamp-box">
                <img src="pump.png" alt="Lampu 2 Logo">
                <label for="lampu2">Pompa 2</label>
                <label class="switch">
                    <input type="checkbox" id="lampu2" onclick="publishMessage('lampu2', this.checked)">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Lampu 3 -->
            <div class="lamp-box">
                <img src="pump.png" alt="Lampu 3 Logo">
                <label for="lampu3">Pompa 3</label>
                <label class="switch">
                    <input type="checkbox" id="lampu3" onclick="publishMessage('lampu3', this.checked)">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Lampu 4 -->
            <div class="lamp-box">
                <img src="pump.png" alt="Lampu 4 Logo">
                <label for="lampu4">Pompa 4</label>
                <label class="switch">
                    <input type="checkbox" id="lampu4" onclick="publishMessage('lampu4', this.checked)">
                    <span class="slider"></span>
                </label>
            </div>
        </div>

        <!-- Log Aktivitas -->
        <div class="log-container">
            <h2>Log Aktivitas</h2>
            <div id="log">
                <div class="log-entry">Log aktivitas akan muncul di sini...</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; Website Penyiraman Otomatis Tanaman Sawi
    </footer>

    <!-- Script JavaScript -->
    <script>
    window.onload = function() {
        const lampIds = ["lampu1", "lampu2", "lampu3", "lampu4"];

        // Ambil status lampu dari server (PHP)
        fetch("publish.php")
            .then(response => response.json())
            .then(status => {
                lampIds.forEach(lampId => {
                    const state = status[lampId] || false;
                    document.getElementById(lampId).checked = state;
                    localStorage.setItem(lampId, state);
                });
            });

        // Load log dari localStorage
        loadLog();
    };

    function publishMessage(lampId, state) {
        const topic = `control/${lampId}`;
        const message = state ? "1" : "0";

        // Kirim request ke PHP buat publish MQTT
        fetch("publish.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ topic, message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addLogEntry(`${lampId} di ${state ? "hidupkan" : "matikan"}`);
                localStorage.setItem(lampId, state);
            } else {
                alert("Gagal mengontrol lampu: " + data.error);
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function addLogEntry(message) {
        const logContainer = document.getElementById("log");
        const logList = JSON.parse(localStorage.getItem("logList")) || [];
        const logEntry = `${new Date().toLocaleString()} - ${message}`;
        logList.unshift(logEntry);
        localStorage.setItem("logList", JSON.stringify(logList));

        loadLog();
    }

    function loadLog() {
        const logContainer = document.getElementById("log");
        const logList = JSON.parse(localStorage.getItem("logList")) || [];
        logContainer.innerHTML = "";
        logList.forEach(log => {
            const newLog = document.createElement("div");
            newLog.className = "log-entry";
            newLog.textContent = log;
            logContainer.appendChild(newLog);
        });
    }

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("show");
        document.getElementById("content").classList.toggle("margin-left");
    }

    function loadDashboard() {
        addLogEntry("Berpindah ke halaman Dashboard.");
    }

    function loadLampControl() {
        addLogEntry("Berpindah ke halaman Kontrol Lampu.");
    }

    function logout() {
        addLogEntry("User telah logout.");
    }
</script>

</body>

</html>
