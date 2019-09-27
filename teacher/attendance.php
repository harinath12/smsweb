<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

function isFuture($time)
{
    return (strtotime($time) > time());
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$csql = "SELECT id,class_name FROM `classes` WHERE class_name='$className'";
$cexe = mysql_query($csql);
$cfet = @mysql_fetch_array($cexe);
$classId = $cfet['id'];
?>

<?php
if(isset($_REQUEST['monthyear']))
{
$monthyear = $_REQUEST['monthyear'];	
}
else
{	
$monthyear = date("F Y");
}

$ts = strtotime($monthyear);

$fromdate = date('Y-m-01',$ts);
$todate = date('Y-m-t',$ts);
	
for($i = 1; $i <=  date('t',$ts); $i++)
{
// add the date to the dates array
$dates[] = date('Y',$ts) . "-" . date('m',$ts) . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
}


$stu_sql = "select * from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
where users.delete_status=1 and aca.class ='$classId' and aca.section_name='$sectionName'";

$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);

/* */

$current_date=date("Y-m-d");

$reopen_date = 0;
$reopen_sql = "SELECT *  FROM `calendar` WHERE `calendar_title` LIKE 'School Re-Opened' AND `calendar_status`=1 ORDER BY `calendar_start_date` ASC";
$reopen_exe = mysql_query($reopen_sql);
$reopen_cnt = @mysql_num_rows($reopen_exe);
if($reopen_cnt>0)
{
	$reopen_fet = mysql_fetch_array($reopen_exe);
	$reopen_date = $reopen_fet['calendar_start_date'];
}
//echo $reopen_date;
//echo "<br/>";

//HOLIDAYS COUNT
$holidays_date = 0;
$holidays_sql = "SELECT SUM(calendar_status) AS holidays FROM `calendar` WHERE `calendar_type`=1 AND `calendar_status`=1 ORDER BY `id` ASC ";
$holidays_exe = mysql_query($holidays_sql);
$holidays_cnt = @mysql_num_rows($holidays_exe);
if($holidays_cnt>0)
{
	$holidays_fet = mysql_fetch_array($holidays_exe);
	$holidays_date = $holidays_fet['holidays'];
}
//echo $holidays_date;
//echo "<br/>";

//SUNDAYS COUNT
/*
$start = new DateTime($reopen_date);
$end   = new DateTime($current_date);
$days = $start->diff($end, true)->days;
$sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
echo $sundays;
*/
$sunday_date = 0;
$start = new DateTime($reopen_date);
$end   = new DateTime($current_date);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($start, $interval, $end);
foreach ($period as $dt)
{
    if ($dt->format('N') == 7)
    {
        $sunday_date++;
    }
}
//echo $sunday_date;
//echo "<br/>";

//DATEDIFF COUNT
$date_diff_date = 0;
$current_date=date("Y-m-d");
$date_diff_sql = "SELECT DATEDIFF('$current_date','$reopen_date') AS `days`";
$date_diff_exe = mysql_query($date_diff_sql);
$date_diff_cnt = @mysql_num_rows($date_diff_exe);
if($date_diff_cnt>0)
{
	$date_diff_fet = mysql_fetch_array($date_diff_exe);
	$date_diff_date = $date_diff_fet['days'];
}
//echo $date_diff_date;
//echo "<br/>";

$noofholiday = $sunday_date+$holidays_date;
$noofworking = $date_diff_date-$noofholiday;
/* */
//echo $noofworking;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
    <?php include "head-inner.php"; ?>
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
                        <h4><i class="fa fa-th-large position-left"></i> ATTENDANCE</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Attendance</li>
                    </ul>

                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Attendance updated Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Attendance
                            </h4>
                        </div>
                        <div class="panel-body">

						<div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
								<a href="attendance-date.php">
                                    <button type="button" class="form-control btn btn-info" id="">Attendance By Date</button>
								</a>
                                </div>
                            </div>
						<div class="row"> 
                            <form action="attendance-list.php" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="className" value="<?php echo $className;?>" readonly/>
                                            <?php /* ?>
                                            <select class="form-control" name="className" id="classId">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <?php */ ?>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                            <?php /* ?>
                                            <select class="form-control sectionName" name="sectionName" id="sectionId">
                                                <option value="">Select Section</option>
                                            </select>
                                            <?php */ ?>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <div class="col-lg-2">
                                            <input type="submit" value="OK" class="btn btn-info form-control"/>
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6"></div>
                            </form>
						</div>
							
										<div class="row"> 
								
								<div class="col-md-12 col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-6">
										 <input type="text" value="Class :: <?php echo $className; ?>" class="form-control" readonly="" style="border: 0px;background: none;">
                                        </div>
										<div class="col-md-6">
                                         <input type="text" value="Section :: <?php echo $sectionName; ?>" class="form-control" readonly="" style="border: 0px;background: none;">
                                        </div>
                                    </div>
								</div> 
                                <div class="col-md-12 col-md-6">
                                    <div class="form-group">
										   
									<div class="col-md-4">
										
										<input type="text" value="Choose Month ::" class="form-control" readonly="" style="border: 0px;background: none;">
										</div>
										<div class="col-md-4">
										<form name="monthyearfrm" id="monthyearfrm" action="">
								
								<input name="classId" value="<?php echo $classId; ?>" type="hidden" />
								<input name="sectionName" value="<?php echo $sectionName; ?>" type="hidden" />
                            
								 <?php //echo $monthyear; ?>
							
								<select name="monthyear" id="monthyear" class="form-control">
									<option value="">SELECT</option>
									<option value="June 2019" <?php if($monthyear=="June 2019") { echo "selected"; } ?> >June 2019</option>
									<option value="July 2019" <?php if($monthyear=="July 2019") { echo "selected"; } ?>>July 2019</option>
									<option value="August 2019" <?php if($monthyear=="August 2019") { echo "selected"; } ?>>August 2019</option>
									<option value="September 2019" <?php if($monthyear=="September 2019") { echo "selected"; } ?>>September 2019</option>
									<option value="October 2019" <?php if($monthyear=="October 2019") { echo "selected"; } ?>>October 2019</option>
									<option value="November 2019" <?php if($monthyear=="November 2019") { echo "selected"; } ?>>November 2019</option>
									<option value="December 2019" <?php if($monthyear=="December 2019") { echo "selected"; } ?>>December 2019</option>
									<option value="January 2020" <?php if($monthyear=="January 2020") { echo "selected"; } ?>>January 2020</option>
									<option value="February 2020" <?php if($monthyear=="February 2020") { echo "selected"; } ?>>February 2020</option>
									<option value="March 2020" <?php if($monthyear=="March 2020") { echo "selected"; } ?>>March 2020</option>
									<option value="April 2020" <?php if($monthyear=="April 2020") { echo "selected"; } ?>>April 2020</option>
									<option value="May 2020" <?php if($monthyear=="May 2020") { echo "selected"; } ?>>May 2020</option>
								</select>
								</form>
										</div>
                                 
									<div class="col-md-4">
 										</div>
									</div>
								</div> 
								
                            </div>
							<div class="row">
								<div class="form-group">
								<div class="col-md-6">
								<b style="padding-left: 20px;">No.of Working Days # <?php echo $noofworking; ?></b>
								<br/><br/>
								</div>
								</div>
							</div>	
				
									<div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body" style="width:90%;">
                            <form method="post" action="#">
                               <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th class="hidden"><input type="checkbox" class="stuCheck" onClick="toggle(this)" /> Select All</th>
                                                <th>S.No.</th>
                                                <th>NAME</th>
                                                <th>A.NO.</th>
												<th>P.DAYS</th>
                                                <?php foreach($dates as $date_value) { $date_value_explode = explode("-",$date_value); ?>
												<th><?php echo $date_value_explode[2]; ?></th>
												<?php } ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i =1;
                                            while($stu_fet=mysql_fetch_array($stu_exe))
                                            {
                                                ?>
                                                <tr>
                                                    <td class="hidden"><input type="checkbox" class="stuCheck" name="student[]" value="<?php echo $stu_fet['user_id'] ?>"/> </td>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $stu_fet['student_name']; ?></td>
                                                    <td><?php echo $stu_fet['admission_number'] ?></td>
													<td>
													<?php 
													$user_id=$stu_fet['user_id'];	
													$forenoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `forenoon`='on'"));
													$afternoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `afternoon`='on'"));

													echo $days = ($forenoon[0]+$afternoon[0])/2;
													?>
													
													</td>
                                                    <?php foreach($dates as $date_value) { ?>
													<td>
													<?php //echo $date_value; ?>
													<?php
													if(isFuture($date_value)) { 
													?>
													<span style="color:blue;"> <i class="fa fa-minus"></i> </span>
													<?php
													} 
													else 
													{
													$user_id=$stu_fet['user_id'];	
													$attendance_sql="SELECT COUNT(`id`) AS attendance_count, forenoon, afternoon FROM `attendance` WHERE `attendance_date`='$date_value' AND class_id='$classId' AND section_name='$sectionName' AND user_id='$user_id'";
													$attendance_data=mysql_fetch_array(mysql_query($attendance_sql)); 
													if($attendance_data['attendance_count']==0)
													{
													?>
													<span style="color:red;"> <i class="fa fa-times"></i> </span>
													<?php
													}
													else
													{
													?>
														<?php
														if($attendance_data['forenoon']=='on' && $attendance_data['afternoon']=='on')
														{
														?>
														<span style="color:green;"> <i class="fa fa-check"></i> </span>	
														<br/>
														<span style="color:green;"> <i class="fa fa-check"></i> </span>	
														<?php
														} 
														else if($attendance_data['forenoon']=='on' && $attendance_data['afternoon']!='on')
														{
														?>
														<span style="color:green;"> <i class="fa fa-check"></i> </span>
														<br/>	
														<span style="color:red;"> <i class="fa fa-times"></i> </span>
														<?php
														} 
														else if($attendance_data['forenoon']!='on' && $attendance_data['afternoon']=='on')
														{
														?>
														<span style="color:green;"> <i class="fa fa-times"></i> </span>
														<br/>	
														<span style="color:red;"> <i class="fa fa-check"></i> </span>
														<?php 
														}
														else
														{
														?>
														<span style="color:red;"> <i class="fa fa-times"></i> </span>
														<br/>	
														<span style="color:red;"> <i class="fa fa-times"></i> </span>
														<?php
														}
														?>
													<?php
													}
													}
													?>
													</td>
													<?php } ?>
                                                     
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </span>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
       
	   
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <?php include "footer.php"; ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
<script>
    $(function() {
        $('#classId').change(function() {
            $('#sectionId').empty();
            $.get('sectionscript.php', {region: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionId").html(list);
            });
        });
    });
</script>


<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({
			displayLength: 10000,
			"scrollX": true,
			fixedColumns:   {
            leftColumns: 1
            },
			columnDefs: [
                    {
                        width: '20%',
                        targets: 0,
                    }
            ]
        });
    } );
</script>
<!-- page script -->

<script>
    $( function() {
        $( "#monthyear").on( "change", function() {
            
			$("#monthyearfrm").submit();
            
        });
    } );
</script>
</body>
</html>