<?php 
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header ("location: login.php");
    exit;
}
?>
<?php
require_once("config.php");
if(isset($_POST["submit"])){
  $name=$_POST["name"];
  $mobile=$_POST["mobilenum"];
  $package=$_POST["package"];
  $date = date('Y-m-d');
  
  
  $sql="insert into userdetails (name,phonenumber,package,balance_amt,date) VALUES ('$name','$mobile','$package','$package','$date')";
  $res=mysqli_query($con,$sql);
  if($res){
    $query="select * from userdetails where name='$name'";
    $rs=mysqli_query($con,$query);
    while($rw=mysqli_fetch_assoc($rs)){
      $id=$rw["id"];
    }
    $sql1 = "insert into monthly_report (user_id,addamount,date) VALUES ('$id','$package','$date')";
    $res1=mysqli_query($con,$sql1);
    header("Location: " . $siteURL . "add-users.php?result=success");
    }
    else{
    echo"<script>alert('Failed')</script>";
    }
  }
?>
<?php
require_once('header.php')
?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
          <a class="breadcrumb-item" href="users.php">Users</a>
          <span class="breadcrumb-item active">Add Users</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Add Users</h4>
        
      </div>
<form action="" method="post">
      <div class="br-pagebody">
        <div class="br-section-wrapper">
           <div class="row mg-t-0">
            <div class="col-xl-12">
            <?php
            if ($_GET) {
            if ($_GET['result'] == 'success') {
              // echo "$_GET[result]";die;
              ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your data has been added successfully</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php } } ?>
              <div class="form-layout form-layout-4">
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Add Users</h6>
                <div class="row">
                  <label class="col-sm-4 form-control-label">Name: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control" name="name" placeholder="Enter Name" id="name"
                    onInput="check()" required="">
                    <span id="check-username"></span>
                  </div>
                </div><!-- row -->
                <div class="row mg-t-20">
                  <label class="col-sm-4 form-control-label">Phone Number: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input type="tel" class="form-control" name="mobilenum" placeholder="Enter Phone Number" id="number" required="">
                  </div>
                </div>
                <div class="row mg-t-20">
                  <label class="col-sm-4 form-control-label">Provided Amount: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <input type="text" class="form-control" name="package" placeholder="Enter Amount" required="">
                  </div>
                </div>
                
                
                </div>
                <div class="form-layout-footer mg-t-30">
                  <button type="submit" name="submit" id="submit" class="btn btn-info">Add User</button>
                  
                </div><!-- form-layout-footer -->
              </div><!-- form-layout -->
            </div><!-- col-6 -->
</form> 

        

        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2023. Gloify. All Rights Reserved.</div>
        </div>
        <div class="footer-right d-flex align-items-center">
          <span class="tx-uppercase mg-r-10">Share:</span>
          <a target="_blank" class="pd-x-5" href=""><i class="fa fa-facebook tx-20"></i></a>
          <a target="_blank" class="pd-x-5" href=""><i class="fa fa-twitter tx-20"></i></a>
        </div>
      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function check() {
  var name = $("#name").val();
    jQuery.ajax({
    url: "check.php",
    data:'name='+name,
    type: "POST",
    success:function(data){
        $("#check-username").html(data);
    },
    error:function (){}
    });
}
</script>
    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>
    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="../lib/moment/moment.js"></script>
    <script src="../lib/jquery-ui/jquery-ui.js"></script>
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
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>