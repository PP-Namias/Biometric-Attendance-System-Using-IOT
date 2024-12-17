<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$dbname = "biometric_db";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get JSON data from the POST request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $name = $data['name'];
    $gender = $data['gender'];
    $department = $data['department'];
    $fingerprintId = $data['fingerprintId'];
    $fingerprintImage = $data['fingerprintImage'];

    // Debug print: Check if the data is received
    echo "Received Data: ";
    var_dump($data);  // This will print all incoming data for debugging

    // Check if fingerprintImage is not empty
    if (empty($fingerprintImage)) {
        echo "Error: Fingerprint image is missing or empty.";
        exit;
    }

    // Decode the Base64-encoded fingerprint image
    // You could choose to keep the image as Base64 in the database directly
    // In this case, we store the string without converting it to binary
    // as you mentioned storing it as LONGTEXT
    $fingerprintBinary = base64_decode($fingerprintImage);

    // Check if decoding was successful
    if ($fingerprintBinary === false) {
        echo "Error: Invalid Base64 string for fingerprint image.";
        exit;
    }

    // Debug print: Print the length of the decoded binary data
    echo "Decoded Fingerprint Data Length: " . strlen($fingerprintBinary) . "<br>";

    // Insert data into the database (fingerprintImage as LONGTEXT)
    $stmt = $conn->prepare("INSERT INTO fingerprints (name, gender, department, fingerprintId, fingerprintImage) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $gender, $department, $fingerprintId, $fingerprintImage);  // Fingerprint image is treated as string

    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid data received.";
}

$conn->close();
?>
