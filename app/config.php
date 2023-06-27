<?php
// Construct the site URL based on the current server environment
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$siteURL = $protocol . $_SERVER['HTTP_HOST'] . '/reimbursement/app'; // Updated site URL
$imgURL = $protocol . $_SERVER['HTTP_HOST'] . '/reimbursement/img/';
$con=mysqli_connect('localhost','root','','project1');
?>