<?php
require_once 'vendor/autoload.php'; // Include Google API PHP Client library

$client = new Google\Client();

// Set the Google API credentials
$client->setClientId("873466661966-o0fq28gkb65c6letke5lurjccjoqie96.apps.googleusercontent.com"); // Replace with your Google Client ID
$client->setClientSecret("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"); // Replace with your Google Client Secret
$client->setRedirectUri("http://localhost/Biometric-Attendance-System-Using-IOT/BiometricAttendanceSystem/redirect.php");
$client->addScope("email");
$client->addScope("profile");

if (!isset($_GET["code"])) {
    exit("Login failed");
}

// Exchange authorization code for access token
$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

if (isset($token['error'])) {
    exit("Failed to fetch access token: " . $token['error']);
}

$client->setAccessToken($token["access_token"]);

$oauth2 = new Google\Service\Oauth2($client);
$userinfo = $oauth2->userinfo->get();

// Safely get the name or use email as fallback
$name = isset($userinfo->name) && !empty($userinfo->name) ? $userinfo->name : $userinfo->email;

// Generate activation token
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

// Include the database connection file
$mysqli = require __DIR__ . "/connectDB.php";

// Ensure the connection is valid
if ($mysqli instanceof mysqli === false) {
    die("Failed to connect to the database: {$mysqli->connect_error}");
}

// Check if the user already exists
$sql = "SELECT id FROM admin WHERE google_id = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare SQL statement: " . $mysqli->error . " - SQL: " . $sql);
}

$stmt->bind_param("s", $userinfo->id);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If user doesn't exist, insert a new record
if (!$user) {
    $sql = "INSERT INTO admin (admin_email, admin_name, google_id, account_activation_hash) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("Failed to prepare SQL statement for insertion: " . $mysqli->error);
    }
    $stmt->bind_param("ssss", $userinfo->email, $name, $userinfo->id, $activation_token_hash);
    if (!$stmt->execute()) {
        die("Failed to execute SQL insertion: " . $stmt->error);
    }

    // Retrieve the newly inserted user data (in case you want to store user ID or other details)
    $user_id = $mysqli->insert_id; // Get the last inserted ID
} else {
    // If the user exists, retrieve the user ID
    $user_id = $user['id'];
}

// Set session variables
session_start();
$_SESSION['user_id'] = $user_id;
$_SESSION['email'] = $userinfo->email;
$_SESSION['name'] = $name;

// Redirect to a welcome page or dashboard
header("Location: index.php");
exit;
?>
