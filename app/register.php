
<?php
require_once("config.php");
if(isset($_POST["submit"])){
  $name=$_POST["name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $sql="insert into register (username,emailaddress,password,status,position) VALUES ('$name','$email','$password','PENDING','STAFF')";
  $res=mysqli_query($con,$sql);
  if($res){
    header("location:login.php");
    }
    else{
    echo"<script>alert('Failed')</script>";
    }
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
    <link href="../lib/select2/css/select2.min.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>
    <form action="" method="post">
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse">Registration Form</div>
        <div class="tx-center mg-b-40"></div>

        <div class="form-group">
          <input type="text" class="form-control" name="name" id='name'  onInput="check()" placeholder="Enter your username" required="">
          <span id="check-username"></span>
        </div><!-- form-group -->
        <div class="form-group">
          <input type="email" class="form-control" name="email" id='email'  onInput="check1()" placeholder="Enter your Email Address" required="">
          <span id="check-email"></span>
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Enter your password" required="">
        </div><!-- form-group -->
        <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
        <button type="submit" name="submit" id="submit" class="btn btn-info btn-block">Sign Up</button>

        <div class="mg-t-40 tx-center">Already a member? <a href="login.php" class="tx-info">Login Here</a></div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
</form>
    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/select2/js/select2.min.js"></script>
    <script>
      $(function(){
        'use strict';

        $('.select2').select2({
          minimumResultsForSearch: Infinity
        });
      });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function check() {
  var name = $("#name").val();
    jQuery.ajax({
    url: "check.php",
    data:'username='+name,
    type: "POST",
    success:function(data){
        $("#check-username").html(data);
    },
    error:function (){}
    });
}
function check1() {
  var email = $("#email").val();
    jQuery.ajax({
    url: "check.php",
    data:'email='+email,
    type: "POST",
    success:function(data){
        $("#check-email").html(data);
    },
    error:function (){}
    });
}
</script>

  </body>
</html>
