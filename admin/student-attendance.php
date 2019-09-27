<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

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

/* $section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
} */
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
                                <a href="students-all-absent-list.php"> <button type="button" class="form-control btn btn-info">Student Absent</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="student-attendance-report.php"> <button type="button" class="form-control btn btn-info">Student Report</button> </a>
                            </div>
							<div class="col-md-3">
                                <a href="teacher-attendance.php"> <button type="button" class="form-control btn btn-info">Teacher Attendance</button> </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="3" style="text-align: center;">Roll</th>
                                    <th colspan="6" style="text-align: center;">Present</th>
                                    <th colspan="6" style="text-align: center;">Absent</th>
                                </tr>
                                <tr>
                                    <th style="border-right: 1px solid black;">Class</th>
                                    <th>Boys</th>
                                    <th>Girls</th>
                                    <th style="border-right: 1px solid black;">Total</th>
                                    <th colspan="2" style="text-align: center;">Boys</th>
                                    <th colspan="2" style="text-align: center;">Girls</th>
                                    <th colspan="2" style="border-right: 1px solid black; text-align: center;">Total</th>
                                    <th colspan="2" style="text-align: center;">Boys</th>
                                    <th colspan="2" style="text-align: center;">Girls</th>
                                    <th colspan="2" style="text-align: center;">Total</th>
                                </tr>
                                <tr>
                                    <th style="border-right: 1px solid black;"></th>
                                    <th></th>
                                    <th></th>
                                    <th style="border-right: 1px solid black;"></th>
                                    <th>FN</th>
                                    <th>AN</th>
                                    <th>FN</th>
                                    <th>AN</th>
                                    <th>FN</th>
                                    <th style="border-right: 1px solid black;">AN</th>
                                    <th>FN</th>
                                    <th>AN</th>
                                    <th>FN</th>
                                    <th>AN</th>
                                    <th>FN</th>
                                    <th>AN</th>
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

                                        $fnattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and fn_entry_status=1"));
                                        $anattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and an_entry_status=1"));
                                        $hr = date('H');
                                        if ($hr < 12) {
                                            if($fnattendance_cnt > 0)
                                            {
                                                $attendance_row="red";
                                                $att_bold ="bold";
                                            }
                                            else{
                                                $attendance_row="black";
                                                $att_bold ="none";
                                            }
                                        }
                                        elseif ($hr > 12 && $hr < 24){
                                            if($anattendance_cnt > 0)
                                            {
                                                $attendance_row="red";
                                                $att_bold ="bold";
                                            }
                                            else{
                                                $attendance_row="black";
                                                $att_bold ="none";
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td style="border-right: 1px solid black;">
                                                <a href="students-absent-list.php?classId=<?php echo $classId;?>&sectionName=<?php echo $sectionName;?>" style="color:<?php echo $attendance_row; ?>; font-weight: <?php echo $att_bold; ?>" ><?php echo $className . " " . $sectionName; ?></a>
                                            </td>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1'"));
                                                echo $fet1['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1'"));
                                                echo $fet2['student_count'];
                                                ?>
                                            </td>
                                            <td style="border-right: 1px solid black;">
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1'"));
                                                echo $fet3['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                                                echo $fet1['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                                                echo $fet1['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                                                echo $fet2['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                                                echo $fet2['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                                                echo $fet3['student_count'];
                                                ?>
                                            </td>
                                            <td style="border-right: 1px solid black;">
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                                                echo $fet3['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $boys_absent_fn_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                                                echo $boys_absent_fn_fet['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $boys_absent_an_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                                                echo $boys_absent_an_fet['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $girls_absent_fn_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                                                echo $girls_absent_fn_fet['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $girls_absent_an_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                                                echo $girls_absent_an_fet['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fn_absent_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                                                echo $fn_absent_fet['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $an_absent_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                                                echo $an_absent_fet['student_count'];
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <th style="border-right: 1px solid black;">Grand Total</th>
                                    <td>
                                        <?php
                                        $grand_boy_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Male'"));
                                        echo $grand_boy_fet['boys_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $grand_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Female'"));
                                        echo $grand_girls_fet['girls_count'];
                                        ?>
                                    </td>
                                    <td style="border-right: 1px solid black;">
                                        <?php
                                        $grand_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1'"));
                                        echo $grand_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $present_boys_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date' and gen.gender='Male'"));
                                        echo $present_boys_fet['boys_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $present_boys_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date' and gen.gender='Male'"));
                                        echo $present_boys_fet['boys_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $present_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date' and gen.gender='Female'"));
                                        echo $present_girls_fet['girls_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $present_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date' and gen.gender='Female'"));
                                        echo $present_girls_fet['girls_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $present_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                                        echo $present_fet['student_count'];
                                        ?>
                                    </td>
                                    <td style="border-right: 1px solid black;">
                                        <?php
                                        $present_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                                        echo $present_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $boys_fn_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and gen.gender='Male' and att.attendance_date='$date'"));
                                        echo $boys_fn_absent_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $boys_an_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and gen.gender='Male' and att.attendance_date='$date'"));
                                        echo $boys_an_absent_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $girls_fn_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and gen.gender='Female' and att.attendance_date='$date'"));
                                        echo $girls_fn_absent_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $girls_an_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and gen.gender='Female' and att.attendance_date='$date'"));
                                        echo $girls_an_absent_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $absent_fn_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                                        echo $absent_fn_fet['student_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $absent_an_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                                        echo $absent_an_fet['student_count'];
                                        ?>
                                    </td>
                                </tr>
                                </tbody>

                            </table>

                            <?php
                            $hom_sql = "select * from attendance where attendance_date='$date' and admin_status='0'";
                            $hom_exe = mysql_query($hom_sql);
                            $hom_cnt = mysql_num_rows($hom_exe);
                            if($hom_cnt > 0){
                                ?>
                                <div class="row">
                                    <div class='col-sm-2'>
                                        <form action="dosendhomework.php" method="post">
                                            <input type="hidden" value="1" name="studAttendanceAdminStatus"/>
                                            <input type="submit" class="form-control btn btn-info" value="Send" onclick="return confirm('Do you want to send the student attendance?');"/>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
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
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 100
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
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
                    "bSort": false,
                    autoWidth: false,
                    dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Search:</span> _INPUT_',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                    },
                    lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                    displayLength: 1000
                });
            });
        });
    } );
</script>

</body>
</html>
