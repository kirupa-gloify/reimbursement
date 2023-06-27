<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location:dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Twitter -->
  <meta name="twitter:site" content="@themepixels">
  <meta name="twitter:creator" content="@themepixels">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Bracket">
  <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
  <meta name="twitter:image" content="http://themepixels.me/bracket/img/bracket-social.png">

  <!-- Facebook -->
  <meta property="og:url" content="http://themepixels.me/bracket">
  <meta property="og:title" content="Bracket">
  <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

  <meta property="og:image" content="http://themepixels.me/bracket/img/bracket-social.png">
  <meta property="og:image:secure_url" content="http://themepixels.me/bracket/img/bracket-social.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="600">

  <!-- Meta -->
  <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
  <meta name="author" content="ThemePixels">

  <title>Gloify</title>

  <!-- vendor css -->
  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="../css/bracket.css">
</head>

<body>
  <div>
    <?php
    require_once("config.php");
    if (isset($_POST["submit"])) {
      
      $email = $_POST["email"];
      $password = $_POST["password"];
      $nametest = "";
      $passtest = "";
      $sql = "SELECT * from register where emailaddress='$email'AND password='$password'";
      $res = mysqli_query($con, $sql);
      if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_array($res)) {
          // $usertest=$row["id"];
          $nametest = $row["username"];
          $passtest = $row["password"];
          $id = $row["id"];
          $status = $row["status"];
          $position=$row["position"];
        }
        if($status == 'APPROVED') {
          session_start();
          $_SESSION["name"] = $nametest;
          $_SESSION["id"] = $id;
          $_SESSION["position"]=$position;
          $_SESSION["loggedin"] = true;
          header("location:dashboard.php");
        }
        else {
          echo "<script>alert('User Details not approved by Manager')</script>";
        }
      }
     else {
        echo "<script>alert('Please enter correct email ID or Password')</script>";
      }
    }
   
    ?>
  </div>
  <form action="" method="post">
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"> Login </div>
        <div class="tx-center mg-b-40"></div>

        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Enter your Email Address">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Enter your password">

        </div><!-- form-group -->
        <button type="submit" name="submit" class="btn btn-info btn-block">Sign In</button>
        
        <div class="mg-t-60 tx-center">Not yet a member? <a href="register.php" class="tx-info">Register Here</a></div>

      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
  </form>
  <script src="../lib/jquery/jquery.js"></script>
  <script src="../lib/popper.js/popper.js"></script>
  <script src="../lib/bootstrap/bootstrap.js"></script>

</body>

</html>