<?php
session_start();
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "db_abc"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to check if the user exists using prepared statements
$sql = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$sql->bind_param("ss", $email, $password);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $_SESSION['loggedin'] = true;
    echo "success";
} else {
    echo "failure";
}

$sql->close();
$conn->close();
?>
