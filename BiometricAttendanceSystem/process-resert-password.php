<?php

$token = $_POST['token'] ?? null;
$password = $_POST['password'] ?? null;
$confirm_password = $_POST['confirm_password'] ?? null;

if (!$token) {
    die("Invalid token");
}

$token_hash = hash("sha256", $token);

$conn = require __DIR__ . "/connectDB.php";

$sql = "SELECT * FROM admin WHERE reset_token_hash = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database error: {$conn->error}");
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Invalid token");
}

if (strtotime($user['reset_token_expires_at']) < time()) {
    die("Token has expired");
}


if ($password !== $confirm_password) {
    die("Passwords do not match");
}

// Additional password validation
if (strlen($password) > 8) {
    die("Password must be at least 8 characters long");
}

if (!preg_match('/[A-Z]/', $password)) {
    die("Password must contain at least one uppercase letter");
}

if (!preg_match('/[a-z]/', $password)) {
    die("Password must contain at least one lowercase letter");
}
if (!preg_match('/[0-9]/', $password)) {
    die("Password must contain at least one number");
}

if (!preg_match('/[\W]/', $password)) {
    die("Password must contain at least one special character");
}

    // Proceed with password update
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE admin SET password_hash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
     die("Database error: " . $conn->error);
}

$stmt->bind_param("si", $password_hash, $user['id']);
    $stmt->execute();
    echo "Password has been reset successfully";

