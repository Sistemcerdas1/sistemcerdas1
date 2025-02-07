<!-- <?php
// Connect to the database
$servername = "localhost"; // Update with your server details
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "iot"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the latest data from the sensor_data table
$sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the latest row
    $row = $result->fetch_assoc();
    echo json_encode([
        'hour' => date('H', strtotime($row['timestamp'])),
        'minute' => date('i', strtotime($row['timestamp'])),
        'second' => date('s', strtotime($row['timestamp'])),
        'day' => date('d', strtotime($row['timestamp'])),
        'month' => date('m', strtotime($row['timestamp'])),
        'year' => date('Y', strtotime($row['timestamp'])),
        'temperature' => $row['temperature'], // Assuming the column is named 'temperature'
        'phTanah1' => $row['phTanah1'], // Assuming the column is named 'phTanah1'
        'phTanah2' => $row['phTanah2'] // Assuming the column is named 'phTanah2'
    ]);
} else {
    echo json_encode([]);
}

$conn->close();
?>
 -->