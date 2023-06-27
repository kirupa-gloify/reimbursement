<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
  header("location: login.php");
  exit;
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
      <span class="breadcrumb-item active">Manage User</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Manage User</h4>

  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <div class="row mg-t-0">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-sm-6 col-md-9">
              <div class="btn-demo">
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Manage User</h6>
              </div><!-- btn-demo -->
            </div><!-- col-sm-3 -->

            <div class="col-sm-6 col-md-3 mg-t-20 mg-sm-t-0">
              <div class="btn-demo">
                <a href="add-admin.php" class="btn btn-primary btn-block mg-b-10"><i class="fa fa-plus mg-r-10"></i>Add
                  Admin</a>
              </div><!-- btn-demo -->
            </div><!-- col-sm-3 -->


          </div><!-- row -->


          <div class="bd bd-gray-300 rounded table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>User Name</th>
                  <th>Email Address</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
require_once("config.php");

if (isset($_POST['submit'])) {
   $status=$_POST["status"];
   $id=$_POST["id"];
   $sql="UPDATE register SET status='$status' where id='$id'";
    $res = mysqli_query($con, $sql);
    if (!$res) {
        // Handle the update error
        echo "Error updating addpackage amount: " . mysqli_error($con);
    }
}
// Fetch user details from the userdetails table
$i = 0;
$sql = "SELECT * FROM register";
$res = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $i = $i + 1;
    $id = $row["id"];
    $username = $row["username"];
    $emailaddress = $row["emailaddress"];
    $status = $row["status"];

    echo "<tr>
        <td>$i </td>
        <td>$username</td>
        <td>$emailaddress</td><form action='' method='post'>
        <td><input type='hidden' name='id' value='$id'>
        <select type='text' name='status' class='form-control'>";
        if($status=='APPROVED'){
        echo"<option value='$status'>$status</option>
        <option value='NOT APPROVED'>NOT APPROVED</option></select></td>";
}elseif($status=='NOT APPROVED'){
  echo"<option value='$status'>$status</option>
  <option value='APPROVED'>APPROVED</option>";
}else{
  echo"<option value='$status'>$status</option>
  <option value='APPROVED'>APPROVED</option>
  <option value='NOT APPROVED'>NOT APPROVED</option>";
}
        echo"<td>
            <button class='btn btn-success' name='submit'>Submit</button>
            
       </form> </td>
    </tr>";
}
?>
</tbody>
            </table>
          </div><!-- bd -->
        </div><!-- col-12 -->
      </div><!-- row -->
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
  <footer class="br-footer">
    <div class="footer-left">
      <div class="mg-b-2">Copyright &copy; 2023. Gloify. All Rights Reserved.</div>
    </div>
    <div class="footer-right d-flex align-items-center">
      <span class="tx-uppercase mg-r-10">Share:</span>
      <a target="_blank" class="pd-x-5"
        href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracket/intro"><i
          class="fa fa-facebook tx-20"></i></a>
      <a target="_blank" class="pd-x-5"
        href="https://twitter.com/home?status=Bracket,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracket/intro"><i
          class="fa fa-twitter tx-20"></i></a>
    </div>
  </footer>
</div><!-- br-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->

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
  $(function () {
    'use strict'

    // FOR DEMO ONLY
    // menu collapsed by default during first page load or refresh with screen
    // having a size between 992px and 1299px. This is intended on this page only
    // for better viewing of widgets demo.
    $(window).resize(function () {
      minimizeMenu();
    });

    minimizeMenu();

    function minimizeMenu() {
      if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
        // show only the icons and hide left menu label by default
        $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
        $('body').addClass('collapsed-menu');
        $('.show-sub + .br-menu-sub').slideUp();
      } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
        $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
        $('body').removeClass('collapsed-menu');
        $('.show-sub + .br-menu-sub').slideDown();
      }
    }
  });
</script>