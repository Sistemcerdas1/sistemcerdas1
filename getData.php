<?php
include('iot.php');

// Ambil jenis data dari parameter URL
$data_type = isset($_GET['type']) ? $_GET['type'] : 'temperature';  // Default 'temperature'

// Menentukan query berdasarkan jenis data yang diminta
if ($data_type == 'temperature') {
    $sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
} elseif ($data_type == 'ph1') {
    $sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
} elseif ($data_type == 'ph2') {
    $sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
} else {
    $sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1"; // Default temperature
}

// Eksekusi query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data terakhir dari sensor
    $row = $result->fetch_assoc();
    echo json_encode([
        'temperature' => $row['temperature'],
        'phTanah1' => $row['phTanah1'],
        'phTanah2' => $row['phTanah2'],
        'hour' => date('H', strtotime($row['timestamp'])),
        'minute' => date('i', strtotime($row['timestamp'])),
        'second' => date('s', strtotime($row['timestamp'])),
        'day' => date('d', strtotime($row['timestamp'])),
        'month' => date('m', strtotime($row['timestamp'])),
        'year' => date('Y', strtotime($row['timestamp'])),
    ]);
} else {
    echo json_encode([]);
}

$conn->close();
?>
