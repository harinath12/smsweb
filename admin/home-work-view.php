<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$notesId = $_REQUEST['home_work_id'];

$class_sql="SELECT hw.*, tea.teacher_name  FROM home_work as hw
LEFT JOIN teacher_general as tea on tea.user_id = hw.teacher_id
where hw.id='$notesId'";
$class_exe=mysql_query($class_sql);
$class_cnt=@mysql_num_rows($class_exe);
$class_fet = mysql_fetch_assoc($class_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
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
                Home Work View
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="home-work-list.php">Home Work List</a></li>

                <li class="active">Home Work View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="" id="addStudentForm" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Home Work Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Teacher Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="studentName" value="<?php echo $class_fet['teacher_name']; ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="admissionNum" value="<?php echo $class_fet['class'] . ' ' . $class_fet['section'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Subject</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" value="<?php echo $class_fet['subject'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Period</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" value="<?php echo $class_fet['period'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" value="<?php echo $class_fet['date'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Description</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="description" value="<?php echo $class_fet['description'];?>" readonly />
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </form>
                <!-- /form horizontal -->
            </div>
            <!-- /content area -->
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
<!-- page script -->
</body>
</html>