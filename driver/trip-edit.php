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
$trip_fet = mysql_fetch_assoc($trip_exe);
$pickup_drop = $trip_fet['pickup_drop'];
$route_no = $trip_fet['route_no'];

if($pickup_drop=="pickup") {
$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 where route_no='$route_no' ORDER BY rs.route_order ASC";
} else if($pickup_drop=="drop") {
$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 where route_no='$route_no' ORDER BY rs.route_order DESC";
}
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
                        <h4><i class="fa fa-th-large position-left"></i> TRIP EDIT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="trip-list.php">Trip List</a></li>
                        <li class="active">Trip Edit</li>
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

                                    <?php if($trip_fet['end_status'] == 1){
                                        ?>
                                        <div class="form-group row">
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
                                    <div class="form-group row">
                                        <label class="control-label col-lg-4">Kilometer Readings</label>
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

							
							<?php
							if($pickup_drop=="drop") {
							
							$route_sql= "SELECT * FROM `routes` WHERE route_no= '$route_no'";
							$route_exe=mysql_query($route_sql);
							$route_cnt=@mysql_num_rows($route_exe);
							$route_fet=mysql_fetch_assoc($route_exe);
							
							
							$drop_check_sql= "SELECT * FROM `trip_student` WHERE trip_id= '$trip_id'";
							$drop_check_exe=mysql_query($drop_check_sql);
							$drop_check_cnt=@mysql_num_rows($drop_check_exe);
							$drop_check_fet=mysql_fetch_assoc($drop_check_exe);
							
								if($drop_check_cnt==0) {
									
									
							?>
							<div>
							INSERT
							</div>
							<?php 
								}
							}
							?>
                            <div class="row">
                                <h4 class="panel-title">
                                    <b>Trip Student Details</b>
                                </h4>
                                <?php
								$sn=0;
                                while($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
									$sn++;
									$stop_name = $trip_stop_fet['stop_name'];
                                    $route_id = $trip_stop_fet['route_id'];

                                    $stud_sql = "select gen.*, cl.class_name,sa.section_name, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
LEFT JOIN `classes` AS cl on sa.class = cl.id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
                                    $stud_exe = mysql_query($stud_sql);
                                    ?>
										
                                    <form class="form-horizontal" action="doaddtripstudent.php" method="post" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                    
<h3><?php echo $stop_name; ?> -- 
<input type="checkbox" onClick="toggle(this,'student_id<?php echo $sn; ?>')" /> <span style="font-size: 15px;font-weight: bold;">Check All / Uncheck All</span>
</h3>	
                                    
									<div class="row">
                                            <?php
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
												<input type="checkbox" class="student_id<?php echo $sn; ?>" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked'; } ?>/> 
												</div>
												<div style="width:auto;float:left;">
												
												<span class="media-heading text-semibold"><?php echo $stud_fet['student_name']?></span>
												<div class="text-size-mini text-muted">( <?php echo $stud_fet['admission_number']; ?> ) <?php echo $stud_fet['class_name']." ".$stud_fet['section_name']; ?></div>
												</div>
											</div>
																						
											
                                        </div>
                                    <?php
                                    }?>
                                        </div>
										 <?php
                                    $existing_trip_stop_sql="SELECT * FROM `trip_stop` where trip_id='$trip_id' and trip_stop_name='$stop_name'";
                                    $existing_trip_stop_exe=mysql_query($existing_trip_stop_sql);
                                    $existing_trip_stop_cnt = mysql_num_rows($existing_trip_stop_exe);
                                    if($existing_trip_stop_cnt == 0 && $trip_fet['end_status'] == 0){
                                        ?>
										<?php										
										$student_sql = "SELECT sg.user_id,sg.admission_number,sg.emis_number,sg.student_name,sg.photo FROM `student_general` AS sg LEFT JOIN student_academic AS sa ON sa.user_id = sg.user_id ORDER BY `student_name` ASC";
										/*
										$student_sql = "select gen.*, cl.class_name,sa.section_name, ts.trip_student_status, ts.trip_id from student_general as gen
										LEFT JOIN users as usr on usr.id = gen.user_id
										LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
										LEFT JOIN `classes` AS cl on sa.class = cl.id
										WHERE usr.delete_status='1'
										GROUP BY cl.class_name
										";
										*/
										$student_exe = mysql_query($student_sql);
										?>
										 <div class="form-group fill-row<?php echo $sn; ?>" style="padding:20px;">
                                                <div class="row">
                                                    <div class="col-lg-5">
													<select name="extra_student_id[]" class="chosen-select" multiple>
													<?php while($student_fet = mysql_fetch_array($student_exe)) { ?>
													  <option value="<?php echo $student_fet['user_id']; ?>" style="background-image:url(../<?php echo $student_fet['photo']; ?>);"><?php echo $student_fet['student_name']; ?> ( <?php echo $student_fet['admission_number']; ?> )</option>
													<?php } ?>
													</select>
													</div>
                                                </div>
                                        </div>
									<?php } else { ?>
									
									
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
									<?php } ?>
                                        <div class="row">
                                            <div class="col-md-2">
                                            <input type="hidden" name="stop_name" value="<?php echo $stop_name; ?>" />
                                            <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>" />
                                            <input type="hidden" name="route_id" value="<?php echo $route_id; ?>" />

                                    <?php
                                    $existing_trip_stop_sql="SELECT * FROM `trip_stop` where trip_id='$trip_id' and trip_stop_name='$stop_name'";
                                    $existing_trip_stop_exe=mysql_query($existing_trip_stop_sql);
                                    $existing_trip_stop_cnt = mysql_num_rows($existing_trip_stop_exe);
                                    if($existing_trip_stop_cnt == 0 && $trip_fet['end_status'] == 0){
                                        ?>
                                        <input type="submit" value="SEND" class="btn btn-info form-control"/>
                                    <?php
                                    }
                                    ?>
                                            </div>
                                        </div>
                                    </form>
                                    </hr>
									 

                                    <?php
                                }?>

                                </br>
                                <?php
                                if($trip_fet['end_status'] == 0){
                                    ?>
                                    <span id="endtripbtn">
                                        <div class="row">
                                            <div class="col-md-2" style="float: right;" id="endTrip">
                                                <input type="submit" value="END TRIP" class="btn btn-info form-control" id="endtrip"/>
                                            </div>
                                        </div>
                                    </span>

                                    <span id="endtripfn" style="display: none;">
                                    <form class="form-horizontal" action="doaddtrip.php" method="post">
                                        <div class="row">
                                            <label class="control-label col-lg-2"><b>Kilometer Readings</b></label>
                                            <div class="col-lg-2">
                                               <input type="number" step="0.01" min="0" name="endreadings" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="submit" value="SEND" class="btn btn-info form-control"/>
                                            </div>
                                        </div>

                                            <input type="hidden" value="<?php echo $trip_id; ?>" name="tripId"/>
                                            <input type="hidden" value="1" name="endtrip"/>
                                    </form>
                                    </span>

                                <?php
                                } ?>
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
<link rel="stylesheet" href="assets/chosen/docsupport/styleX.css">
<link rel="stylesheet" href="assets/chosen/docsupport/prismX.css">
<link rel="stylesheet" href="assets/chosen/chosen.css">

<script src="assets/chosen/docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="assets/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="assets/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

 
<script language="JavaScript">
function toggle(source,classname) {
  checkboxes = document.getElementsByClassName(classname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<script>
    $(function() {
        $('#endtrip').click(function() {
            $('#endtripbtn').hide();
            $('#endtripfn').show();
        });
    });
</script>
</body>
</html>