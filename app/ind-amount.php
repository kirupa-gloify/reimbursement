<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
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
      <a class="breadcrumb-item active" href="spending-amount.php">Spending Amount</a>

    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Spending Amount Details</h4>

  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <div class="row">
        <div class="col-sm-6 col-md-9">
          <div class="btn-demo">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Spending Amount Details</h6>
          </div><!-- btn-demo -->
        </div><!-- col-sm-3 -->

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

            </tr>
          </thead>
          <tbody>
            <?php
            require_once("config.php");
            // print_r($_GET); die;
            $user_id = $_GET['id'];
            $i = 0;
            $main = 0;
            $sql = "SELECT * FROM expense where user_id='$user_id' ORDER by date ASC";
            $res = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
              $i = $i + 1;
              $user_name = "SELECT name FROM userdetails WHERE id='" . $_GET['id'] . "'";
              $get_data = mysqli_query($con, $user_name);
              $username = mysqli_fetch_assoc($get_data);

              echo "<tr><td>$i</td><td>$row[date]</td> <td>$username[name]</td><td>$row[description]</td><td>$row[amount]</td>";
              $main = $main + $row['amount'];

              echo "<td>$main</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div><!-- bd -->
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