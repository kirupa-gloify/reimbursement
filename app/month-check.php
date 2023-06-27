<?php
include 'config.php';


if (isset($_POST["month"])) {
  $selectedMonth = $_POST["month"];
  $firstDayOfMonth = date('Y-m-01', strtotime($selectedMonth));
  $lastDayOfMonth = date('Y-m-t', strtotime($selectedMonth));
  $where = "date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";

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
  <div class="rounded overflow-hidden" style="border-radius: 8px !important; background-color: <?php echo $backgroundColor; ?>;" data-spending-amount="<?php echo $spendingAmount; ?>" data-provided-amount="<?php echo $providedAmount1; ?>">
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
  <?php
  }
}

else if (isset($_POST["month1"])) {
  $selectedMonth = $_POST["month1"];
  $firstDayOfMonth = date('Y-m-01', strtotime($selectedMonth));
  $lastDayOfMonth = date('Y-m-t', strtotime($selectedMonth));
  $where = "date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";

  $query = "SELECT * FROM userdetails";
  $res = mysqli_query($con, $query);

  while ($row = mysqli_fetch_assoc($res)) {
    $user_id = $row['id'];
    $name=$row["name"];
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
if($add==''){
  $add=0;
}
    ?>

    <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-10">
      <div class=" rounded overflow-hidden" style="background-color: #23bf0873 !important; border-radius: 8px !important;">
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
  <?php
  }
}

?>