<?php

require 'vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$server   = 'pf-ze0t95ara879nqe34fax.cedalo.cloud';
$port     = 1883;
$clientId = 'php_client_' . uniqid();
$topic    = 'test/esp32/data';
$username = 'data';
$password = 'Ekobilal12345@';

$connectionSettings = (new ConnectionSettings())
    ->setUsername($username)
    ->setPassword($password)
    ->setKeepAliveInterval(60);

// Pengaturan koneksi database
$host = 'localhost';
$db   = 'iot';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Fungsi untuk koneksi database
function connectDatabase($dsn, $user, $pass, $options) {
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        echo "Terjadi kesalahan pada koneksi database: " . $e->getMessage() . "\n";
        exit;
    }
}

// Fungsi untuk memasukkan data sensor ke dalam database
function insertSensorData($pdo, $data) {
    // Menyiapkan pernyataan SQL untuk memasukkan data
    $stmt = $pdo->prepare("INSERT INTO sensor_data (temperature, humidity, phTanah1, phTanah2, second, minute, hour, day, month, year) 
                           VALUES (:temperature, :humidity, :phTanah1, :phTanah2, :second, :minute, :hour, :day, :month, :year)");
    $stmt->execute([
        'temperature' => $data['temperature'],
        'humidity' => $data['humidity'],
        'phTanah1' => $data['phTanah1'],
        'phTanah2' => $data['phTanah2'],
        'second' => $data['second'],
        'minute' => $data['minute'],
        'hour' => $data['hour'],
        'day' => $data['day'],
        'month' => $data['month'],
        'year' => $data['year'],
    ]);

    echo "Data berhasil dimasukkan.\n";
}

$mqtt = new MqttClient($server, $port, $clientId);

try {
    $mqtt->connect($connectionSettings, true);
    $pdo = connectDatabase($dsn, $user, $pass, $options); // Koneksi database otomatis

    // Loop untuk meminta data setiap 3 detik
    while (true) {
        $mqtt->subscribe($topic, function (string $topic, string $message) use ($pdo) {
            echo "Pesan diterima: {$message}\n";

            // Memparse data JSON
            $data = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                insertSensorData($pdo, $data); // Menyimpan data ke dalam database
            } else {
                echo "Data JSON tidak valid.\n";
            }
        }, 0);

        // Tunggu selama 3 detik sebelum mengambil data lagi
        sleep(3);

        // Jalankan loop MQTT untuk mendengarkan pesan
        $mqtt->loop();
    }

} catch (\Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
} finally {
    $mqtt->disconnect();
}
