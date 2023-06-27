<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>
<?php
require_once("config.php");
if (isset($_POST["search"])) {
  $fromdate = $_POST["fromdate"];
  $todate = $_POST["todate"];
  $where = "date BETWEEN '$fromdate' AND '$todate'";
} else {
  $where = "MONTH(date) = MONTH(now()) and YEAR(date) = YEAR(now())";
}
?>
<?php
require_once('header.php')
  ?>
<style>
  .bg-teal {
    background-color: #dc3545;
  }
  .bg-danger {
    background-color: #cf303f80 !important;
  }
  .bg-success {
    background-color: #23bf0873 !important;
  }
  .tx-10 {
    font-size: 11px !important;
}
</style>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
  <div class="pd-30">
    <h4 class="tx-gray-800 mg-b-5">Dashboard</h4>
  </div><!-- d-flex -->

  <div class="br-pagebody mg-t-5 pd-x-30">
    <div class="row row-sm">
      <div class="col-sm-6 col-xl-3">
        <div class="bg-teal rounded overflow-hidden" style="margin-top: 7px; background-color: #23bf0873 !important; border-radius: 8px !important;">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-credit-card tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">Total Provided Budget</p>
              <?php
              // Fetch total amount details
              $query = 'SELECT SUM(addamount) AS total_amount FROM monthly_report';
              $result = mysqli_query($con, $query);

              // Check if query executed successfully
              if ($result) {
                $row = mysqli_fetch_assoc($result);
                $providedAmount = $row['total_amount'];
              }

              // Display zero if no spending records for the current month
              if ($providedAmount == '') {
              
                $providedAmount = 0;
            }              
              ?>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2" style="font-weight: 700;">
                <?php
                if($providedAmount>=1000) {

                  $x = round($providedAmount);
                  $x_number_format = number_format($x);
                  $x_array = explode(',', $x_number_format);
                  $x_parts = array('k','L', 'm', 'b', 't');
                  $x_count_parts = count($x_array) - 1;
                  $providedAmount = $x;
                  $providedAmount = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                  $providedAmount .= $x_parts[$x_count_parts - 1];
          
            
          
            }
                echo $providedAmount; ?>
              </p>
            </div>
          </div>
        </div>
      </div><!-- col-3 -->

      
      <!-- <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-7"> -->
        <?php
        // Fetch total amount details
        //$query = 'SELECT SUM(amount) AS total_amount FROM expense WHERE MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())';
        //$result = mysqli_query($con, $query);

        // Check if query executed successfully
        //if ($result) {
        //   $row = mysqli_fetch_assoc($result);
        //   $curAmount = $row['total_amount'];
        // } else {
        //   echo 'Error executing query: ' . mysqli_error($con);
        // }

        // Display zero if no spending records for the current month
        // if ($curAmount === null) {
        //   $curAmount = 0;
        // }
        // Compare the spending amount with the provided amount
        // if ($curAmount > $providedAmount) {
        //   $cardClass = 'bg-danger'; // Apply different card color if spending exceeds provided amount
        // } else {
        //   $cardClass = 'bg-success'; // Use default card color if spending does not exceed provided amount
        // }
        ?>
        <!-- <div class=" rounded overflow-hidden">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Current Month Spending
                Amount</p>

              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2"> -->
                <?php 
            //     if($curAmount>=1000) {

            //       $x = round($curAmount);
            //       $x_number_format = number_format($x);
            //       $x_array = explode(',', $x_number_format);
            //       $x_parts = array('k','L', 'm', 'b', 't');
            //       $x_count_parts = count($x_array) - 1;
            //       $curAmount = $x;
            //       $curAmount = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            //       $curAmount .= $x_parts[$x_count_parts - 1];
          
            
          
            // }
            //     echo $curAmount ?>
              <!-- </p>
            </div>
          </div>
        </div>
      </div>col-3 -->


      <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-7">
        <?php
        // Fetch total amount details
        $query = 'SELECT SUM(amount) AS total_amount FROM expense';
        $result = mysqli_query($con, $query);

        // Check if query executed successfully
        if ($result) {
          $row = mysqli_fetch_assoc($result);
          $totalAmount = $row['total_amount'];
        } else {
          echo 'Error executing query: ' . mysqli_error($con);
        }

        // Display zero if no spending records found
        if ($totalAmount === null) {
          $totalAmount = 0;
        }

        // Compare the spending amount with the provided amount
        if ($totalAmount > $providedAmount) {
          $cardClass = 'bg-danger'; // Apply different card color if spending exceeds provided amount
        } else {
          $cardClass = 'bg-success'; // Use default card color if spending does not exceed provided amount
        }
        ?>
        <div class="<?= $cardClass ?> rounded overflow-hidden" style="border-radius: 8px !important;">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">Total Spending Amount</p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2" style="font-weight: 700;">
                <?php 
                if($totalAmount>=1000) {

                  $x = round($totalAmount);
                  $x_number_format = number_format($x);
                  $x_array = explode(',', $x_number_format);
                  $x_parts = array('k','L', 'm', 'b', 't');
                  $x_count_parts = count($x_array) - 1;
                  $totalAmount = $x;
                  $totalAmount = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                  $totalAmount .= $x_parts[$x_count_parts - 1];
            }
                echo $totalAmount ?>
              </p>
            </div>
          </div>
        </div>
      </div> <!-- col-3 -->
      <?php
      require_once('config.php');
      $query1 = "SELECT * FROM userdetails";
      $res = mysqli_query($con, $query1);

      while ($rw = mysqli_fetch_assoc($res)) {
        $user_id = $rw["id"];

        $sq = "SELECT * FROM userdetails WHERE id='$user_id'";
        $re = mysqli_query($con, $sq);

        if ($re) {
          $rw1 = mysqli_fetch_assoc($re);
          $amt = $rw1["balance_amt"];
        } else {
          // Handle the query execution error
          echo "Error executing the balance query: " . mysqli_error($con);
        }

        // Compare the spending amount with the provided amount
        if ($amt < 0) {
          $cardClass = 'bg-danger'; // Apply different card color if balance amount is negative
        }
        else {
          $cardClass = 'bg-success'; // Use default card color if spending does not exceed provided amount
        }
        ?>
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0" style="margin-top: 5px;">
          <div class="<?= $cardClass ?> rounded overflow-hidden" style="border-radius: 8px !important";>
            <div class="pd-25 d-flex align-items-center">
              <i class="icon ion-person tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;"> Balance Amount</p>
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                  <?php echo $rw['name'] ?>
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?php 
                  if($amt>=1000) {

                    $x = round($amt);
                    $x_number_format = number_format($x);
                    $x_array = explode(',', $x_number_format);
                    $x_parts = array('k','L', 'm', 'b', 't');
                    $x_count_parts = count($x_array) - 1;
                    $amt = $x;
                    $amt = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                    $amt .= $x_parts[$x_count_parts - 1];
            
              }
              elseif($amt<0){
                $x = round($amt);
                $x_number_format = number_format($x);
                $x_array = explode(',', $x_number_format);
                $x_parts = array('k','L', 'm', 'b', 't');
                $x_count_parts = count($x_array) - 1;
                $amt = $x;
                $amt = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                $amt .= $x_parts[$x_count_parts - 1];
              }
              echo $amt ?>
                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
      <?php }
      ?>
    </div>
    <div class="row row-sm mg-t-20">
      <div class="col-12">
        <div class="card pd-0 bd-0 shadow-base">
          <div class="pd-x-30 pd-t-30 pd-b-15">
            <div class="d-flex align-items-center ">
              <div>
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 ">Monthly Activities</h6>
              </div>
            </div><!-- d-flex -->
          </div>
          <div class="pd-x-30 pd-t-30 pd-b-15">
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
                  $i = 0;
                  $main = 0;
                  $sql = "SELECT * FROM expense WHERE $where ORDER by date ASC";
                  $res = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_assoc($res)) {
                    $amt=$row['amount'];
                    if ($row['user_id']) {
                      $i = $i + 1;
                      $user_name = "SELECT name FROM userdetails WHERE id='" . $row['user_id'] . "'";
                      $get_data = mysqli_query($con, $user_name);
                     while($rw= mysqli_fetch_assoc($get_data))
{
  $user=$rw['name'];
}
                      // Check if the username exists
                      if ($user!='') {
                        echo "<tr><td>$i</td><td>$row[date]</td> <td><a href='ind-amount.php?id=$row[user_id]'>$user
                        </a></td><td>$row[description]</td><td>" . number_format($amt) . "</td>";
                        if (is_numeric($main)) {
                          $main += $row["amount"];
                      } else {
                          $main = $row["amount"];
                      }
                      }
                      
                        echo "<td>" . number_format($main) . "</td></tr>";
                      
                    }
                  }
                  
                  ?>

                </tbody>
              </table>
            </div><!-- bd -->
          </div>
        </div><!-- card -->
      </div><!-- col-12 -->

    </div><!-- row -->


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
<script>
  function updateBalanceAmount(user_id) {
    $.ajax({
      url: 'update_balance.php', // Replace with the path to your server-side script to update the balance amount
      method: 'POST',
      data: { user_id: user_id },
      success: function (response) {
        // Update the balance amount on the dashboard
        $('#balance-amount-' + user_id).html(response);
      },
      error: function (xhr, status, error) {
        console.error('Error updating balance amount:', error);
      }
    });
  }
</script>

</body>

</html>