<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>
<?php
require_once('header.php');
require_once('config.php');
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="br-mainpanel">
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
      <a class="breadcrumb-item active" href="monthly-report.php">Monthly Report</a>
    </nav>
  </div><!-- br-pageheader -->


  <!-- Monthly Report -->
  <div class="pd-30">
    <div class="row row-sm" id="total">
      <div class="col-sm-6 col-xl-10 mg-t-20 mg-sm-t-0">
        <h4 class="tx-gray-800 mg-b-5">Monthly Report</h4>
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

  <div class="br-pagebody mg-t-5 pd-x-30">
    <div class="row row-sm">
      <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
        <div class="bg-danger rounded overflow-hidden"
          style="background-color: #23bf0873 !important; border-radius: 8px !important;">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                Monthly Provided Amount
              </p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                <!-- Display provided amount dynamically -->
                <span id="providedAmount"></span>
                <?php
                $providedAmount1 = 0; // Initialize the variable
                
                $currentMonth = date('m');
                $sql = "SELECT SUM(addamount) AS totalAmount FROM monthly_report WHERE MONTH(date) = $currentMonth";
                $result = mysqli_query($con, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  if ($row) {
                    $providedAmount1 = $row['totalAmount'];
                  }
                }
                // Display zero if no spending records for the current month
                if ($providedAmount1 === null) {
                  $providedAmount1 = 0;
                }
                ?>
                <script>
                  // Update the provided amount dynamically
                  document.getElementById('providedAmount').textContent = "<?php echo $providedAmount1; ?>";
                </script>
              </p>
            </div>
          </div>
        </div>
      </div>


      <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
        <?php
        // Fetch total amount details
        $query = "SELECT SUM(amount) AS spending_amt FROM expense WHERE MONTH(date) = MONTH(NOW()) AND YEAR(date) = YEAR(NOW())";
        $result = mysqli_query($con, $query);

        // Check if query executed successfully
        if ($result) {
          $row = mysqli_fetch_assoc($result);
          $spending_amt = $row['spending_amt'];
        }
        ?>
        <div class="rounded overflow-hidden" id="spendingAmountCard" style="border-radius: 8px !important;">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <!-- <a href="spend_view.php">  -->
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                Monthly Spending Amount
              </p>
              <!-- </a>   -->
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                <!-- Display spending amount dynamically -->

                <span id="spendingAmount">
                  <?php echo $spending_amt; ?>
                </span>
              </p>
            </div>
          </div>
        </div>
      </div><!-- col-3 -->

      <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
        <!-- Monthly Balance Amount Card -->
        <?php

        $balanceAmount = $providedAmount1 - $spending_amt;
        ?>
        <div class="rounded overflow-hidden" id="balanceCard" style="border-radius: 8px !important;">
          <div class="pd-25 d-flex align-items-center">
            <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                Monthly Balance Amount
              </p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                <!-- Display balance amount dynamically -->
                <span id="balanceAmount">
                  <?php echo $balanceAmount; ?>
                </span>
              </p>
            </div>
          </div>
        </div>
      </div><!-- col-3 -->
    </div><!-- row -->
  </div><!-- br-pagebody -->
  <script>
    // Get the current date
    var currentDate = new Date();

    // Get the current month and year
    var currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    var currentYear = currentDate.getFullYear().toString();

    // Create the default value for the month 
    var defaultValue = currentYear + '-' + currentMonth;

    // Set the default value of the month input
    document.getElementById('month').value = defaultValue;
  </script>

  <script>
    $(document).ready(function () {
      // Function to update monthly data
      function updateMonthlyData(selectedMonth) {
        $.ajax({
          url: 'update_monthly_data.php',
          type: 'POST',
          data: { month: selectedMonth },
          dataType: 'json',
          success: function (data) {
            // Format provided amount with commas
        var providedAmount = parseFloat(data.providedAmount);
        if (!isNaN(providedAmount)) {
          $('#providedAmount').text(providedAmount.toLocaleString());
        } else {
          $('#providedAmount').text('0');
        }

        // Format spending amount with commas
        var spendingAmount = parseFloat(data.spendingAmount);
        if (!isNaN(spendingAmount)) {
          $('#spendingAmount').text(spendingAmount.toLocaleString());
        } else {
          $('#spendingAmount').text('0');
        }

        // Format balance amount with commas
        var balanceAmount = parseFloat(data.balanceAmount);
        if (!isNaN(balanceAmount)) {
          $('#balanceAmount').text(balanceAmount.toLocaleString());
        } else {
          $('#balanceAmount').text('0');
        }
            //$('#providedAmount').text(data.providedAmount);
            //$('#spendingAmount').text(data.spendingAmount);
            //$('#balanceAmount').text(data.balanceAmount);

            // Set background color for provided amount card
            if (data.providedAmount === 0 && selectedMonth !== "") {
              $('#providedAmountCard').css('background-color', 'green');
            } else {
              $('#providedAmountCard').css('background-color', data.balanceColor);
            }

            // Set background color for spending amount card
            if (data.spendingAmount === 0 && selectedMonth !== "") {
              $('#spendingAmountCard').css('background-color', '#23bf0873');
            } else {
              $('#spendingAmountCard').css('background-color', data.balanceColor);
            }

            // Set background color for balance card
            if (data.providedAmount === 0 && data.spendingAmount === 0 && selectedMonth !== "") {
              $('#balanceCard').css('background-color', '#23bf0873');
            } else {
              $('#balanceCard').css('background-color', data.balanceColor);
            }
          },
          error: function (xhr, status, error) {
            console.log(error);
          }
        });
      }

      // Event listener for month selection
      $('#month').change(function () {
        var selectedMonth = $(this).val();
        if (selectedMonth !== "") {
          updateMonthlyData(selectedMonth);
        } else {
          // Clear the values and display zero
          $('#providedAmount').text("0");
          $('#spendingAmount').text("0");
          $('#balanceAmount').text("0");
          $('#providedAmountCard').css('background-color', '');
          $('#spendingAmountCard').css('background-color', '');
          $('#balanceCard').css('background-color', '');
        }
      });

      // Load initial data for the current month
      var currentMonth = new Date().toISOString().slice(0, 7);
      updateMonthlyData(currentMonth);
    });
  </script>



  <!-- Monthly Provided Amount For Individual -->
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
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                  <?= $name ?>
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  
                  
                  <?= number_format($add) ?>
                  
                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
      <?php } ?>
    </div>
  </div><!-- br-pagebody -->


  <!-- Monthly Individual Spending Amount -->
  <div class="pd-30" style="padding-top: 60px;">
    <div class="row row-sm">
      <div class="col-sm-6 col-xl-10 mg-t-20 mg-sm-t-0">
        <h4 class="tx-gray-800 mg-b-5">Monthly Individual Spending Amount</h4>
        <p class="mg-b-0"></p>
      </div>
      <div class="col-sm-6 col-xl-2 mg-t-20 mg-sm-t-0">
        <form>
          <div class="form-group">
            <input type="month" name="month" onInput="check()" id="monthInput" class="form-control" placeholder="month"
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
    document.getElementById('monthInput').value = defaultValue;

    function applyBackgroundColor() {
      var spendingAmounts = document.querySelectorAll('.spending-amount');
      for (var i = 0; i < spendingAmounts.length; i++) {
        var spendingAmount = spendingAmounts[i];
        var providedAmount = spendingAmount.dataset.providedAmount;
        var backgroundColor = (spendingAmount.dataset.spendingAmount > providedAmount) ? '#cf303f80' : '#23bf0873';
        spendingAmount.classList.add('bg-color');
        spendingAmount.style.backgroundColor = backgroundColor;
      }
    }

    function check() {
      var month = $("#monthInput").val();
      $.ajax({
        url: "month-check.php",
        data: {
          month: month
        }, // Pass the selected month value as 'month'
        type: "POST",
        success: function (data) {
          var response = data;
          $("#spendingAmounts").html(response); // Update the spending amounts with the retrieved data
          applyBackgroundColor(); // Apply the background color after updating the amounts
        },
        error: function () { }
      });
    }

    // Apply the initial background color
    applyBackgroundColor();
  </script>
  <div class="br-pagebody mg-t-5 pd-x-30">
    <div class="row row-sm" id="spendingAmounts">
      <?php
      
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
        // Compare the spending amount with the provided amount and set the background color
        $backgroundColor = ($spendingAmount > $providedAmount1) ? '#cf303f80' : '#23bf0873';
        ?>
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-10">
          <div class="rounded overflow-hidden"
            style="border-radius: 8px !important; background-color: <?php echo $backgroundColor; ?>;"
            data-spending-amount="<?php echo $spendingAmount; ?>" data-provided-amount="<?php echo $providedAmount1; ?>">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                  <?= $name ?> Spend
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?= number_format($spendingAmount) ?>
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
      
</div>
<script src="../lib/jquery/jquery.js"></script>
<script src="../lib/popper.js/popper.js"></script>
<script src="../lib/bootstrap/bootstrap.js"></script>
<script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="../lib/moment/moment.js"></script>
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