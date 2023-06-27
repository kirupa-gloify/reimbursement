<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
}
?>
<?php
require_once('config.php');
require_once('header.php');
?>
 
</style>
 <!-- Monthly Individual Spending Amount -->
 <div class="br-mainpanel">
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
      <a class="breadcrumb-item active" href="monthly-report.php">Monthly Report</a>
    </nav>
  </div><!-- br-pageheader -->
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
  
  <div class="br-pagebody mg-t-5 pd-x-30" id="spendingAmounts">
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
        ?>

        <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-10">
          <div class="rounded overflow-hidden" style="border-radius: 8px !important;">
            <div class="pd-25 d-flex align-items-center">
              <i class="fa fa-calendar tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10" style="font-weight: 700;">
                  <?= $name ?> Spend
                </p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1" style="font-weight: 700;">
                  <?php
                   
                  echo $spendingAmount;
                  ?>

                </p>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
      <?php } ?>
    </div>
  </div><!-- br-pagebody -->
  <script>
  // Function to update monthly individual spending amounts
function updateMonthlyIndividualSpending(selectedMonth) {
  $.ajax({
    url: 'fetch_spending_amounts.php',
    type: 'POST',
    data: { month: selectedMonth },
    dataType: 'html',
    success: function(response) {
      $('#spendingAmounts').html(response);
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}

// Event listener for month selection
$('#monthInput').change(function() {
  var selectedMonth = $(this).val();
  if (selectedMonth !== "") {
    updateMonthlyIndividualSpending(selectedMonth);
  }
});
</script>
