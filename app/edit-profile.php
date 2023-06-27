<?php
session_start();
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true) {
    header("location: login.php");
    exit;
}
$name=$_SESSION["name"];
?>

<?php
require_once("config.php");

$username1 = ""; // Initialize the variable here
$emailaddress1 = "";
$password1 = "";
$sql1 = "SELECT * FROM register WHERE username='$name'";
$res2 = mysqli_query($con, $sql1);
while ($row1 = mysqli_fetch_assoc($res2)) {
    $username1 = $row1["username"];
    $emailaddress1 = $row1["emailaddress"];
    $password1 = $row1["password"];
}

if (isset($_POST["submit"])) {
    $username2 = $_POST["username"];
    $emailaddress2 = $_POST["emailaddress"];
    $password2 = $_POST["password"];
    $sql = "Update register SET username='$username2',emailaddress='$emailaddress2',password='$password2' ";

    $res = mysqli_query($con, $sql);
    if ($res) {
        header("Refresh:0");
    } else {
        echo "<script>alert('Failed')</script>";
    }
}
?>

<?php
require_once('header.php');
?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
            <a class="breadcrumb-item active" href="edit-profile.php">Edit Profile</a>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Edit Profile</h4>
    </div>
    <form action="" method="post">
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row mg-t-0">
                    <div class="col-xl-12">
                        <div class="form-layout form-layout-4">
                            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Profile</h6>
                            <div class="row">

                                <label class="col-sm-4 form-control-label">Username: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="text" class="form-control" name="username" placeholder="Enter Name"
                                        value="<?php echo $username1; ?>"required="">

                                </div>
                            </div><!-- row -->
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">Email Address: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="email" class="form-control" name="emailaddress"
                                        placeholder="Enter Email Address" value="<?php echo $emailaddress1; ?>"required="">
                                </div>
                            </div>
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">Password: <span
                                        class="tx-danger">*</span></label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password"
                                        value="<?php echo $password1; ?>" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-layout-footer mg-t-30">
                            <button type="submit" name="submit" class="btn btn-info">Update</button>
                        </div><!-- form-layout-footer -->
                    </div><!-- form-layout -->
                </div><!-- col-6 -->
            </div>
        </div>
    </form>
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
<!-- Rest of your code -->
</div><!-- br-mainpanel -->