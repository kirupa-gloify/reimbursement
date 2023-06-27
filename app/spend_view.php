<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<?php
require_once("config.php");
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
// Check if a date range is selected
if(isset($_SESSION["wh"]) && $_SESSION["wh"] != '') {
    $where = $_SESSION["wh"];
    unset($_SESSION["wh"]);
} else {
    $where = "MONTH(date) = MONTH(now()) and YEAR(date) = YEAR(now())"; // Show all data by default
}
?>


<?php require_once('header.php'); ?>
<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="dashboard.php">Gloify</a>
            <span class="breadcrumb-item active">Spending Amount Details</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Current Month Spending Amount Details</h4>
    </div>
    

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="row mg-t-0">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-6 col-md-9">
                            <div class="btn-demo">
                                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Spending Amount Details</h6>
                            </div><!-- btn-demo -->
                        </div><!-- col-sm-6 -->

                        <div class="col-sm-6 col-md-3 mg-t-20 mg-sm-t-0">
                            <div class="btn-demo">
                               
                            </div><!-- btn-demo -->
                        </div><!-- col-sm-3 -->


                    </div><!-- row -->


                    <div class="bd bd-gray-300 rounded table-responsive">
                        <table class="table mg-b-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Reimburse By</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Main Amount</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                require_once("config.php");
                                $i = 0;
                                $main = 0;
                                $sql = "SELECT * FROM expense WHERE $where ORDER BY date ASC";
                                $res = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $out=$row['amount'];
                                    $i = $i + 1;
                                    if ($row['user_id']) {
                                        $id = $row["id"];
                                        $date = $row["date"];
                                        $d = date('d/m/Y', strtotime($date));
                                        $user_id = $row["user_id"];
                                        //fetching user name from users table
                                        $user_name = "SELECT name FROM userdetails WHERE id='" . $user_id . "'";
                                        $get_data = mysqli_query($con, $user_name);
                                        $username = mysqli_fetch_assoc($get_data);
                                        if ($username) {
                                        echo "<tr><td>$i</td><td>$d</td><td><a href='ind-amount.php?id=$row[user_id]'>$username[name]</a></td><td>$row[description]</td
                                        ><td>".fill($out)."</td>";
                                            $main = $main + $row['amount'];
                                            $out=$main;
                                            echo "<td>".fill($out)."</td></tr>";
                                        }
                                    }
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