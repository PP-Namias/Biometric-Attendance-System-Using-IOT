<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/Users.css">
    <script>
      $(window).on("load resize ", function() {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({'padding-right':scrollWidth});
    }).resize();
    </script>
</head>
<body>
<?php include'header.php'; ?> 
<main>
<section>
  <h1 class="slideInDown animated">User List</h1>
  <!--User table-->
  <div class="table-container">
    <div class="table-container" style="width: 75%; margin: 0 auto;">
      <table class="table">
        <thead class="table-primary">
          <tr>
            <th>ID | Name</th>
            <th>Serial Number</th>
            <th>Gender</th>
            <th>Finger ID</th>
            <th>Date</th>
            <th>Device</th>
          </tr>
        </thead>
        <tbody class="table-secondary">
          <?php
            //Connect to database
            require'connectDB.php';

              $sql = "SELECT * FROM users WHERE add_fingerid=0 ORDER BY id DESC";
              $result = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($result, $sql)) {
                  echo '<p class="error">SQL Error</p>';
              }
              else{
                  mysqli_stmt_execute($result);
                  $resultl = mysqli_stmt_get_result($result);
                  if (mysqli_num_rows($resultl) > 0){
                      while ($row = mysqli_fetch_assoc($resultl)){
            ?>
<div class="table-container" style="width: 75%; margin: 0 auto;">
  <table class="table">
    <tbody class="table-secondary">
      <tr>
        <td><?php echo $row['id']; echo" | "; echo $row['username'];?></td>
        <td><?php echo $row['serialnumber'];?></td>
        <td><?php echo $row['gender'];?></td>
        <td><?php echo $row['fingerprint_id'];?></td>
        <td><?php echo $row['user_date'];?></td>
        <td><?php echo $row['device_dep'];?></td>
      </tr>
    </tbody>
  </table>
</div>
                        
          <?php
                      }   
                  }
              }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
</main>
</body>
</html>
