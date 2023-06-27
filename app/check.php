<?php
require_once"config.php";
if(!empty($_POST["name"])) {
    $query = "SELECT * FROM userdetails WHERE name='" . $_POST["name"] . "'";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo "<span style='color:red'> Sorry! This Username is already exists.</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
    }
    else{
        echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}
elseif(!empty($_POST["username"])){
    $query = "SELECT * FROM register WHERE username='" . $_POST["username"] . "'";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo "<span style='color:red'> Sorry! This Username is already exists.</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
    }
    else{
        echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}
    elseif(!empty($_POST["email"])){
        $query = "SELECT * FROM register WHERE emailaddress='" . $_POST["email"] . "'";
        $result = mysqli_query($con,$query);
        $count = mysqli_num_rows($result);
        if($count>0){
            echo "<span style='color:red'> Sorry! This Username is already exists.</span>";
            echo "<script>$('#submit').prop('disabled',true);</script>";
        }
        else{
            echo "<script>$('#submit').prop('disabled',false);</script>";
        }
}
    ?>