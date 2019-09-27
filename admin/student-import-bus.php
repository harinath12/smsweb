<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
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
                Import Student
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="student-list.php"> Student List</a></li>
                <li class="active">Import Student</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doimportbus.php" id="addStudentForm" method="post" enctype="multipart/form-data">

                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Info imported Successfully</strong>
                            </div>
                        <?php
                        }
                    }

                    ?>
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Student Details
                                </h4>
                                <p>[ <a href="import/student-import.xlsx">Download</a> the excel sheet, fill it and then upload. ]</p>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input type="file" name="file" class="file-styled-primary" accept=".xlsx" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2">
                                            <input type="reset" name="reset" class="btn btn-info" value="Cancel">
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="submit" name="submit" class="btn btn-info" value="Upload">
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

</body>
</html>