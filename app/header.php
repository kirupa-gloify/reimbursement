<?php 
require_once'config.php';
$position='';
$position=$_SESSION["position"];

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
  <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="../lib/chartist/chartist.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="../css/bracket.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script> -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</head>

<body>

  <!-- ########## START: LEFT PANEL ########## -->
  <div class="br-logo"><a href=""><img src="<?php echo $imgURL; ?>gloify.png" width="100"
        height="50"></a></div>
  <div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
      <a href="dashboard.php" id="menu-dashboard" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
          <span class="menu-item-label">Dashboard</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <?php if($position=='ADMIN'){ ?>
      <a href="manage-user.php" id="menu-users" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-person-stalker tx-24"></i>
          <span class="menu-item-label">Manage User</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <?php } ?>
      <a href="users.php" id="menu-users" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon ion-person-stalker tx-24"></i>
          <span class="menu-item-label">Users</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <a href="spending-amount.php" id="menu-spending" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon fa fa-credit-card tx-24"></i>
          <span class="menu-item-label">Spending Amount</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <a href="monthly-report.php" id="menu-report" class="br-menu-link">
        <div class="br-menu-item">
          <i class="menu-item-icon icon fa fa-calendar tx-24"></i>
          <span class="menu-item-label">Monthly Report</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
    </div><!-- br-sideleft-menu -->
  </div><!-- br-sideleft -->
  <!-- ########## END: LEFT PANEL ########## -->

  <!-- ########## START: HEAD PANEL ########## -->
  <div class="br-header">
    <div class="br-header-left">
      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a>
      </div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i
            class="icon ion-navicon-round"></i></a></div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
      <nav class="nav">

        <div class="dropdown">
          <?php
          require_once "config.php";

          $name = $_SESSION["name"];

          //$sql = "SELECT * FROM login WHERE id='$id'";
          //$res = mysqli_query($con, $sql);
          //while($row=mysqli_fetch_assoc($res))
          //{
          // $name = $row['name'];
          // }
          
          ?>
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name hidden-md-down ">
              <?php echo $name ?>
            </span>
            <img src="<?php echo $imgURL; ?>gloify-favicon.png" class="wd-32 rounded-circle" alt="">
            <span class="square-10 bg-success"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-header wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a href="edit-profile.php"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
              <li><a href="logout.php"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </nav>
    </div><!-- br-header-right -->
  </div><!-- br-header -->
  <!-- ########## END: HEAD PANEL ########## -->
  <script>
    $(function () {
      'use strict'

      // FOR DEMO ONLY
      // menu collapsed by default during first page load or refresh with screen
      // having a size between 992px and 1299px. This is intended on this page only
      // for better viewing of widgets demo.
      $(window).resize(function () {
        minimizeMenu();
      });

      minimizeMenu();

      function minimizeMenu() {
        if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
          // show only the icons and hide left menu label by default
          $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
          $('body').addClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideUp();
        } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
          $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
          $('body').removeClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideDown();
        }
      }
    });
  </script>
  <script>
  $(function() {
    // Get the current URL path
    var path = window.location.pathname;
    // Extract the filename from the path
    var page = path.split("/").pop();

    // Add the 'active' class to the corresponding menu link
    $('.br-menu-link').each(function() {
      var link = $(this).attr('href');
      if (link === page) {
        $(this).addClass('active');
        return false; // Exit the loop once the active link is found
      }
    });
  });
</script>
</body>

</html>