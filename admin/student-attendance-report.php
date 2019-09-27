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
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}

$grand_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1'"));
$boys_grand_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Male'"));
$girls_grand_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Female'"));

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

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Students
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Students</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Students</h3>
                        </div><!-- /.box-header -->

                        <div class="row">
                            <div class="col-md-3">
                                <a href="student-attendance.php"> <button type="button" class="form-control btn btn-info">Student Attendance</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="students-all-absent-list.php"> <button type="button" class="form-control btn btn-info">Student Absent</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="teacher-attendance.php"> <button type="button" class="form-control btn btn-info">Teacher Attendance</button> </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
							<form action="">
                            Choose Month :: <?php //echo $monthyear; ?>
							
							
<select name="monthyear" id="monthyear" onchange="this.form.submit()">
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
						 

                        <div class="box-body" id="predate" style="width:90%;">
                             
							 
                             <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>Class</th>
									<?php foreach($dates as $date_value) { $date_value_explode = explode("-",$date_value); ?>
                                    <th><?php echo $date_value_explode[2]; ?></th>
									<?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($class_master_results as $key => $value){
                                    $className = $value['class_name'];
                                    $classId = $value['id'];

                                    $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
                                    $section_exe=mysql_query($section_sql);
                                    $section_results = array();
                                    while($row = mysql_fetch_assoc($section_exe)) {
                                        array_push($section_results, $row);
                                    }

                                    foreach ($section_results as $sec_key => $sec_value) {
                                        $sectionName = $sec_value['section_name'];
                                        $sectionId = $sec_value['id'];
                                        ?>
                                        <tr>
                                            <td><a href="#students-list.php?classId=<?php echo $classId;?>&sectionName=<?php echo $sectionName;?>"><?php echo $className . " " . $sectionName; ?></td>
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
											$attendance_sql="SELECT COUNT(`id`) AS attendance_count FROM `attendance` WHERE `attendance_date`='$date_value' AND class_id='$classId' AND section_name='$sectionName'";
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
											<span style="color:green;"> <i class="fa fa-check"></i> </span>	
											<?php
											}
											}
											?>
											</td>
											<?php } ?>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                 
                                </tbody>

                            </table>
                     

					
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
        });
    } );
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
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-student-attendance.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
					displayLength: 10000,
					"scrollX": true,
					fixedColumns:   {
					leftColumns: 1
					}
				});
            });
        });
    } );
</script>

</body>
</html>
