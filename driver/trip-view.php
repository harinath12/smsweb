<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['id']))
{
    $trip_id = $_REQUEST['id'];
}
else{
   exit;
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$trip_sql = "select * from trip where id='$trip_id'";
$trip_exe = mysql_query($trip_sql);
$trip_fet = mysql_fetch_assoc($trip_exe);
$route_no = $trip_fet['route_no'];

$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 where route_no='$route_no' ORDER BY rs.route_order ASC";
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
                        <h4><i class="fa fa-th-large position-left"></i> TRIP VIEW</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="trip-list.php">Trip List</a></li>
                        <li class="active">Trip View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="#" method="post">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <b>Trip Details</b>
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="row"  style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Bus No</label>
                                            <div class="col-lg-8">
                                               <?php echo $trip_fet['bus_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Route No</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['route_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Pickup / Drop</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['pickup_drop']; ?>
                                            </div>
                                        </div>

                                        <?php if($trip_fet['end_status'] == 1){
                                            ?>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Trip End Time</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['trip_end_time']; ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Kilometer Readings</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['distance'] . " km(s)"; ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Trip Date</label>
                                            <div class="col-lg-8">
                                                <?php //echo $trip_fet['trip_date']; ?>
												<?php echo date_display($trip_fet['trip_date']); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Trip Time</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['trip_time']; ?>
                                            </div>
                                        </div>

                                        <?php if($trip_fet['end_status'] == 1){
                                            ?>
                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Trip End Readings</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['end_km_readings'] . " km(s)"; ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="panel-title">
                                        <b>Trip Student Details</b>
                                    </h4>
                                    <?php
                                    while($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
                                        $stop_name = $trip_stop_fet['stop_name'];
                                        $route_id = $trip_stop_fet['route_id'];
										
										
										$trip_time_sql="SELECT * FROM `trip_stop` WHERE `trip_stop_name`='$stop_name' AND  trip_id='$trip_id'";
										$trip_time_exe=mysql_query($trip_time_sql);
										$trip_time_fet=mysql_fetch_assoc($trip_time_exe);
										
										
										
/*
                                        $stud_sql = "select gen.*, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
*/

                                    $stud_sql = "select gen.*, cl.class_name,sa.section_name, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
LEFT JOIN `classes` AS cl on sa.class = cl.id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
                                        $stud_exe = mysql_query($stud_sql);
                                        ?>
										
										
                                    <h3><?php echo $stop_name; ?> - [ <b>Time:</b><?php echo $trip_time_fet['trip_time'];?> ]</h3>
                                    <form class="form-horizontal" action="#" method="post" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                        <div class="row">
                                            <?php
                                        while ($stud_fet = mysql_fetch_assoc($stud_exe)) {
                                            ?>
                                          <?php if($stud_fet['trip_student_status'] == '1'){  ?>

										<div class="col-md-2">
                                            <div class="media">
											<a href="dashboard.php" class="media-left">
												<img src=" <?php echo '../admin/' . $stud_fet['photo']; ?>" alt="<?php echo $stud_fet['student_name']?>" title="<?php echo $stud_fet['student_name']?>" class="" style="width:120px;height:120px;">
											</a>
											</div>
 											<div class="media-body">
												<div style="width:20px;float:left;">
												<input type="checkbox" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked'; } ?>/> 
												</div>
												<div style="width:auto;float:left;">
												
												<span class="media-heading text-semibold"><?php echo $stud_fet['student_name']?></span>
												<div class="text-size-mini text-muted">( <?php echo $stud_fet['admission_number']; ?> ) <?php echo $stud_fet['class_name']." ".$stud_fet['section_name']; ?></div>
												</div>
											</div>
										</div>
										  <?php } ?>
										<?php /* ?>
										  <div class="col-md-2">
                                                <input type="checkbox" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked';}?> readonly/> <?php echo $stud_fet['student_name']?>
                                          </div>
										<?php */ ?>
                                        <?php
                                        }?>
                                        </div>
                                    </form>
									
									<div class="row">
                                    Extra Student <br/>
									<?php
                                    $stud_sql = "select gen.*, cl.class_name,sa.section_name, ts.trip_student_status, ts.trip_id from student_general as gen
									LEFT JOIN users as usr on usr.id = gen.user_id
									LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
									LEFT JOIN `classes` AS cl on sa.class = cl.id
									LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
									LEFT JOIN `trip_stop` AS tst on ts.trip_id = tst.trip_id
									WHERE usr.delete_status='1' and tst.trip_stop_name = '$stop_name' and ts.temp_status = 1 and ts.stop_id = '$stop_name'";
									$stud_exe=mysql_query($stud_sql);
									while ($stud_fet = mysql_fetch_assoc($stud_exe)) {
                                        ?>
                                        <div class="col-md-3">
                                            <div class="media">
											<a href="dashboard.php" class="media-left">
												<img src=" <?php echo '../admin/' . $stud_fet['photo']; ?>" alt="<?php echo $stud_fet['student_name']?>" title="<?php echo $stud_fet['student_name']?>" class="" style="width:120px;height:120px;">
											</a>
											</div>
 											<div class="media-body">
												<div style="width:20px;float:left;">
												<input type="checkbox" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked'; } ?>/> 
												</div>
												<div style="width:auto;float:left;">
												
												<span class="media-heading text-semibold"><?php echo $stud_fet['student_name']?></span>
												<div class="text-size-mini text-muted">( <?php echo $stud_fet['admission_number']; ?> ) <?php echo $stud_fet['class_name']." ".$stud_fet['section_name']; ?></div>
												</div>
											</div>
																						
											
                                        </div>
                                    <?php
                                    }
									?>
									
                                        </div>
                                    </hr>
                                    <?php
                                    }?>
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