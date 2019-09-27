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
$classId=$_GET['classId'];
$sectionName=$_GET['sectionName'];

$csql = "SELECT class_name FROM `classes` WHERE id='$classId'";
$cexe = mysql_query($csql);
$cfet = @mysql_fetch_array($cexe);

$className = $cfet['class_name'];

$stu_sql = "select * from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
where users.delete_status=1 and aca.class ='$classId' and aca.section_name='$sectionName'";

$stu_sql = "select gen.*, att.forenoon, att.afternoon from student_general as gen
LEFT JOIN attendance as att on att.user_id = gen.user_id
LEFT JOIN student_academic as aca on aca.user_id = gen.user_id
LEFT JOIN users as usr on usr.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and (att.forenoon='off' or att.afternoon='off') and att.attendance_date='$date'";

$stu_sql = "select gen.*, att.forenoon, att.afternoon from student_general as gen
LEFT JOIN attendance as att on att.user_id = gen.user_id
LEFT JOIN student_academic as aca on aca.user_id = gen.user_id
LEFT JOIN users as usr on usr.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.attendance_date='$date'
order by att.forenoon asc";


$stu_sql = "select * from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
where users.delete_status=1 and aca.class ='$classId' and aca.section_name='$sectionName'";

$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);
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

//var_dump($dates);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Student List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="student-attendance.php">Student Attendance</a></li>

                <li class="active">Student List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            
							<div class="row">
                            <div class="col-md-3">
                                <a href="student-attendance.php"> <button type="button" class="form-control btn btn-info">Student Attendance</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="student-attendance-report.php"> <button type="button" class="form-control btn btn-info">Student Report</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="teacher-attendance.php"> <button type="button" class="form-control btn btn-info">Teacher Attendance</button> </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
								
                            </div>
							<br/><br/><br/>
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
										<div class="col-md-6">
										<a href="students-absent-list.php?classId=<?php echo $classId; ?>&sectionName=<?php echo $sectionName; ?>"> <button type="button" class="form-control btn btn-info"><?php echo $className; ?> - <?php echo $sectionName; ?> Student Absents</button> </a>
										</div>
										<div class="col-md-6">
										<form name="monthyearfrm" id="monthyearfrm" action="">
								
								<input name="classId" value="<?php echo $classId; ?>" type="hidden" />
								<input name="sectionName" value="<?php echo $sectionName; ?>" type="hidden" />
                            
								Choose Month :: <?php //echo $monthyear; ?>
							
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
														} else if($attendance_data['forenoon']=='on' || $attendance_data['afternoon']=='on')
														{
														?>
														<span style="color:green;"> <i class="fa fa-check"></i> </span>
														<br/>	
														<span style="color:red;"> <i class="fa fa-times"></i> </span>
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
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

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