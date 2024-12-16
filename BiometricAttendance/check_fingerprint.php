<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biometric_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to decode Base64 fingerprint data
function decodeFingerprint($base64Data) {
    return base64_decode($base64Data);
}

// Retrieve the Base64 fingerprint template from the request
if (isset($_POST['fingerprint_template'])) {
    $base64Fingerprint = $_POST['fingerprint_template'];

    // Decode the received Base64 fingerprint template
    $receivedTemplate = decodeFingerprint($base64Fingerprint);

    // Query the database to retrieve stored fingerprint templates
    $sql = "SELECT fingerprintId, fingerprintImage FROM fingerprints";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Compare the received template with the stored template (binary form)
            $storedTemplate = $row['fingerprintImage'];

            // Perform the comparison (binary match)
            if ($receivedTemplate == $storedTemplate) {
                // Fingerprint matched
                echo json_encode(["status" => "success", "message" => "Fingerprint matched!", "fingerprint_id" => $row['fingerprint_id']]);
                exit();
            }
        }

        // No match found
        echo json_encode(["status" => "error", "message" => "No matching fingerprint found."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No fingerprint records found in the database."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No fingerprint template received."]);
}

// Close the connection
$conn->close();
?>
