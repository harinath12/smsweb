<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if($_REQUEST['id']){
    $trip_id = $_REQUEST['id'];
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];

$trip_sql="SELECT * FROM `trip` where id='$trip_id'";
$trip_exe=mysql_query($trip_sql);
$trip_fet = mysqli_fetch_assoc($trip_exe);
$route_no = $trip_fet['route_no'];

$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 where route_no='$route_no'";
$trip_stop_exe=mysql_query($trip_stop_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Driver</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

    <style>
        .form-group{
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
<!-- Main navbar -->
<?php
include 'header.php';
?>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container" style="min-height:700px">

    <!-- Page content -->
    <div class="page-content"><!-- Main sidebar -->
        <div class="sidebar sidebar-main hidden-xs">
            <?php include "sidebar.php"; ?>
        </div>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> TRIP</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="trip-list.php">Trip List</a></li>
                        <li class="active">Trip</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Trip Details</b>
                            </h4>
                        </div>
                        <div class="panel-body no-padding-bottom">
                            <div class="row" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Bus No</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['bus_no']; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Route No</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['route_no']; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Pickup / Drop</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['pickup_drop']; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Distance</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['distance']. " km(s)"; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Trip Date</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['trip_date']; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Trip Time</label>
                                        <div class="col-lg-8">
                                            <?php echo $trip_fet['trip_time']; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if($trip_fet['end_status'] == 0){
                                    ?>
                                    <form class="form-horizontal" action="doaddtrip.php" method="post">
                                        <div class="row">
                                            <div class="col-md-2" style="float: right;">
                                                <input type="submit" value="END TRIP" class="btn btn-info form-control"/>
                                                <input type="hidden" value="<?php echo $trip_id; ?>" name="tripId"/>
                                                <input type="hidden" value="1" name="endtrip"/>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="row">
                                <h4 class="panel-title">
                                    <b>Trip Student Details</b>
                                </h4>
                                <?php
                                while($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
                                    $stop_name = $trip_stop_fet['stop_name'];
                                    $route_id = $trip_stop_fet['route_id'];

                                    $stud_sql = "select gen.*, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
                                    $stud_exe = mysql_query($stud_sql);
                                    ?>
                                    <h3><?php echo $stop_name; ?></h3>
                                    <form class="form-horizontal" action="doaddtripstudent.php" method="post" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                        <div class="row">
                                            <?php
                                    while ($stud_fet = mysql_fetch_assoc($stud_exe)) {
                                        ?>
                                        <div class="col-md-2">
                                            <input type="checkbox" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked';}?>/> <?php echo $stud_fet['student_name']?>
                                        </div>
                                    <?php
                                    }?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                            <input type="hidden" name="stop_name" value="<?php echo $stop_name; ?>" />
                                            <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>" />
                                            <input type="hidden" name="route_id" value="<?php echo $route_id; ?>" />

                                    <?php
                                    $existing_trip_stop_sql="SELECT * FROM `trip_stop` where trip_id='$trip_id' and trip_stop_name='$stop_name'";
                                    $existing_trip_stop_exe=mysql_query($existing_trip_stop_sql);
                                    $existing_trip_stop_cnt = mysql_num_rows($existing_trip_stop_exe);
                                    if($existing_trip_stop_cnt == 0){
                                        ?>
                                        <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                                    <?php
                                    }
                                    ?>
                                            </div>
                                        </div>
                                    </form>
                                    </hr>
                                    <?php
                                }?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /form horizontal -->
            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>