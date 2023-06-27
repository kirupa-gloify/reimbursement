<?php
require_once("config.php");
$id=$_GET["id"];
$sql1="DELETE  FROM userdetails WHERE id='$id';";
$sql1 .="DELETE FROM monthly_report WHERE user_id='$id'";
$res = $con->multi_query($sql1);

if($res){
    header("Refresh:0; url=users.php");
    }
    else{
    echo"<script>alert('Failed')</script>";
    }
    ?>
