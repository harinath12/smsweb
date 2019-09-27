<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

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

$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);
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
										<a href="student-attendance-class-report.php?classId=<?php echo $classId; ?>&sectionName=<?php echo $sectionName; ?>"> <button type="button" class="form-control btn btn-info"><?php echo $className; ?> - <?php echo $sectionName; ?> Student Report</button> </a>
										</div>
										<div class="col-md-6">
										</div>
                                    </div>
								</div> 
								
                            </div>
				<div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body">
                            <form method="post" action="#">
                               <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th class="hidden"><input type="checkbox" class="stuCheck" onClick="toggle(this)" /> Select All</th>
                                                <th>S.No.</th>
                                                <th>NAME</th>
                                                <th>ADMISSION NO.</th>
                                                <th>MOBILE</th>
												<th>CITY</th>
                                                <th>FN</th>
                                                <th>AN</th>
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
                                                    <td><?php echo $stu_fet['mobile']; ?></td>
													<td><?php echo $stu_fet['city']; ?></td>
                                                    <td>
                                                        <?php
                                                        if($stu_fet['forenoon'] == 'off')
                                                        { echo 'Absent';
                                                        }
                                                        if($stu_fet['forenoon'] == 'on')
                                                        { echo 'Present';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($stu_fet['afternoon'] == 'off')
                                                        { echo 'Absent';
                                                        }
                                                        if($stu_fet['afternoon'] == 'on')
                                                        { echo 'Present';
                                                        }
                                                        ?>
                                                    </td>
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
			displayLength: 10000
        });
    } );
</script>
<!-- page script -->

</body>
</html>