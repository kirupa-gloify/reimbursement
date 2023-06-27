<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <?php
  session_start();
  if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
    header("location: login.php");
    exit;
  }
  ?>
  <?php
  require_once('config.php');
  $id = $_SESSION["id"];
  unset($_SESSION["wh"]);
  $_SESSION["wh"] = "MONTH(date) = MONTH(now()) and YEAR(date) = YEAR(now())";
  ?>
  <?php
  require_once('header.php');
  ?>
  <?php
  function fill($out)
  {
    $output = $out;
    if ($output >= 1000) {
      $x = round($output);
      $x_number_format = number_format($x);
      $x_array = explode(',', $x_number_format);
      $x_parts = array('k', 'L', 'm', 'b', 't');
      $x_count_parts = count($x_array) - 1;
      $output = $x;
      $output = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
      $output .= $x_parts[$x_count_parts - 1];

    }
    if ($output <= 1000) {
      $x = round((float) $output);
      $x_number_format = number_format($x);
      $x_array = explode(',', $x_number_format);
      $x_count_parts = count($x_array) - 1;

      if (isset($x_array[0])) {
        $output = $x_array[0];
        if (isset($x_array[1][0]) && (int) $x_array[1][0] !== 0) {
          $output .= '.' . $x_array[1][0];
        }
        if ($x_count_parts > 0) {
          $x_parts = array('k', 'L', 'm', 'b', 't');
          $output .= $x_parts[$x_count_parts - 1];
        }
      }
    }

    return $output;
  }

  ?>
  <style>
    .bg-danger {
      background-color: #cf303f80 !important;
    }

    .bg-success {
      background-color: #23bf0873 !important;
    }
  </style>
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
      <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
        <a class="breadcrumb-item active" href="monthly-report.php">Monthly Spending Amount</a>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-30">
      <div class="row row-sm" id="total">
        <div class="col-sm-6 col-xl-10 mg-t-20 mg-sm-t-0">
          <h4 class="tx-gray-800 mg-b-5">Monthly Total Spending Amount</h4>
          <p class="mg-b-0"></p>
        </div>
        <div class="col-sm-6 col-xl-2 mg-t-20 mg-sm-t-0">
          <form>
            <div class="form-group">
              <input type="month" name="month" id="month" class="form-control" placeholder="month" required="">
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      // Get the current date
      var currentDate = new Date();

      // Get the current month and year
      var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
      var currentYear = currentDate.getFullYear().toString();

      // Create the default value for the month input
      var defaultValue = currentYear + '-' + currentMonth;

      // Set the default value of the month input
      document.getElementById('month').value = defaultValue;
    </script>
    <script>
      // Fetch the data when a month is selected
      $('#month').change(function () {
        var selectedMonth = $(this).val();

        $.ajax({
          url: 'monthly-check.php',
          type: 'GET',
          dataType: 'json',
          data: { month: selectedMonth },
          success: function (data) {
           
            $('.tx-lato.tx-bold.mg-b-2.lh-1:eq(0)').text(data.currentMonthProvidedAmount);
            $('.tx-lato.tx-bold.mg-b-2.lh-1:eq(1)').text(data.currentMonthSpendingAmount);
            $('.tx-lato.tx-bold.mg-b-2.lh-1:eq(2)').text(data.balanceAmount);
            var blc = data.currentMonthSpendingAmount;
            var pro = data.currentMonthProvidedAmount;
            var bc = data.balanceAmount;
            $('#messageCard').removeClass().addClass(response.cardClass);
    $('#message').text(response.message);
          },
          error: function () {
            console.log('Error fetching data from server');
          }
        });
      });
    </script>

    <div class="br-pagebody mg-t-5 pd-x-30">
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
          <div class="bg-success rounded overflow-hidden"style="border-radius: 8px !important;">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"
                  style="font-weight: 700;">
                  Monthly Provided Amount
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?php
                  $providedAmount1 = 0; // Default value if the query fails
                  
                  $currentMonth = date('m');
                  $sql = "SELECT SUM(addamount) AS totalAmount FROM monthly_report WHERE MONTH(date) = $currentMonth";
                  $result = mysqli_query($con, $sql);

                  if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row) {
                      $providedAmount1 = $row['totalAmount'];
                    }
                  }

                  // Display zero if no spending records for the current month
                  if ($providedAmount1 === null) {
                    $providedAmount1 = 0;
                  }

                  $out = $providedAmount1;
                  echo "" . fill($out);
                  // echo $providedAmount;
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
          <?php
          // Fetch total amount details
          $query = "SELECT SUM(amount) AS spending_amt FROM expense WHERE MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";
          $result = mysqli_query($con, $query);

          // Check if query executed successfully
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $spending_amt = $row['spending_amt'];
          } else {
            echo 'Error executing query: ' . mysqli_error($con);
          }

          // Display zero if no spending records for the current month
          if ($spending_amt === null) {
            $spending_amt = 0;
          }
          
          ?>
          <div class="rounded overflow-hidden" style=" border-radius: 8px !important;">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <a href="spend_view.php?">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"
                    style="font-weight: 700;">
                    Monthly Spending Amount
                  </p>
                </a>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?php
                  $out = $spending_amt;
                  echo "" . fill($out);
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->

        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
          <?php
          $balanceAmount = $providedAmount1 - $spending_amt;
          ?>
          <div class="rounded overflow-hidden" style="border-radius: 8px !important;">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"
                  style="font-weight: 700;">
                  Monthly Balance Amount
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?php
                  $out = $balanceAmount;
                  echo "" . fill($out);
                  ?>

                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
      </div>
    </div><!-- br-pagebody -->


    <div class="pd-30" style="padding-top: 60px;">
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-10 mg-t-20 mg-sm-t-0">
          <h4 class="tx-gray-800 mg-b-5">Monthly Provided Amount For Individual</h4>
          <p class="mg-b-0"></p>
        </div>
        <div class="col-sm-6 col-xl-2 mg-t-20 mg-sm-t-0">
          <form>
            <div class="form-group">
              <input type="month" name="month" onInput="check2()" id="provid" class="form-control" placeholder="month"
                required="">
            </div>
          </form>
        </div>
      </div>
    </div><!-- d-flex -->
    <script>
      // Get the current date
      var currentDate = new Date();

      // Get the current month and year
      var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
      var currentYear = currentDate.getFullYear().toString();

      // Create the default value for the month input
      var defaultValue = currentYear + '-' + currentMonth;

      // Set the default value of the month input
      document.getElementById('provid').value = defaultValue;
    </script>
    <script>
      function check2() {
        var month = $("#provid").val();
        $.ajax({
          url: "month-check.php",
          data: { month1: month }, // Pass the selected month value as 'month'
          type: "POST",
          success: function (data) {
            var response = data;
            $("#pvd").html(response); // Update the spending amounts with the retrieved data

          },
          error: function () { }
        });
      }
    </script>
    <div class="br-pagebody mg-t-5 pd-x-30">
      <div class="row row-sm" id="pvd">
        <?php
        require_once('config.php');

        // Retrieve the default month value
        $currentMonth = date('Y-m');
        $where = "MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";

        $query = "SELECT * FROM userdetails";
        $res = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($res)) {
          $user_id = $row['id'];
          $name = $row["name"];
          $qry = "SELECT SUM(addamount) FROM monthly_report WHERE user_id='$user_id' AND $where";
          $res1 = mysqli_query($con, $qry);
          while ($rw = mysqli_fetch_assoc($res1)) {
            $add = $rw['SUM(addamount)'];
          }
          $qry1 = "SELECT SUM(amount) FROM expense WHERE user_id='$user_id' AND $where";
          $res11 = mysqli_query($con, $qry1);
          while ($rw = mysqli_fetch_assoc($res11)) {
            $spendingAmount = $rw['SUM(amount)'];
          }
          ?>
          <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-10">
            <div class="bg-danger rounded overflow-hidden"
              style="background-color: #23bf0873 !important; border-radius: 8px !important;">
              <div class="pd-25 d-flex align-items-center <?= $cardClass ?>">
                <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"
                    style="font-weight: 700;">
                    <?= $name ?>
                  </p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                    <?php
                    $out = $add;
                    echo "" . fill($out);
                    ?>
                  </p>
                </div>
              </div>
            </div>
          </div><!-- col-3 -->
        <?php } ?>
      </div>
    </div><!-- br-pagebody -->


    <div class="pd-30" style="padding-top: 60px;">
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-10 mg-t-20 mg-sm-t-0">
          <h4 class="tx-gray-800 mg-b-5">Monthly Individual Spending Amount</h4>
          <p class="mg-b-0"></p>
        </div>
        <div class="col-sm-6 col-xl-2 mg-t-20 mg-sm-t-0">
          <form>
            <div class="form-group">
              <input type="month" name="month" onInput="check()" id="monthInput" class="form-control"
                placeholder="month" required="">
            </div>
          </form>
        </div>
      </div>
    </div><!-- d-flex -->
    <script>
      // Get the current date
      var currentDate = new Date();

      // Get the current month and year
      var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
      var currentYear = currentDate.getFullYear().toString();

      // Create the default value for the month input
      var defaultValue = currentYear + '-' + currentMonth;

      // Set the default value of the month input
      document.getElementById('monthInput').value = defaultValue;
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      function check() {
        var month = $("#monthInput").val();
        $.ajax({
          url: "month-check.php",
          data: { month: month }, // Pass the selected month value as 'month'
          type: "POST",
          success: function (data) {
            var response = data;
            $("#spendingAmounts").html(response); // Update the spending amounts with the retrieved data

          },
          error: function () { }
        });
      }
    </script>
    <div class="br-pagebody mg-t-5 pd-x-30">
      <div class="row row-sm" id="spendingAmounts">
        <?php
        require_once('config.php');

        // Retrieve the default month value
        $currentMonth = date('Y-m');
        $where = "MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";

        if (isset($_POST["month"])) {
          $selectedMonth = $_POST["month"];
          $firstDayOfMonth = date('Y-m-01', strtotime($selectedMonth));
          $lastDayOfMonth = date('Y-m-t', strtotime($selectedMonth));
          $where = "date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
        }

        $sql = "SELECT user_id, SUM(amount) AS total_amount FROM expense WHERE $where GROUP BY user_id";
        $res = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($res)) {
          $userid = $row['user_id'];
          $qry = "SELECT * FROM userdetails WHERE id='$userid'";
          $res1 = mysqli_query($con, $qry);

          while ($rw = mysqli_fetch_assoc($res1)) {
            $name = $rw['name'];
          }

          $query = "SELECT SUM(amount) AS total_amount FROM expense WHERE $where AND user_id='$userid'";
          $result = mysqli_query($con, $query);

          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $spendingAmount = $row['total_amount'];
          } else {
            $spendingAmount = 0; // Set a default value if the query fails
          }

          $query = "SELECT SUM(addamount) AS total_amount FROM monthly_report WHERE user_id='$userid' AND $where";
          $result = mysqli_query($con, $query);

          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $providedAmount1 = $row['total_amount'];
          } else {
            $providedAmount1 = 0; // Set a default value if the query fails
          }

          // Compare the spending amount with the provided amount
          if ($spendingAmount > $providedAmount1) {
            echo "<style>#bgcolor{background-color:#cf303f80 !important;}</style>";
          } else {
            echo "<style>#bgcolor{background-color:#23bf0873 !important;}</style>";
          }
          ?>

          <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-10">
            <div class="rounded overflow-hidden" id='bgcolor' style="border-radius: 8px !important;">
              <div class="pd-25 d-flex align-items-center">
                <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
                <div class="mg-l-20">
                  <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"
                    style="font-weight: 700;">
                    <?= $name ?> Spend
                  </p>
                  <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                    <?php
                    $out = $spendingAmount;
                    echo "" . fill($out);
                    ?>

                  </p>
                </div>
              </div>
            </div>
          </div><!-- col-3 -->
        <?php } ?>
      </div>
    </div><!-- br-pagebody -->
    <footer class="br-footer">
      <div class="footer-left">
        <div class="mg-b-2">Copyright &copy; 2023. Gloify. All Rights Reserved.
        </div>
      </div>
      <div class="footer-right d-flex align-items-center">
        <span class="tx-uppercase mg-r-10">Share:</span>
        <a target="_blank" class="pd-x-5" href=""><i class="fa fa-facebook tx-20"></i></a>
        <a target="_blank" class="pd-x-5" href=""><i class="fa fa-twitter tx-20"></i></a>
      </div>
    </footer>





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
</body>

</html>