<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];
$circularId = $_REQUEST['circular_id'];

$circular_sql="SELECT * FROM `circular` where id=$circularId";
$circular_exe=mysql_query($circular_sql);
$circular_fet = mysql_fetch_assoc($circular_exe);

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
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
                Edit Circular
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="circular-list.php">Circular List</a></li>
                <li class="active">Edit Circular</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doupdatecircular.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Circular Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="circularDate" value="<?php echo $circular_fet['circular_date']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular Title</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="circularTitle" value="<?php echo $circular_fet['circular_title']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular To</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="circularTo" id="circularTo">
                                                <option value="All" <?php if($circular_fet['circular_to'] == 'All'){echo 'selected';}?>>All</option>
                                                <option value="All Teachers" <?php if($circular_fet['circular_to'] == 'All Teachers'){echo 'selected';}?>>All Teachers</option>
                                                <option value="All Students" <?php if($circular_fet['circular_to'] == 'All Students'){echo 'selected';}?>>All Students</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['class_name']; ?>" <?php if($circular_fet['circular_to'] == $value['class_name']){echo 'selected';}?>><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Message (If any)</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="message"><?php echo $circular_fet['circular_message']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Attachment</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="circularFile">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <input type="hidden" class="form-control" name="circularId" value="<?php echo $circularId; ?>">
                            <input type="submit" value="UPDATE" class="btn btn-info form-control"/>
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