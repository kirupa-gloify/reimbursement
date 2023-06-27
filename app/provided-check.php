<?php
include("config.php");

if (isset($_POST['month'])) {
  $selectedMonth = $_POST['month'];

  // Get all user details
  $query = "SELECT * FROM userdetails";
  $res = mysqli_query($con, $query);

  $providedAmounts = [];
  $users = [];

  while ($row = mysqli_fetch_assoc($res)) {
    $user_id = $row['id'];

    $sql = "SELECT COALESCE(SUM(addamount), 0) AS monthly_provided_amount 
            FROM monthly_report 
            WHERE user_id = $user_id AND DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
    $result = mysqli_query($con, $sql);

    $currentMonthProvidedAmount = 0;
    if ($result) {
      $providedRow = mysqli_fetch_assoc($result);
      $currentMonthProvidedAmount = $providedRow['monthly_provided_amount'];
    }

    // Display zero if no provided amount records for the selected month
    if ($currentMonthProvidedAmount === null) {
      $currentMonthProvidedAmount = 0;
    }

    // Append the provided amount and user to the arrays
    $providedAmounts[] = $currentMonthProvidedAmount;
    $users[] = $row['name'];
  }

  // Prepare the JSON response
  $response = [
    'providedAmounts' => $providedAmounts,
    'users' => $users
  ];

  // Send the JSON response
  header('Content-Type: application/json');
  
  echo json_encode($response);
  exit;
}
?>