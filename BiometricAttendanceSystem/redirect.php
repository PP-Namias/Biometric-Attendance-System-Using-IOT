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
// Include the database connection file
$conn = require __DIR__ . "/connectDB.php";

// Ensure the connection is valid
if ($conn instanceof mysqli === false) {
    die("Failed to connect to the database: {$conn->connect_error}");
}


$stmt->bind_param("s", $userinfo->id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $sql = "INSERT INTO admin (admin_email, admin_name, google_id, account_activation_hash) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare SQL statement: " . $mysqli->error . " - SQL: " . $sql);
    }
    $stmt->bind_param("ssss", $userinfo->email, $name, $userinfo->id, $activation_token_hash);
    if (!$stmt->execute()) {
        die("Failed to execute SQL statement: " . $stmt->error);
    }
}

// Set session variables
session_start();
$_SESSION['user_id'] = $user ? $user['id'] : $mysqli->insert_id;
$_SESSION['email'] = $userinfo->email;
$_SESSION['name'] = $name;


// Redirect to a welcome page or dashboard
header("Location: index.php");
exit;
?>