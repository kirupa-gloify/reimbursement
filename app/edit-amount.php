<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>
<?php
require_once("config.php");
$id=$_GET["id"];
$sql1="SELECT * FROM expense WHERE id='$id'";
$res1=mysqli_query($con,$sql1);
While($row1=mysqli_fetch_assoc($res1)){
$date=$row1["date"];
$user_id=$row1["user_id"];
$description=$row1["description"];
$amount=$row1["amount"];
}
if(isset($_POST["submit"])){
  $date1=$_POST["date"];
  $userid1=$_POST["user_id"];
  $description1=$_POST["description"];
  $amount1=$_POST["amount"];
  $get_package = "SELECT * FROM userdetails WHERE id='$userid1'";
  $res1=mysqli_query($con,$get_package);
while($rw=mysqli_fetch_assoc($res1)){
  $pge=$rw["package"];
  $blc=$rw["balance_amt"];
}
  $amt1=$blc - $amount1;
  $amt=$amt1 + $amount;
  $sql="Update expense SET date='$date1',user_id='$userid1',description='$description1',amount='$amount1' WHERE id='$id';";
  $sql .= "UPDATE userdetails SET balance_amt='$amt' where id='$userid1'";
  $res=$con -> multi_query($sql);
  //$res=mysqli_query($con,$sql);
  if($res){
    header("Refresh:0; url=spending-amount.php");
    }
    else{
    echo"<script>alert('Failed')</script>";
    }
  }
?>
<?php
require_once('header.php')
  ?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="index.html">Gloify</a>
      <a class="breadcrumb-item" href="spending-amount.php">Spending Amount</a>
      <span class="breadcrumb-item active">Add Amount</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add Amount</h4>
  </div>
  <form action="" method="post">
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="row mg-t-0">
          <div class="col-xl-12">
            <div class="form-layout form-layout-4">
              <div class="row">
                <label class="col-sm-4 form-control-label">Date: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="date" name="date" class="form-control" placeholder="Date" value="<?php echo $date ?>" required="">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20 ">
                <label class="col-sm-4 form-control-label">Reimburse By: <span class="tx-danger">*</span></label>
                <div class="input-group col-sm-8 mg-t-10 mg-sm-t-0">
                  <select class="form-control select2 " name="user_id" required="">
                    <?php require_once('config.php');
                    $sql = "SELECT * FROM userdetails WHERE id='$user_id'";
                    $res = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                      echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    $sql = "SELECT * FROM userdetails WHERE id!='$user_id'";
                    $res = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                      echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Description <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea rows="4" class="form-control" name="description" required="" placeholder="Enter Description"><?php echo $description ?></textarea>
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Amount: <span class="tx-danger">*</span></label>
                <div class="input-group col-sm-8 mg-t-10 mg-sm-t-0">
                  <span class="input-group-addon tx-size-sm lh-2">₹</span>
                  <input type="number" name="amount" class="form-control" aria-label="Amount" value="<?php echo $amount ?>" required="">
                </div>
              </div>


              <div class="form-layout-footer mg-t-30">
                <button type="sumbit" name="submit" class="btn btn-info">Submit</button>
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
<script src="../lib/jquery-ui/jquery-ui.js"></script>
<script>

  // Datepicker
  $('.fc-datepicker').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true
  });

  $('#datepickerNoOfMonths').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    numberOfMonths: 2
  });


</script>
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