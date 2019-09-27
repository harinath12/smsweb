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

$student_sql = "select c.class_name, aca.section_name,aca.class, gen.student_name, gen.admission_number,gen.user_id from student_academic as aca
left join student_general as gen on gen.user_id = aca.user_id
left join classes as c on c.id = aca.class
where gen.user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$stu_fet = mysql_fetch_assoc($student_exe);
$classId = $stu_fet['class'];
$className = $stu_fet['class_name'];
$sectionName = $stu_fet['section_name'];



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

/* */
$forenoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `forenoon`='on'"));
$afternoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `afternoon`='on'"));
$days = ($forenoon[0]+$afternoon[0])/2;
/* */
//echo $days;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Parent</title>
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
                    <div class="page-title hidden">
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
                            <h4 class="panel-title hidden">
                                Attendance
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <?php
                                $attendance_sql="SELECT COUNT(`id`) AS attendance_count, forenoon, afternoon FROM `attendance` WHERE `attendance_date`='$date' AND class_id='$classId' AND section_name='$sectionName' AND user_id='$user_id'";
                                $attendance_fet=mysql_fetch_array(mysql_query($attendance_sql));
                                if($attendance_fet['attendance_count'] > 0){
                                    if($attendance_fet['forenoon'] == 'on' || $attendance_fet['afternoon'] == 'on'){
                                    ?>
                                        <p style="text-align: center; color: blue;"><b><?php echo $stu_fet['student_name']; ?></b> is present today.</p>
                                <?php
                                }
                                else{
                                    ?>
                                    <p style="text-align: center; color: red;"><b><?php echo $stu_fet['student_name']; ?></b> is absent today.</p>
                                <?php
                                }
                                }
                                ?>

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
                                    <div class="form-group hidden">

                                        <div class="col-md-4">

                                            <input type="text" value="Choose Month ::" class="form-control" readonly="" style="border: 0px;background: none;">
                                        </div>
                                        <div class="col-md-4">
                                            <form name="monthyearfrm" id="monthyearfrm" action="" class="">

                                                <input name="classId" value="<?php echo $classId; ?>" type="hidden" />
                                                <input name="sectionName" value="<?php echo $sectionName; ?>" type="hidden" />

                                                <?php //echo $monthyear; ?>

                                                <select name="monthyear" id="monthyear" class="form-control">
                                                    <option value="">SELECT</option>
                                                    <option value="June 2018" <?php if($monthyear=="June 2018") { echo "selected"; } ?> >June 2018</option>
                                                    <option value="July 2018" <?php if($monthyear=="July 2018") { echo "selected"; } ?>>July 2018</option>
                                                    <option value="August 2018" <?php if($monthyear=="August 2018") { echo "selected"; } ?>>August 2018</option>
                                                    <option value="September 2018" <?php if($monthyear=="September 2018") { echo "selected"; } ?>>September 2018</option>
                                                    <option value="October 2018" <?php if($monthyear=="October 2018") { echo "selected"; } ?>>October 2018</option>
                                                    <option value="November 2018" <?php if($monthyear=="November 2018") { echo "selected"; } ?>>November 2018</option>
                                                    <option value="December 2018" <?php if($monthyear=="December 2018") { echo "selected"; } ?>>December 2018</option>
                                                    <option value="January 2019" <?php if($monthyear=="January 2019") { echo "selected"; } ?>>January 2019</option>
                                                    <option value="February 2019" <?php if($monthyear=="February 2019") { echo "selected"; } ?>>February 2019</option>
                                                    <option value="March 2019" <?php if($monthyear=="March 2019") { echo "selected"; } ?>>March 2019</option>
                                                    <option value="April 2019" <?php if($monthyear=="April 2019") { echo "selected"; } ?>>April 2019</option>
                                                    <option value="May 2019" <?php if($monthyear=="May 2019") { echo "selected"; } ?>>May 2019</option>
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
								<div class="col-md-6">
								<b style="padding-left: 20px;">No.of Present Days # <?php echo $days; ?></b>
								<br/><br/>
								</div>
								</div>
							</div>	

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box" style="min-height: 600px;">
                                        <div class="box-body" style="width:90%;">
										
										<?php /* ?>
                                            <form method="post" action="#">
                               <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th class="hidden"><input type="checkbox" class="stuCheck" onClick="toggle(this)" /> Select All</th>
                                                <th>FN/AN</th>
                                                <?php foreach($dates as $date_value) { $date_value_explode = explode("-",$date_value); ?>
                                                    <th><?php echo $date_value_explode[2]; ?></th>
                                                <?php } ?>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td class="hidden"><input type="checkbox" class="stuCheck" name="student[]" value="<?php echo $stu_fet['user_id'] ?>"/> </td>
                                                    <td><?php echo "FN"; ?></td>
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
                                                                    if($attendance_data['forenoon']=='on')
                                                                    {
                                                                        ?>
                                                                        <span style="color:green;"> <i class="fa fa-check"></i> </span>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
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

                                                <tr>
                                                    <td class="hidden"><input type="checkbox" class="stuCheck" name="student[]" value="<?php echo $stu_fet['user_id'] ?>"/> </td>
                                                    <td><?php echo "AN"; ?></td>
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
                                                                $an_attendance_sql="SELECT COUNT(`id`) AS attendance_count, forenoon, afternoon FROM `attendance` WHERE `attendance_date`='$date_value' AND class_id='$classId' AND section_name='$sectionName' AND user_id='$user_id'";
                                                                $an_attendance_data=mysql_fetch_array(mysql_query($an_attendance_sql));
                                                                if($an_attendance_data['attendance_count']==0)
                                                                {
                                                                    ?>
                                                                    <span style="color:red;"> <i class="fa fa-times"></i> </span>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <?php
                                                                    if($an_attendance_data['afternoon']=='on')
                                                                    {
                                                                        ?>
                                                                        <span style="color:green;"> <i class="fa fa-check"></i> </span>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
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

                                            </tbody>
                                        </table>
                                    </span>
                                            </form>
										<?php */ ?>	
											
						<?php  //include "../fullcalendar/demos/admin-index.php"; ?>
							<iframe src="http://www.srivinayagaschoolpennagaram.com/fullcalendar/demos/parent-attendance.php?user_id=<?php echo $user_id; ?>" width="100%" height="800px" border="0" style="border: none;" ></iframe>
							
											http://www.srivinayagaschoolpennagaram.com/fullcalendar/demos/
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