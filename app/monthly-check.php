<?php
include 'config.php';
function fill($out){
  $output = $out;
if($output>=1000) {

$x = round($output);
$x_number_format = number_format($x);
$x_array = explode(',', $x_number_format);
$x_parts = array('k','L', 'm', 'b', 't');
$x_count_parts = count($x_array) - 1;
$output = $x;
$output = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
$output .= $x_parts[$x_count_parts - 1];

}
return $output;
}
?>
<?php
function fill1($out1){
  $output1 = $out1;
if($output1>=1000) {

$x = round($output1);
$x_number_format = number_format($x);
$x_array = explode(',', $x_number_format);
$x_parts = array('k','L', 'm', 'b', 't');
$x_count_parts = count($x_array) - 1;
$output1 = $x;
$output1 = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
$output1 .= $x_parts[$x_count_parts - 1];

}
return $output1;
}
function fill2($out2){
  $output2 = $out2;
if($output2>=1000) {

$x = round($output2);
$x_number_format = number_format($x);
$x_array = explode(',', $x_number_format);
$x_parts = array('k','L', 'm', 'b', 't');
$x_count_parts = count($x_array) - 1;
$output2 = $x;
$output2 = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
$output2 .= $x_parts[$x_count_parts - 1];

}
elseif ($output2 <= -1000) {
  $x = round(abs($output2));
  $x_number_format = number_format($x);
  $x_array = explode(',', $x_number_format);
  $x_parts = array('k', 'L', 'm', 'b', 't');
  $x_count_parts = count($x_array) - 1;
  $output2 = '-' . $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
  $output2 .= $x_parts[$x_count_parts - 1];
} else {
  $output2 = number_format($output2);
}
return $output2;
}
// Get the selected month from the AJAX request
$selectedMonth = $_GET['month'];
session_start();
unset($_SESSION["wh"]);
$_SESSION["wh"] = "DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";

// Fetch monthly provided amount
$currentMonthProvidedAmount = 0;
$sqlProvided = "SELECT SUM(addamount) AS totalAmount FROM monthly_report WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
$resultProvided = mysqli_query($con, $sqlProvided);

if ($resultProvided) {
  $rowProvided = mysqli_fetch_assoc($resultProvided);
  if ($rowProvided) {
    $currentMonthProvidedAmount = $rowProvided['totalAmount'];
  }
}


// Fetch monthly spending amount
$currentMonthSpendingAmount = 0;
$sqlSpending = "SELECT SUM(amount) AS totalAmount FROM expense WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
$resultSpending = mysqli_query($con, $sqlSpending);

if ($resultSpending) {
  $rowSpending = mysqli_fetch_assoc($resultSpending);

  if ($rowSpending) {
    $currentMonthSpendingAmount = $rowSpending['totalAmount'];
  }
}
// Compare the provided amount with the spending amount
if ($currentMonthProvidedAmount < $currentMonthSpendingAmount) {
  // Provided amount is less than spending amount
  // Perform your desired action here, such as displaying a message or taking appropriate steps.
  // Example: echo "Provided amount is less than spending amount";
} else {
  // Provided amount is greater than or equal to spending amount
  // Perform other actions if needed
}
if ($currentMonthProvidedAmount == '') {
  $currentMonthProvidedAmount = 0;
}
if ($currentMonthSpendingAmount == '') {
  $currentMonthSpendingAmount = 0;
}
// Compare the provided amount with the spending amount
if ($currentMonthProvidedAmount < $currentMonthSpendingAmount) {
  // Provided amount is less than spending amount
  $message = "Provided amount is less than spending amount";
  $cardClass = "card text-white bg-danger"; // CSS classes for danger color
} else {
  // Provided amount is greater than or equal to spending amount
  $message = "Provided amount is greater than or equal to spending amount";
  $cardClass = "card text-white bg-success"; // CSS classes for success color
}

// Calculate the balance amount
$balanceAmount = $currentMonthProvidedAmount - $currentMonthSpendingAmount;
$out=$currentMonthProvidedAmount;
$out1=$currentMonthSpendingAmount;
$out2=$balanceAmount;
// Prepare the data to send as JSON
$data = [
  'message' => $message,
  'cardClass' => $cardClass,
  'currentMonthProvidedAmount' => fill($out),
  'currentMonthSpendingAmount' => fill1($out1),
  'balanceAmount' => fill2($out2)
  
];

// Send the data as JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>