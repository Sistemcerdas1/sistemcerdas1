<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sensor</title>
    <script>
        function fetchData() {
            fetch('data.json') // Ambil data dari file JSON
                .then(response => response.json())
                .then(data => {
                    // Tampilkan data di dalam elemen dengan id="data-container"
                    const container = document.getElementById('data-container');
                    container.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Panggil fetchData setiap 5 detik
        setInterval(fetchData, 5000);

        // Panggil fetchData sekali saat halaman pertama kali dimuat
        window.onload = fetchData;
    </script>
</head>

<body>
    <h1>Data Sensor</h1>
    <div id="data-container">
        <p>Loading data...</p>
    </div>
</body>

</html>