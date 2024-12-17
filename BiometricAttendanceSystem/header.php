<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="css/header.css"/>
    <style>
        .topnav-right {
            float: right;
        }
    </style>
</head>
<body>
<header>
<?php  
if (isset($_GET['error'])) {
    if ($_GET['error'] == "wrongpasswordup") {
        echo '<script type="text/javascript">
                setTimeout(function () {
                    $(".up_info1").fadeIn(200);
                    $(".up_info1").text("The password is wrong!!");
                    $("#admin-account").modal("show");
                }, 500);
                setTimeout(function () {
                    $(".up_info1").fadeOut(1000);
                }, 3000);
            </script>';
    }
} 
if (isset($_GET['success'])) {
    if ($_GET['success'] == "updated") {
        echo '<script type="text/javascript">
                setTimeout(function () {
                    $(".up_info2").fadeIn(200);
                    $(".up_info2").text("Your Account has been updated");
                }, 500);
                setTimeout(function () {
                    $(".up_info2").fadeOut(1000);
                }, 3000);
            </script>';
    }
}
if (isset($_GET['login'])) {
    if ($_GET['login'] == "success") {
        echo '<script type="text/javascript">
                setTimeout(function () {
                    $(".up_info2").fadeIn(200);
                    $(".up_info2").text("You successfully logged in");
                }, 500);
                setTimeout(function () {
                    $(".up_info2").fadeOut(1000);
                }, 4000);
            </script>';
    }
}
?>
<div class="topnav" id="myTopnav">
    <a>
        <img src="css/logo.png" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%;">
    </a>
    <a><strong>AttenTech</strong></a>
    <a href="index.php">Users</a>
    <a href="ManageUsers.php">Manage Users</a>
    <a href="UsersLog.php">Users Log</a>
    <a href="devices.php">Devices</a>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div class="topnav-right">
        <?php  
            if (isset($_SESSION['Admin-name'])) {
                echo '<a href="#" data-toggle="modal" data-target="#admin-account">'.$_SESSION['Admin-name'].'</a>';
                echo '<a href="LandingPage.php">Log Out</a>';
            }
            else{
                echo '<a href="login.php">Log In</a>';
            }
        ?>
    <a href="javascript:void(0);" class="icon" onclick="navFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>
<div class="up_info1 alert-danger"></div>
<div class="up_info2 alert-success"></div>
</header>
<script>
    function navFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>

<!-- Account Update -->
<div class="modal fade" id="admin-account" tabindex="-1" role="dialog" aria-labelledby="Admin Update" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Update Your Account Info:</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="ac_update.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <label for="User-mail"><b>Admin Name:</b></label>
          <input type="text" name="up_name" placeholder="Enter your Name..." value="<?php echo $_SESSION['Admin-name']; ?>" required/><br>
          <label for="User-mail"><b>Admin E-mail:</b></label>
          <input type="email" name="up_email" placeholder="Enter your E-mail..." value="<?php echo $_SESSION['Admin-email']; ?>" required/><br>
          <label for="User-psw"><b>Current Password:</b></label>
          <input type="password" name="up_pwd" id="up_pwd" placeholder="Enter your Current Password..." required/><br>
          <label for="new-psw"><b>New Password:</b></label>
          <input type="password" name="new_pwd" id="new_pwd" placeholder="Enter your New Password..." required disabled/><br>
          <label for="retype-psw"><b>Confirm New Password:</b></label>
          <input type="password" name="retype_pwd" id="retype_pwd" placeholder="Re-type your New Password..." required disabled/><br>
          <script>
            document.getElementById('up_pwd').addEventListener('input', function() {
                var currentPwd = document.getElementById('up_pwd').value;
                var newPwd = document.getElementById('new_pwd');
                var retypePwd = document.getElementById('retype_pwd');
                if (currentPwd) {
                  newPwd.disabled = false;
                  retypePwd.disabled = false;
                } else {
                  newPwd.disabled = true;
                  retypePwd.disabled = true;
                }
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                var currentPwd = document.getElementById('up_pwd').value;
                var newPwd = document.getElementById('new_pwd').value;
                var retypePwd = document.getElementById('retype_pwd').value;
                if (!currentPwd) {
                  e.preventDefault();
                  alert('Current Password is required to set a new password!');
                } else if (newPwd !== retypePwd) {
                  e.preventDefault();
                  alert('New Password and Re-type New Password do not match!');
                }
            });

            document.querySelector('.modal .close').addEventListener('click', function() {
                document.querySelector('form').reset();
                document.getElementById('new_pwd').disabled = true;
                document.getElementById('retype_pwd').disabled = true;
            });

            $('#admin-account').on('hidden.bs.modal', function () {
                document.querySelector('form').reset();
                document.getElementById('new_pwd').disabled = true;
                document.getElementById('retype_pwd').disabled = true;
            });
          </script>
        </div>
        <div class="modal-footer">
        <button type="submit" name="update" class="btn btn-success">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
    </div>
  </div>
</div>
<br>
<br>
<br>
</div>
</body>
</html>