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
                <button class="relative overflow-hidden text-white bg-[#305CDE] w-32 h-8 mt-8 ml-28 flex justify-center items-center transition-all duration-300 group">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-green-400 translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-300"></span>
                    <a href="Login.php" class="relative z-10 flex items-center gap-1">
                      <span>Login</span>
                    <span class="material-icons">arrow_forward</span>
                    </a>
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