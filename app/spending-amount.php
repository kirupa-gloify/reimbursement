<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>

<?php
require_once("config.php");

// Check if a date range is selected
if (isset($_POST["search"])) {
  $fromdate = $_POST["fromdate"];
  $todate = $_POST["todate"];
  $where = "date BETWEEN '$fromdate' AND '$todate'";
} else {
  $where = "1"; // Show all data by default
}
?>

<?php require_once('header.php'); ?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
      <span class="breadcrumb-item active">Spending Amount</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Spending Amount Details</h4>
  </div>
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <form action="" method="post">
              <div class="wd-300">
                <div class="d-md-flex mg-b-30">
                  <div class="form-group mg-b-0">
                    <label>From: <span class="tx-danger">*</span></label>
                    <input type="date" name="fromdate" class="form-control wd-250" placeholder="From Date" required>
                  </div><!-- form-group -->
                  <div class="form-group mg-b-0 mg-md-l-20 mg-t-20 mg-md-t-0">
                    <label>To: <span class="tx-danger">*</span></label>
                    <input type="date" name="todate" class="form-control wd-250" placeholder="To Date" required>
                  </div><!-- form-group -->
                  <div class="mg-l-10 mg-t-25 pd-t-4">
                    <button type="submit" name="search"
                      class="btn btn-info tx-11 pd-y-12 tx-uppercase tx-spacing-2">Search</button>
                  </div>
                </div><!-- d-flex -->
              </div>
            </form>
</div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <div class="row mg-t-0">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-sm-6 col-md-9">
              <div class="btn-demo">
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Spending Amount Details</h6>
              </div><!-- btn-demo -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6 col-md-3 mg-t-20 mg-sm-t-0">
              <div class="btn-demo">
                <a href="add-amount.php" class="btn btn-primary btn-block mg-b-10"><i class="fa fa-plus mg-r-10"></i>Add
                  Amount</a>
              </div><!-- btn-demo -->
            </div><!-- col-sm-3 -->


          </div><!-- row -->


          <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>Reimburse By</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Main Amount</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
             
              <?php
                require_once("config.php");
                $i = 0;
                $main = 0;
                $sql = "SELECT * FROM expense WHERE $where ORDER BY date ASC";
                $res = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                  $amt=$row['amount'];
                  $i = $i + 1;
                  if ($row['user_id']) {
                    $id = $row["id"];
                    $date = $row["date"];
                    $d = date('d/m/Y', strtotime($date));
                    $user_id = $row["user_id"];
                    //fetching user name from users table
                    $user_name = "SELECT name FROM userdetails WHERE id='" . $user_id . "'";
                    $get_data = mysqli_query($con, $user_name);
                    $username = mysqli_fetch_assoc($get_data);
                    if ($username) {
                      echo "<tr><td>$i</td><td>$d</td><td><a href='ind-amount.php?id=$row[user_id]'>$username[name]</a></td><td>$row[description]</td><td>" . number_format($amt) . "</td>";
                      $main = $main + $row['amount'];
                      $amt1 = $main;
                      echo "<td>" . number_format($amt1) . "</td><td><a href='edit-amount.php?id=$id' style='font-size: 150%;'><i class='icon ion-compose'></i></a>&nbsp;&nbsp;
                     <a href='delete-amount.php?id=$id&amt=$row[amount]&userid=$row[user_id]' style='font-size: 150%;'><i class='icon ion-trash-a'></i></a></td></tr>";
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div><!-- bd -->
        </div><!-- col-12 -->
      </div><!-- row -->
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
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