<?php
require_once 'vendor/autoload.php'; 

$client = new Google\Client();

// Set the Google API credentials
$client->setClientId("873466661966-o0fq28gkb65c6letke5lurjccjoqie96.apps.googleusercontent.com"); // Replace with your Google Client ID
$client->setClientSecret("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"); // Replace with your Google Client Secret
$client->setRedirectUri("http://localhost/Biometric-Attendance-System-Using-IOT/BiometricAttendanceSystem/redirect.php"); // Replace with your Redirect URI

$client->addScope("email");
$client->addScope("profile");

$Oath_url = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biometrics Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

    <?php
    // PHP section for header
    echo '
    <header class="fixed top-0 w-full bg-[#010048] shadow-lg z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="text-2xl font-bold text-white">Biometrics</div>
            <nav class="space-x-6">
                <a href="#home" class="text-white hover:text-blue-600 transition">Home</a>
                <a href="#services" class="text-white hover:text-blue-600 transition">Services</a>
                <a href="#contact" class="text-white hover:text-blue-600 transition">Contact</a>
                <a href="login" class="text-white hover:text-blue-600 transition">Login</a>
            </nav> 
        </div>
    </header>';
    ?>

    <section id="home" class="min-h-screen bg-gray-200 text-center bg-cover" style="background-image: url(./icons/bg.jpg);">
        <div class="flex justify-start items-start flex-col">
            <div class="mt-56 ml-12 flex justify-start items-start flex-col">
                <h1 class="text-5xl font-bold text-white ">Biometric Attendance</h1>
                <h1 class="text-5xl font-bold text-white ">Using Fingerprint</h1>
                <p class="text-lg text-white mt-8">Ease in monitoring attendance with our biometrics attendance system using IOT</p>
                <p class="text-lg text-white">You can ensure an honest, reliable and worry less management of attendance system</p>
                <button id="openLoginModal" class="relative overflow-hidden text-white bg-[#305CDE] w-32 h-8 mt-8 ml-28 flex justify-center items-center transition-all duration-300 group">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-green-400 translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-300"></span>
                    <span class="relative z-10 flex items-center gap-1">
                        <span>Login</span>
                        <span class="material-icons">arrow_forward</span>
                    </span>
                </button>
            </div>
        </div>
    </section>


    <section id="services" class="min-h-screen bg-[#081525] flex items-center justify-center flex-col text-center ">
        <h1 class="mb-9 text-5xl font-bold text-white ">Our Services</h1>
        <div class="flex justify-center items-center gap-20">
            <?php
            $services = [
                ['title' => 'Biometric Scanning', 'image' => './icons/fingerprint.png', 'description' => 'Uses an advanced security and authentication technology that leverages unique fingerprint patterns to verify an individual\'s identity. This method provides a secure, efficient, and convenient solution for access control, workforce management, and data protection.'],
                ['title' => 'Attendance Monitoring', 'image' => './icons/clock.png', 'description' => 'Offers a comprehensive system designed to track and manage employee attendance in real-time, ensuring organizational efficiency, compliance, and productivity. Utilizing modern technologies such as biometrics and cloud-based solutions to accurately log work hours.'],
                ['title' => 'Cloud-based Solution', 'image' => './icons/cloud.png', 'description' => 'Uses innovative platforms and services that leverage the power of cloud computing to provide scalable, flexible, and efficient ways for organizations to manage operations, store data, and deploy applications.']
            ];

            foreach ($services as $service) {
                // Add a custom width class for the cloud-based solution
                $customWidthClass = $service['title'] === 'Cloud-based Solution' ? 'w-48' : 'w-36'; // Change width if it's the cloud service
                echo "
        <div class=\"w-[17rem] h-[30rem] bg-[#062135] shadow-1xl rounded-lg hover:scale-105 transform transition duration-300\">
            <div class=\"p-4 flex flex-col justify-center items-center\">
                <div style=\"background-image: url({$service['image']});\" class=\"bg-cover {$customWidthClass} h-36 flex justify-center items-center\"></div>
                <h1 class=\"text-2xl font-bold text-white\">{$service['title']}</h1>
                <p class=\"text-gray-300 mt-4\">{$service['description']}</p>
            </div>
        </div>";
            }
            ?>
        </div>

    </section>

    <section id="contact" class="min-h-screen bg-[#081525] flex items-center justify-center flex-col ">
        <div class="flex justify-between items-center w-[80%]">
            <div class="w-[50%]">
                <h1 class="text-4xl font-bold text-white mb-4">Connect With Us</h1>
                <h3 class="text-2xl text-white">We are technology enthusiast learners of the University of Caloocan City and are here to help you. We would love to hear from you—suggestions, feedback, or concerns. Connect with us on our social media below.</h3>
                <div style="display: flex; gap: 35px; justify-content: start; margin-top: 30px;">
                    <i class="fab fa-facebook" style="font-size: 45px; color: #3b5998; "></i>
                    <i class="fab fa-instagram" style="font-size: 45px; color: #E1306C;"></i>
                    <i class="fab fa-twitter" style="font-size: 45px; color: #1DA1F2;"></i>
                    <i class="fab fa-tiktok" style="font-size: 45px; color: #000000;"></i>
                </div>
            </div>
            <div class="w-[25rem] h-[25rem] bg-cover" style="background-image: url(./icons/connect.png);"></div>
        </div>
    </section>

    <!-- Modal HTML -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50 <?php if (isset($_GET['error'])) echo 'block'; else echo 'hidden'; ?>">
        <div class="w-96 h-96 rounded-lg shadow-lg p-6 relative" style="background: linear-gradient(to right, #010057, #000000);">
            <span id="closeModal" class="absolute top-3 right-3 text-gray-100 cursor-pointer">&times;</span>
            <h2 class="text-2xl font-bold mb-4 text-white">Login</h2>

            <!-- Handle errors and success messages -->
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "invalidEmail") {
                    echo '<div class="alert alert-danger">This E-mail is invalid!!</div>';
                } elseif ($_GET['error'] == "sqlerror") {
                    echo '<div class="alert alert-danger">There is a database error!!</div>';
                } elseif ($_GET['error'] == "wrongpassword") {
                    echo '<div class="alert alert-danger">Wrong password!!</div>';
                } elseif ($_GET['error'] == "nouser") {
                    echo '<div class="alert alert-danger">This E-mail does not exist!!</div>';
                }
            }
            if (isset($_GET['reset']) && $_GET['reset'] == "success") {
                echo '<div class="alert alert-success">Check your E-mail!</div>';
            }
            if (isset($_GET['account']) && $_GET['account'] == "activated") {
                echo '<div class="alert alert-success">Please Login</div>';
            }
            if (isset($_GET['active']) && $_GET['active'] == "success") {
                echo '<div class="alert alert-success">The activation link has been sent!</div>';
            }
            ?>

            <div class="form-container">
                <!-- Reset Password Form -->
                <form class="reset-form hidden" action="reset_pass.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="reset-email" class="block text-gray-200">Email</label>
                        <input type="email" name="email" id="reset-email" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <button type="submit" name="reset_pass" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Reset</button>
                    <p class="message"><a href="#" id="toggle-login">Back to Login</a></p>
                </form>

                <!-- Login Form -->
                <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-200">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-200">Password</label>
                        <input type="password" name="pwd" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <button type="submit" name="login" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Login</button>
                    <button id="googleSignIn" class="relative overflow-hidden text-white bg-[#DB4437] w-48 h-8 mt-4 flex justify-center items-center transition-all duration-300 group">
                        <span class="absolute inset-0 bg-gradient-to-r from-red-500 to-red-700 translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-300"></span>
                        <span class="relative z-10 flex items-center gap-1">
                            <span>Sign in with Google</span>
                            <span class="fab fa-google"></span>
                        </span>
                    </button>
                    <p class="message">Forgot your Password? <a href="#" id="toggle-reset">Reset your password</a></p>
                </form>
            </div>
        </div>
    </div>



    <script>
        // Get the Google Sign-In button
        const googleSignInBtn = document.getElementById('googleSignIn');

        // When the user clicks the button, redirect to Google Sign-In
        googleSignInBtn.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo $Oath_url; ?>"; // Replace with your Google Sign-In URL
        });
    </script>
    <!-- JavaScript to handle modal functionality -->
    <script>
        // Get the modal
        const modal = document.getElementById('loginModal');

        // Get the button that opens the modal
        const loginBtn = document.getElementById('openLoginModal');

        // Get the <span> element that closes the modal
        const closeModal = document.getElementById('closeModal');

        // Toggle between login and reset forms
        const toggleLogin = document.getElementById('toggle-login');
        const toggleReset = document.getElementById('toggle-reset');
        const loginForm = document.querySelector('.login-form');
        const resetForm = document.querySelector('.reset-form');

        toggleLogin.addEventListener('click', function(event) {
            event.preventDefault();
            loginForm.classList.remove('hidden');
            resetForm.classList.add('hidden');
        });

        toggleReset.addEventListener('click', function(event) {
            event.preventDefault();
            loginForm.classList.add('hidden');
            resetForm.classList.remove('hidden');
        });

        // When the user clicks the button, open the modal
        loginBtn.addEventListener('click', function(event) {
            event.preventDefault();
            modal.classList.remove('hidden');
        });

        // Check if there is an error in the URL and open the modal
        if (window.location.search.includes('error')) {
            modal.classList.remove('hidden');
        }

        // When the user clicks on <span> (x), close the modal
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // When the user clicks anywhere outside of the modal, close it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>

    <?php
    // Footer section
    echo '
    <footer class="bg-[#010048] shadow-lg text-white py-2 h-12">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; 2024 Biometrics. IOT Attendance System.</p>
        </div>
    </footer>';
    ?>
</body>

</html>