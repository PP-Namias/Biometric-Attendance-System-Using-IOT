<?php
$token = $_GET['token'] ?? null; // Ensure $token is set

if (!$token) {
    die("Invalid token.");
}

$token_hash = hash("sha256", $token);

$conn = require __DIR__ . "/connectDB.php";

$sql = "SELECT * FROM admin WHERE reset_token_hash = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Invalid token.");
}

if (strtotime($user['reset_token_expires_at']) < time()) {
    die("Token has expired.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
      $(window).on("load resize", function() {
          var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
          $('.tbl-header').css({'padding-right': scrollWidth});
      }).resize();
    </script>
</head>
<body>
<?php include 'header.php'; ?> 
<main>
  <h1 class="slideInDown animated">Please, Insert your new Password</h1>
  <section class="pic_date_sel">
    <div class="slideInDown animated">
      <div class="login-page">
        <div class="form">
          <div class="alert1"></div>
          <form class="login-form" action="process-resert-password.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="pwd" placeholder="Enter a new Password..." required />
            <input type="password" name="pwd_re" placeholder="Repeat new Password..." required />
            <button type="submit" name="reset">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>
</body>
</html>
