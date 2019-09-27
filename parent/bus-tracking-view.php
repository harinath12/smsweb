<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");
$dat= date("d-m-Y");

$studtrip_sql = mysql_query("SELECT r.*, rou.route_no, gen.user_id, t.id as tripid FROM route_stop AS r
LEFT JOIN student_general AS gen ON gen.stop_from =r.stop_name
left join routes as rou on rou.id = r.route_id
left join trip as t on t.route_no = rou.route_no
WHERE gen.user_id='$user_id' and t.trip_status='1' and t.trip_date='$dat' ORDER BY t.id DESC");
$stutrip_fet = mysql_fetch_array($studtrip_sql);
$routeno = $stutrip_fet['route_no'];
$trip_id = $stutrip_fet['tripid'];

$trip_sql="SELECT * FROM `trip` where id='$trip_id'";
$trip_exe=mysql_query($trip_sql);
$trip_fet = mysql_fetch_assoc($trip_exe);
$route_no = $trip_fet['route_no'];
$pickup_drop = $trip_fet['pickup_drop'];

if($pickup_drop=="pickup") {
$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id, ts.trip_time as rtrip_time, ts.trip_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 LEFT JOIN trip_stop as ts on ts.trip_stop_name = rs.stop_name and ts.trip_id = '$trip_id'
 where route_no='$route_no' ORDER BY rs.route_order ASC";
 } else if($pickup_drop=="drop") {
$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id, ts.trip_time as rtrip_time, ts.trip_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 LEFT JOIN trip_stop as ts on ts.trip_stop_name = rs.stop_name and ts.trip_id = '$trip_id'
 where route_no='$route_no' ORDER BY rs.route_order DESC";
	 
 }	 
$trip_stop_exe=mysql_query($trip_stop_sql);

$page = $_SERVER['PHP_SELF'];
$sec = "10";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <title>SMS - Parent</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> Transport</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Transport</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">
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

                                    </div>

                                    <div class="col-md-6"> 

                                        <div class="form-group row">
                                            <label class="control-label col-lg-4">Pickup / Drop</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['pickup_drop']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-lg-4">Trip Date and Started Time</label>
                                            <div class="col-lg-8">
                                                <?php echo $trip_fet['trip_date']; ?> :: <?php echo $trip_fet['trip_time']; ?>
                                            </div>
                                        </div>
										
                                       <?php if($trip_fet['end_status'] == 1){
                                            ?>
                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Trip End Time</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['trip_end_time']; ?><br/>
													Bus reached School / பேருந்து பள்ளிக்கு வந்தது அடைந்தது
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
									$s=0;
                                    while($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
                                        $stop_name = $trip_stop_fet['stop_name'];
                                        $route_id = $trip_stop_fet['route_id'];

                                        $stud_sql = "select gen.*, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
                                        $stud_exe = mysql_query($stud_sql);
										$stud_cnt = @mysql_num_rows($stud_exe);
										//print_r($stud_fet);
                                        ?>
										<div class="row">
										<div class="col-md-4">
											<h3><?php echo $stop_name; ?></h3>
										</div>
										<div class="col-md-6">
											<h3>
											<?php if($trip_stop_fet['rtrip_time'] != null){?>
												<span style="font-size: 14px;">[ <b>Time:</b><?php echo $trip_stop_fet['rtrip_time'];?> ] <br/> Bus moved to next stopping / அடுத்த நிறுத்தத்திற்கு பேருந்து புறப்பட்டது </span>
											<?php } else { ?>
												<?php if($s==0) { ?>
												<span style="font-size: 14px;">On the Way / பேருந்து வழியில் உள்ளது</span>
												<?php $s=1; } else { ?>
												<?php } ?>
											<?php } ?>
												
											<div>
												 <?php while ($stud_fet = mysql_fetch_assoc($stud_exe)) { ?>
											     <?php if($user_id==$stud_fet['user_id']) { ?>
                                                 <?php //echo $stud_fet['student_name']?> 
												 <?php if($stud_fet['trip_student_status'] == '1') { ?>
												 
													 <?php if($pickup_drop=="pickup") { ?>
													 <p style="color:blue;"> Pickup Time</p>
													 
													 <!--
													 <p style="color:blue;"> Your child pickup by school bus / உங்கள் குழந்தை பள்ளி பஸ்சில் புறப்பட்டார் </p>
													 -->
													 <?php } else if($pickup_drop=="drop") {  ?>
													 <p style="color:blue;"> Drop Time</p>
													 <!--
													 <p style="color:blue;"> Your child drop by school bus / உங்கள் குழந்தை வீட்டுக்குத் திரும்பினார் </p>
													 -->
													 <?php } ?>
												 
												 <?php } else if($stud_fet['trip_student_status'] == '0') {  ?>
													 <?php if($pickup_drop=="pickup") { ?>
													 <p style="color:red;"> Your child not pickup by school bus / உங்கள் குழந்தை பள்ளி பஸ்சில் வரவில்லை </p>
													 <?php } else if($pickup_drop=="drop") {  ?>
													 <p style="color:red;"> Your child not drop by school bus / உங்கள் குழந்தை வீட்டுக்கு வரவில்லை </p>
													 <?php } ?>
													 
												 
												 <?php } else { ?>
												 <?php if($pickup_drop=="pickup") { ?>
												 <p style="color:green;"> Please get ready / தயவுசெய்து உங்கள் குழந்தையை தயார் செய்யவும் </p>
												 <?php } else if($pickup_drop=="drop") {  ?>
												 <p style="color:green;"> Please get ready pick up your child / தயவுசெய்து உங்கள் குழந்தையை அழைத்துச் செல்ல தயாராகுங்கள் </p>
												 <?php } ?>
												 
												 <?php } ?>
												 <?php } ?>
												 <?php } ?>
											</div>
                                        	
											</h3>
										</div>
										<div class="col-md-2">
									<?php /* * / ?>
                                    <form class="form-horizontal" action="" method="post" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
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
                                    </form>
									<?php / * */ ?>
										</div>
										</div>
                                    </hr>
                                    <?php
                                    }?>

                                    </br>
                                </div>
                            </div>
                        </div>


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.content -->
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<script>
    $(function() {
        $('.examName').change(function() {
            var examid = $('.examName').val();

            $.ajax({
                url: "ajaxstudentmarkresult.php?examid=" + examid,
                context: document.body
            }).done(function(response) {
                $('#studentlist').html(response);
            });
        });
    });
</script><!-- /page container -->
</body>
</html>