<?php
if (isset($_GET['name']) && isset($_GET['gender']) && isset($_GET['department']) && isset($_GET['fingerprintId'])) {
    $ip = "192.168.1.15"; // Replace with your ESP32 IP address
    $port = 80;           // Port used by the ESP32 web server

    // Get values from the input fields
    $name = $_GET['name'];
    $gender = $_GET['gender'];
    $department = $_GET['department'];
    $fingerprintId = $_GET['fingerprintId'];

    $socket = fsockopen($ip, $port, $errno, $errstr, 10);

    if ($socket) {
        // Send all values as a single message, formatted as JSON
        $data = json_encode([
            "name" => $name,
            "gender" => $gender,
            "department" => $department,
            "fingerprintId" => $fingerprintId
        ]);

        fwrite($socket, $data . "\n");
        fclose($socket);
        echo "Data sent to ESP32: $data";
    } else {
        echo "Failed to connect to ESP32: $errstr ($errno)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control ESP32</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-sm w-full">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">ESP32 Control Panel</h1>
        
        <form id="controlForm">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name:</label>
                <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your name">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Gender:</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center text-gray-700">
                        <input type="radio" name="gender" value="Male" checked class="form-radio text-blue-500">
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700">
                        <input type="radio" name="gender" value="Female" class="form-radio text-blue-500">
                        <span class="ml-2">Female</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="department" class="block text-gray-700 font-medium mb-2">Department:</label>
                <select id="department" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="fingerprintId" class="block text-gray-700 font-medium mb-2">Fingerprint ID:</label>
                <input type="number" id="fingerprintId" min="1" max="100" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="1-100">
            </div>

            <button type="button" onclick="sendData()" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
        </form>
    </div>

    <script>
        function sendData() {
            const name = document.getElementById('name').value;
            const gender = document.querySelector('input[name="gender"]:checked').value;
            const department = document.getElementById('department').value;
            const fingerprintId = document.getElementById('fingerprintId').value;

            if (!name || !fingerprintId) {
                alert("Please fill in all fields. Make sure the fingerprint ID is between 1 and 100.");
                return;
            }

            // Construct the query string for the GET request
            const query = `?name=${encodeURIComponent(name)}&gender=${encodeURIComponent(gender)}&department=${encodeURIComponent(department)}&fingerprintId=${encodeURIComponent(fingerprintId)}`;

            fetch(query)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
