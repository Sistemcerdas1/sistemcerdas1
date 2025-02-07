<?php
require 'vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$server   = 'pf-ze0t95ara879nqe34fax.cedalo.cloud';
$port     = 1883;
$clientId = 'php_client_' . uniqid();
$username = 'data';
$password = 'Ekobilal12345@';

// Path file untuk menyimpan status lampu
$statusFile = 'lamp_status.json';

// Jika file status belum ada, buat file default
if (!file_exists($statusFile)) {
    file_put_contents($statusFile, json_encode([
        'lampu1' => false,
        'lampu2' => false,
        'lampu3' => false,
        'lampu4' => false,
    ]));
}

// Ambil data dari request JSON
$requestData = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestData['topic'], $requestData['message'])) {
    $topic = $requestData['topic'];
    $message = $requestData['message'];

    // Validasi pesan
    if ($message !== '1' && $message !== '0') {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid message. Must be 1 or 0']);
        exit();
    }

    // Update status lampu di file
    $currentStatus = json_decode(file_get_contents($statusFile), true);
    $lampKey = str_replace('control/', '', $topic);

    if (isset($currentStatus[$lampKey])) {
        $currentStatus[$lampKey] = $message === '1';
        file_put_contents($statusFile, json_encode($currentStatus));

        // Publish ke broker MQTT
        $connectionSettings = (new ConnectionSettings())
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(60);

        $mqtt = new MqttClient($server, $port, $clientId);
        try {
            $mqtt->connect($connectionSettings, true);
            $mqtt->publish($topic, $message, 0, false);
            $mqtt->disconnect();
            echo json_encode(['success' => 'Message published successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error publishing message: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid lamp topic']);
    }
}

// Endpoint untuk mendapatkan status lampu
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo file_get_contents($statusFile);
}
