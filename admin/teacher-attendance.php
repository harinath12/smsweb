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

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}
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
                Teacher Attendance
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Teacher Attendance</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Teacher Attendance</h3>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="student-attendance.php"> <button type="button" class="form-control btn btn-info">Student Attendance</button> </a>
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
                        </div><!-- /.box-header -->
                        <div class="box-body" id="predate">
                            <?php
                            $present_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as present_count FROM teacher_general AS si
RIGHT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date' and (att.forenoon='on' or att.afternoon='on')
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));

                            $absent_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as absent_count FROM teacher_general AS si
RIGHT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date' and att.forenoon='off' and att.afternoon='off'
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));

                            $grand_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as grand_count FROM teacher_general AS si
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));
                            ?>

                            <div class="row">
                                <div class="col-md-3"><b>Roll:</b></div>
                                <div class="col-md-3"><?php echo $grand_fet['grand_count']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Present:</b></div>
                                <div class="col-md-3"><?php echo $present_fet['present_count']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Absent:</b></div>
                                <div class="col-md-3"><?php echo $absent_fet['absent_count']; ?></div>
                            </div>

                            </br>
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>Teacher Name</th>
                                    <th>Class</th>
                                    <th>Forenoon</th>
                                    <th>Afternoon</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $attendance_sql = "SELECT users.name, att.*, aca.class_teacher  FROM teacher_general AS si
LEFT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date'
LEFT JOIN teacher_academic AS aca ON aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'";
                                    $attendance_exe = mysql_query($attendance_sql);
                                    $attendance_cnt = mysql_num_rows($attendance_exe);
                                    if($attendance_cnt > 0) {
                                        while ($fet1 = mysql_fetch_assoc($attendance_exe)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $fet1['name'];?></td>
                                                <td><?php echo $fet1['class_teacher'];?></td>
                                                <td><?php if ($fet1['forenoon'] == 'on') {
                                                        echo 'Present';
                                                    } else if ($fet1['forenoon'] == 'off'){
                                                        echo 'Absent';
                                                    }?></td>
                                                <td><?php if ($fet1['afternoon'] == 'on') {
                                                        echo 'Present';
                                                    } else if ($fet1['afternoon'] == 'off') {
                                                        echo 'Absent';
                                                    }?></td>
                                                <td><?php echo $fet1['remarks'];?></td>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
        });
    } );
</script>

<script>
    $( function() {
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-teacher-attendance.php?dat=" + d,
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
                    displayLength: 100
                });
            });
        });
    } );
</script>

</body>
</html>
