<?php 

if (isset($_POST['login'])) {

    require 'connectDB.php';

    $Usermail = $_POST['email']; 
    $Userpass = $_POST['pwd']; 

    if (empty($Usermail) || empty($Userpass)) {
        header("location: LandingPage.php?error=emptyfields");
        // exit(); // Removed to make the code reachable
    }
    else if (!filter_var($Usermail, FILTER_VALIDATE_EMAIL)) {
        header("location: LandingPage.php?error=invalidEmail");
        exit();
    }
    else {
        $sql = "SELECT * FROM admin WHERE admin_email=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            header("location: LandingPage.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($result, "s", $Usermail);
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);

            if ($row = mysqli_fetch_assoc($resultl)) {
                // Check password using password_verify
                $pwdCheck = password_verify($Userpass, $row['admin_pwd']);

              
             
               

                if ($pwdCheck == false) {
                    header("location: LandingPage.php?error=wrongpassword");
                    exit();
                }
                else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['Admin-name'] = $row['admin_name'];
                    $_SESSION['Admin-email'] = $row['admin_email'];
                    header("location: index.php?login=success");
                    exit();
                }
            }
            else {
                header("location: LandingPage.php?error=nouser");
                exit();
            }
        }
    }
    mysqli_stmt_close($result);    
    mysqli_close($conn);
}
else {
    header("location: LandingPage.php");
    exit();
}
?>
