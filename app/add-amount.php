<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}


?>
<?php
require_once("config.php");

if (isset($_POST["submit"])) {
  $date = $_POST["date"];
  $user_id = $_POST["user_id"];
  $description = $_POST["description"];
  $amount1 = $_POST["amount"];

  // Get the current balance amount for the selected user
  $get_balance_query = "SELECT balance_amt FROM userdetails WHERE id='$user_id'";
  $balance_result = mysqli_query($con, $get_balance_query);
  $balance_row = mysqli_fetch_assoc($balance_result);
  $current_balance = $balance_row["balance_amt"];

  // Calculate the new balance amount
  $new_balance = $current_balance - $amount1;

  // Update the expense table and the balance amount for the selected user
  $sql = "INSERT INTO expense (date, user_id, description, amount) VALUES ('$date', '$user_id', '$description', '$amount1');";
  $sql .= "UPDATE userdetails SET balance_amt = '$new_balance' WHERE id = '$user_id'";

  // Execute the queries
  $res = mysqli_multi_query($con, $sql);

  if ($res) {
    header("Location: " . $siteURL . "add-amount.php?result=success");
  } else {
    echo "<script>alert('Failed')</script>";
  }
}
?>
<?php
require_once("config.php");

if (isset($_POST["submit"])) {

  $date = $_POST["date"];
  $user_id = $_POST["user_id"];
  $description = $_POST["description"];
  $amount1 = $_POST["amount"];
  $get_package = "SELECT * FROM userdetails WHERE id='$user_id'";
  $res1=mysqli_query($con,$get_package);
while($rw=mysqli_fetch_assoc($res1)){
  $pge=$rw["package"];
  $blc=$rw["balance_amt"];
}
  $amt=$blc - $amount1;
  
  $sql = "insert into expense (date,user_id,description,amount) VALUES ('$date','$user_id','$description','".$_POST["amount"]."');";
  $sql .= "UPDATE userdetails SET balance_amt='$amt' where id='$user_id'";
  $res=$con -> multi_query($sql);
  
  if ($res) {
    header("Location: /bracket_v2.0/template/app/add-amount.php?result=success");
  } else {
    echo "<script>alert('Failed')</script>";
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
      <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
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
            <?php
            if ($_GET) {
            if ($_GET['result'] == 'success') {
              // echo "$_GET[result]";die;
              ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your data has been added successfully</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php } } ?>
            <div class="form-layout form-layout-4">
              <div class="row">
                <label class="col-sm-4 form-control-label">Date: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="date" name="date" class="form-control" placeholder="Date" required="">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20 ">
                <label class="col-sm-4 form-control-label">Reimburse By: <span class="tx-danger">*</span></label>
                <div class="input-group col-sm-8 mg-t-10 mg-sm-t-0">
                  <select class="form-control select2 " name="user_id" data-placeholder="Choose one (with optgroup)" required="">

                    <option value="">Select Option</option>
                    <?php require_once('config.php');
                    $sql = "SELECT * FROM userdetails";
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
                  <textarea rows="4" class="form-control" name="description" placeholder="Enter Description" required=""></textarea>
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Amount: <span class="tx-danger">*</span></label>
                <div class="input-group col-sm-8 mg-t-10 mg-sm-t-0">
                  <span class="input-group-addon tx-size-sm lh-2">₹</span>
                  <input type="number" name="amount" class="form-control" aria-label="Amount" required="">
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
