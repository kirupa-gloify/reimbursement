<?php
require_once("config.php");
$id=$_GET["id"];
$amt=$_GET["amt"];
$userid=$_GET["userid"];
$query="SELECT * FROM userdetails WHERE id='$userid'";
$rs=mysqli_query($con,$query);
while($rw=mysqli_fetch_assoc($rs)){
    $blc=$rw["balance_amt"];
}
$amtt=$blc+$amt;
$sql1="DELETE  FROM expense WHERE id='$id';";
$sql1 .="UPDATE userdetails SET balance_amt='$amtt' WHERE id='$userid'";
$res=$con -> multi_query($sql1);
if($res){
    header("Refresh:0; url=spending-amount.php");
    }
    else{
    echo"<script>alert('Failed')</script>";
    }
    ?>
