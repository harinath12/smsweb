<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$vehicle_sql="SELECT * FROM `vehicles` 
INNER join routes ON routes.route_bus_id=vehicles.id
WHERE vehicle_status=1
AND route_driver_id=$user_id";

$vehicle_exe=mysql_query($vehicle_sql);
$vehicle_results = array();
while($row = mysql_fetch_assoc($vehicle_exe)) {
    array_push($vehicle_results, $row);
}

$route_sql="SELECT * FROM `routes` 
WHERE route_status=1
AND route_driver_id=$user_id";
$route_exe=mysql_query($route_sql);
$route_results = array();
while($row = mysql_fetch_assoc($route_exe)) {
    array_push($route_results, $row);
}

$end_km_readings = "";
$bus_no = $vehicle_results[0]['bus_no'];

$trip_sql="SELECT end_km_readings FROM `trip` WHERE `bus_no`='$bus_no' AND `end_km_readings`!='' ORDER BY `id` DESC";
$trip_exe=mysql_query($trip_sql);
$trip_cnt = @mysql_num_rows($trip_exe);
if($trip_cnt>0)
{
	$trip_fetch = mysql_fetch_assoc($trip_exe);
	$end_km_readings = $trip_fetch['end_km_readings'];
}
$end_km_readings = "";
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
        .req{
            color: red;
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
                        <h4><i class="fa fa-th-large position-left"></i> CHOOSE TRIP</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="trip-list.php">Trip List</a></li>
                        <li class="active">Choose Trip</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doaddtrip.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Trip Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Bus No <span class="req"> *</span> </label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="bus_no" id="bus_no" required>
                                                    
                                                    <?php
                                                    foreach($vehicle_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['bus_registration_no']; ?>"><?php echo $value['bus_registration_no']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Route No <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="route_no" id="route_no" required>
                                                    
                                                    <?php
                                                    foreach($route_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['route_no']; ?>"><?php echo $value['route_no']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Pickup / Drop</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="pickup_drop" id="pickup_drop">
                                                    <option value="">Select Pickup/Drop</option>
                                                    <option value="pickup">Pick Up</option>
                                                    <option value="drop">Drop</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Kilometer Readings</label>
                                            <div class="col-lg-8">
                                                <input type="number" step="0.01" min="0" class="form-control" name="distance" value="<?php echo $end_km_readings; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <input type="submit" value="START" class="btn btn-info form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
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