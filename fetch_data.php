<?php
include 'db.php';

// Query untuk mengambil data suhu terbaru
$query_temperature = "SELECT temperature, CONCAT(hour, ':', minute, ':', second) as time 
                      FROM sensor_data 
                      ORDER BY id DESC LIMIT 20"; // Mengambil 20 data terbaru
$result_temperature = $conn->query($query_temperature);
if (!$result_temperature) {
    die("Error Query Temperature: " . $conn->error);
}

$temperature_data = [];
$temperature_time = [];

while ($row = $result_temperature->fetch_assoc()) {
    $temperature_data[] = $row['temperature'];
    $temperature_time[] = $row['time'];
}

// Membalikkan urutan agar data terbaru berada di kanan grafik
$temperature_data = array_reverse($temperature_data);
$temperature_time = array_reverse($temperature_time);

// Query untuk mengambil data pH terbaru
$query_ph = "SELECT ph, CONCAT(hour, ':', minute, ':', second) as time 
             FROM ph_data 
             ORDER BY id DESC LIMIT 20"; // Mengambil 20 data terbaru
$result_ph = $conn->query($query_ph);
if (!$result_ph) {
    die("Error Query pH: " . $conn->error);
}

$ph_data = [];
$ph_time = [];

while ($row = $result_ph->fetch_assoc()) {
    $ph_data[] = $row['ph'];
    $ph_time[] = $row['time'];
}

// Membalikkan urutan agar data terbaru berada di kanan grafik
$ph_data = array_reverse($ph_data);
$ph_time = array_reverse($ph_time);

// Menggabungkan data suhu dan pH ke dalam satu respons JSON
$response = [
    'temperature' => [
        'data' => $temperature_data,
        'time' => $temperature_time
    ],
    'ph' => [
        'data' => $ph_data,
        'time' => $ph_time
    ]
];

header('Content-Type: application/json');

echo json_encode($response);

$conn->close();
?>
