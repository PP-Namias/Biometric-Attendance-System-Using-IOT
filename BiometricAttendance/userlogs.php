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

// SQL query to retrieve data from fingerprints table
$sql = "SELECT * FROM fingerprints";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>User Logs</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Fingerprint ID</th>
                    <th>Fingerprint Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Loop through each row and display the data
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['department'] . "</td>";
                        echo "<td>" . $row['fingerprintId'] . "</td>";
                        
                        // Convert base64 to image and save it to a file on the server
                        $base64Image = $row['fingerprintImage'];
                        $imageData = base64_decode($base64Image);

                        // Specify the path to save the image (for example: in a folder called 'fingerprints')
                        $imagePath = 'fingerprints/' . $row['fingerprintId'] . '.jpg';

                        // Save the image to the server
                        if (file_put_contents($imagePath, $imageData)) {
                            echo "<td><img src='$imagePath' alt='Fingerprint Image' width='100' height='100'></td>";
                        } else {
                            echo "<td>Error saving image</td>";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
