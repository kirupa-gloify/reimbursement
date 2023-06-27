<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedMonth = $_POST['month'];

    $providedAmount = 0;
    $spendingAmount = 0;
    $balanceAmount = 0;
    $balanceColor = '';
    $spendingColor = '';

    // Query to get the provided amount for the selected month
    $sqlProvided = "SELECT SUM(addamount) AS totalAmount FROM monthly_report WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
    $resultProvided = mysqli_query($con, $sqlProvided);
    if ($resultProvided && mysqli_num_rows($resultProvided) > 0) {
        $rowProvided = mysqli_fetch_assoc($resultProvided);
        $providedAmount = $rowProvided['totalAmount'];
    }
   

    // Query to get the spending amount for the selected month
    $sqlSpending = "SELECT SUM(amount) AS spending_amt FROM expense WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
    $resultSpending = mysqli_query($con, $sqlSpending);
    if ($resultSpending && mysqli_num_rows($resultSpending) > 0) {
        $rowSpending = mysqli_fetch_assoc($resultSpending);
        $spendingAmount = $rowSpending['spending_amt'];
    }

    // Calculate the balance amount
    $balanceAmount = $providedAmount - $spendingAmount;

    // Determine the balance color based on the provided and spending amounts
    if ($providedAmount > $spendingAmount) {
        $balanceColor = '#23bf0873';
    } else {
        $balanceColor = '#cf303f80';
    }
    // Determine the spending color based on the spending amount and provided amount
if ($spendingAmount > $providedAmount) {
    $spendingColor = '#23bf0873'; // Set the color to red for spending exceeding provided amount
} else {
    $spendingColor = '#cf303f80'; // Set the color to black for zero or lower spending than provided amount
}

    // Prepare the response data
    $responseData = [
        'providedAmount' => ($providedAmount !== null) ? $providedAmount : 0,
        'spendingAmount' => ($spendingAmount !== null) ? $spendingAmount : 0,
        'balanceAmount' => $balanceAmount,
        'balanceColor' => $balanceColor,
        'spendingColor' => $spendingColor,
        
        
    ];

    // Return the response data as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
}
?>
