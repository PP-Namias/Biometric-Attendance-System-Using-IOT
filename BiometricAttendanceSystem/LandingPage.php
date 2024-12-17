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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-purple': '#8B5CF6',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(135deg, #3B82F6, #8B5CF6);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 to-black text-white min-h-screen flex flex-col">
    <?php
    require_once 'vendor/autoload.php'; 

    $client = new Google\Client();

    // Set the Google API credentials
    $client->setClientId("873466661966-o0fq28gkb65c6letke5lurjccjoqie96.apps.googleusercontent.com");
    $client->setClientSecret("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");
    $client->setRedirectUri("http://localhost/Biometric-Attendance-System-Using-IOT/BiometricAttendanceSystem/redirect.php");

    $client->addScope("email");
    $client->addScope("profile");

    $Oath_url = $client->createAuthUrl();
    ?>

    <header class="fixed top-0 left-0 right-0 z-50 border-b border-gray-800 bg-gray-900/80 backdrop-blur-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center space-x-2">
            <img src="css/logo.png" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%;">
                <span class="text-xl font-bold text-gradient">AttenTech</span>
            </a>
            <nav class="hidden md:flex space-x-6">
                <a href="#home" class="text-gray-300 hover:text-white transition-colors duration-300">Home</a>
                <a href="#services" class="text-gray-300 hover:text-white transition-colors duration-300">Services</a>
                <a href="#contact" class="text-gray-300 hover:text-white transition-colors duration-300">Contact</a>
                <button id="openLoginModal" class="bg-gradient text-white rounded-full px-4 py-2 transition-all duration-300 ease-in-out transform hover:scale-105">Login</button>
            </nav>
            <button id="mobileMenuBtn" class="md:hidden text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <div id="mobileMenu" class="fixed inset-0 bg-gray-900 z-50 hidden">
        <div class="flex flex-col items-center justify-center h-full">
            <a href="#home" class="text-white text-xl py-2">Home</a>
            <a href="#services" class="text-white text-xl py-2">Services</a>
            <a href="#contact" class="text-white text-xl py-2">Contact</a>
            <button id="openLoginModalMobile" class="bg-gradient text-white rounded-full px-6 py-2 mt-4">Login</button>
            <button id="closeMobileMenu" class="absolute top-4 right-4 text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>


    <main class="flex-grow container mx-auto px-4 pt-32 pb-16">
        <section id="home" class="py-20">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-24">
                <div class="flex-1 space-y-8">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tighter text-gradient">
                        Biometric Attendance
                    </h1>
                    <p class="text-xl text-gray-300 max-w-2xl">
                        Experience seamless attendance tracking with our cutting-edge biometric system. 
                        Ensure accuracy, security, and efficiency in managing your workforce.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button class="bg-gradient text-white rounded-full px-8 py-4 text-lg transition-all duration-300 ease-in-out transform hover:scale-105">
                            Get Started
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        <button class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full px-8 py-4 text-lg transition-all duration-300 ease-in-out">
                            Learn More
                        </button>
                    </div>
                </div>
                <div class="flex-1 relative">
                    <div class="absolute inset-0 bg-gradient rounded-full blur-3xl opacity-20"></div>
                    <div class="relative z-10">
                        <i class="fas fa-fingerprint text-blue-500 text-9xl"></i>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="py-24">
            <h2 class="text-4xl font-bold mb-12 text-center text-gradient">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $services = [
                    ['title' => 'Biometric Scanning', 'icon' => 'fa-fingerprint', 'description' => 'Advanced security and authentication technology leveraging unique fingerprint patterns.'],
                    ['title' => 'Attendance Monitoring', 'icon' => 'fa-clock', 'description' => 'Real-time tracking and management of employee attendance for organizational efficiency.'],
                    ['title' => 'Cloud-based Solution', 'icon' => 'fa-cloud', 'description' => 'Scalable and flexible cloud computing services for efficient data management.']
                ];

                foreach ($services as $service) {
                    echo "
                    <div class='bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-lg hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105'>
                        <i class='fas {$service['icon']} text-4xl mb-4 text-blue-500'></i>
                        <h3 class='text-xl font-semibold mb-2'>{$service['title']}</h3>
                        <p class='text-gray-400'>{$service['description']}</p>
                    </div>";
                }
                ?>
            </div>
        </section>

        <section id="contact" class="py-24">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-bold mb-6 text-gradient">Connect With Us</h2>
                    <p class="text-gray-300 mb-8">
                        We are technology enthusiasts from the University of Caloocan City, ready to assist you. 
                        We value your feedback, suggestions, and concerns. Reach out to us through our social media channels.
                    </p>
                    <div class="flex gap-6">
                        <a href="#" class="text-3xl text-blue-500 hover:text-blue-400 transition-colors duration-300"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-3xl text-pink-500 hover:text-pink-400 transition-colors duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-3xl text-blue-400 hover:text-blue-300 transition-colors duration-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-3xl text-gray-400 hover:text-gray-300 transition-colors duration-300"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient rounded-lg blur-xl opacity-20"></div>
                        <img src="./icons/connect.png" alt="Connect with us" class="relative z-10 w-full h-auto rounded-lg shadow-2xl">
                    </div>
                </div>
            </div>
        </section>
    </main>

        <!-- Modal HTML -->
        <div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="w-96 h-126 rounded-lg shadow-lg p-6 relative" style="background: linear-gradient(to right, #010057, #000000);">
            <span id="closeModal" class="absolute top-3 right-3 text-gray-100 cursor-pointer">&times;</span>
            <div class="flex flex-col items-center">
                <img src="css/logo.png" alt="Logo" style="width: 100px; height: 100px; border-radius: 50%;">
                <h1 style="font-size: 35px; font-weight: bold; margin-bottom: 16px; color: white;">
                    Atten<span style="color: #8B5CF6; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">Tech</span>
                </h1>
                <h5 class="text-0.5x0.75 mb-4 text-white"> Login your account </h5>
            </div>

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
                    <button type="submit" name="reset_pass" class="w-full bg-violet-500 text-white py-2 rounded-md hover:bg-violet-600">Reset</button>
                    <br>
                    <br>
                    <p class="message text-center"><a href="#" id="toggle-login">LogIn</a></p>

                </form>

                <!-- Login Form -->
                <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md text-black" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-6">
                        <input type="password" name="pwd" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md text-black" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="w-full bg-violet-500 text-white py-2 rounded-md hover:bg-violet-600">Login</button>
                    <br>
                    <br>
                   <a href="#" id="toggle-reset" class="text-white text-center block">Forgot your password?</a>
                    <br>
                    <p class="text-white text-xs text-center">or continue with</p>
                    <br>
                    <button type="button" class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600 flex items-center justify-center">
                        <i class="fab fa-google mr-2"></i> Sign in with Google
                    </button>
                <style>
                    a:hover {
                        color: #1E40AF; /* Tailwind's blue-800 color */
                    }
                </style>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal HTML for Reset Password -->
    <div id="resetPasswordModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="w-96 h-96 rounded-lg shadow-lg p-6 relative" style="background: linear-gradient(to right, #010057, #000000);">
            <span id="closeResetModal" class="absolute top-3 right-3 text-gray-100 cursor-pointer">&times;</span>
            <h2 class="text-2xl font-bold mb-4 text-white">Reset Password</h2>
            <form action="reset_password.php" method="post">
                <div class="mb-4">
                    <label for="reset-email" class="block text-gray-200">Email</label>
                    <input type="email" name="email" id="reset-email" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <button type="submit" name="reset_password" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Reset Password</button>
            </form>
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

    <footer class="bg-gray-900 py-6">
        <div class="container mx-auto text-center">
            <p class="text-sm text-gray-500">&copy; 2024 Biometrics. IOT Attendance System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
        });

        closeMobileMenu.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });

        // Login modal functionality
        const loginModal = document.getElementById('loginModal');
        const openLoginModal = document.getElementById('openLoginModal');
        const openLoginModalMobile = document.getElementById('openLoginModalMobile');
        const closeModal = document.getElementById('closeModal');
        const loginForm = document.querySelector('.login-form');
        const resetForm = document.querySelector('.reset-form');
        const toggleResetPassword = document.getElementById('toggle-reset');
        const backToLogin = document.getElementById('toggle-login');
        const modalTitle = document.querySelector('.modal-title');

        function showLoginModal() {
            loginModal.classList.remove('hidden');
            loginForm.classList.remove('hidden');
            resetForm.classList.add('hidden');
            modalTitle.textContent = 'Login';
        }

        function hideLoginModal() {
            loginModal.classList.add('hidden');
        }

        openLoginModal.addEventListener('click', showLoginModal);
        openLoginModalMobile.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            showLoginModal();
        });
        closeModal.addEventListener('click', hideLoginModal);

        toggleResetPassword.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.classList.add('hidden');
            resetForm.classList.remove('hidden');
            modalTitle.textContent = 'Reset Password';
        });

        backToLogin.addEventListener('click', (e) => {
            e.preventDefault();
            resetForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            modalTitle.textContent = 'Login';
        });

        // Close modal when clicking outside
        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                hideLoginModal();
            }
        });

        // Google Sign-In functionality
        const googleSignInBtn = document.getElementById('googleSignIn');

        googleSignInBtn.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = "<?php echo $Oath_url; ?>";
        });

        // Handle errors and success messages
        <?php
        if (isset($_GET['error'])) {
            echo "alert('";
            if ($_GET['error'] == "invalidEmail") {
                echo "This E-mail is invalid!!";
            } elseif ($_GET['error'] == "sqlerror") {
                echo "There is a database error!!";
            } elseif ($_GET['error'] == "wrongpassword") {
                echo "Wrong password!!";
            } elseif ($_GET['error'] == "nouser") {
                echo "This E-mail does not exist!!";
            }
            echo "');";
        }
        if (isset($_GET['reset']) && $_GET['reset'] == "success") {
            echo "alert('Check your E-mail!');";
        }
        if (isset($_GET['account']) && $_GET['account'] == "activated") {
            echo "alert('Please Login');";
        }
        if (isset($_GET['active']) && $_GET['active'] == "success") {
            echo "alert('The activation link has been sent!');";
        }
        ?>
    </script>
</body>
</html>
