<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>
<?php
require_once("config.php");
$id = $_GET["id"];

$sql1 = "SELECT * FROM userdetails WHERE id='$id'";
$res1 = mysqli_query($con, $sql1);
while ($row1 = mysqli_fetch_assoc($res1)) {
  $names = $row1["name"];
  $phonenumber = $row1["phonenumber"];
  $package2 = $row1["package"];
  $blc = $row1["balance_amt"];
  $date1 = $row1["date"];
}
if (isset($_POST["submit"])) {
  $name1 = $_POST["name"];
  $date2 = $_POST["date"];
  $mobile = $_POST["mobilenum"];
  $package1 = $_POST["package"];
  $amount = $_POST["addpackage"];
 
  $totalPackage = $package1 + $amount;
  $balance = $blc + $amount;


  $sql = "UPDATE userdetails SET package='$totalPackage',balance_amt='$balance',date='$date2' WHERE id='$id';";
  $sql .= "INSERT into monthly_report (user_id,addamount,date)VALUES('$id','$amount','$date2')";
  
  $res = $con->multi_query($sql);
  if ($res) {
    header("Refresh:0; url=users.php");
  } else {
    echo "<script>alert('Failed')</script>";
  }
}
?>

<?php
require_once('header.php');
?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
      <a class="breadcrumb-item" href="users.php">Users</a>
      <span class="breadcrumb-item active">Update User</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update User</h4>
  </div>
  <?php //echo '<pre>'; print_r($name); die;
  ?>
  <form action="" method="post">
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="row mg-t-0">
          <div class="col-xl-12">
            <div class="form-layout form-layout-4">
              <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Update User</h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" class="form-control" name="name" placeholder="Enter Name"
                    value="<?php echo $names; ?>" required="">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Phone Number: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="tel" class="form-control" name="mobilenum" placeholder="Enter Phone Number"
                    value="<?php echo $phonenumber; ?>" required="">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Date: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="date" class="form-control" name="date" value="<?php echo $date1; ?>" required="">
                </div>
              </div>

              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Add Amount: <span class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="number" class="form-control" name="addpackage" placeholder="Add Amount"
                    value="<?php echo $totalpackage; ?>">
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label"><b>Provided Amount: </b><span
                    class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" class="form-control" name="package" placeholder="Enter Your Provided Amount"
                    value="<?php echo $package2; ?>" readonly>
                </div>
              </div>


              <div class="form-layout-footer mg-t-30">
                <button type="submit" name="submit" class="btn btn-info">Update</button>
              </div><!-- form-layout-footer -->
            </div><!-- form-layout -->
          </div><!-- col-12 -->
        </div><!-- row -->
      </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->



  </form>

  <footer class="br-footer">
    <div class="footer-left">
      <div class="mg-b-2">Copyright &copy; 2023. Gloify. All Rights Reserved.</div>
    </div>
    <div class="footer-right d-flex align-items-center">
      <span class="tx-uppercase mg-r-10">Share:</span>
      <a target="_blank" class="pd-x-5" href=""><i class="fa fa-facebook tx-20"></i></a>
      <a target="_blank" class="pd-x-5" href=""><i class="fa fa-twitter tx-20"></i></a>
    </div>
  </footer>
</div><!-- br-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
<script src="../lib/jquery/jquery.js"></script>
<script src="../lib/popper.js/popper.js"></script>
<script src="../lib/bootstrap/bootstrap.js"></script>
<script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="../lib/moment/moment.js"></script>
<script src="../lib/jquery-ui/jquery-ui.js"></script>
<script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>
<script src="../lib/peity/jquery.peity.js"></script>
<script src="../lib/chartist/chartist.js"></script>
<script src="../lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
<script src="../lib/d3/d3.js"></script>
<script src="../lib/rickshaw/rickshaw.min.js"></script>


<script src="../js/bracket.js"></script>
<script src="../js/ResizeSensor.js"></script>
<script src="../js/dashboard.js"></script>
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