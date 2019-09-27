<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['id']))
{
    $vehicleId = $_REQUEST['id'];
}
else{
    exit;
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$vehicle_sql="SELECT * FROM `vehicles` where id='$vehicleId'";
$vehicle_exe=mysql_query($vehicle_sql);
$vehicle_fet=mysql_fetch_array($vehicle_exe);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <style>.control-label{line-height:32px;}  .form-group{line-height:32px;}</style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Vehicles
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="vehicles-list.php"> Vehicles List</a></li>
                <li class="active">View Vehicles</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Vehicles Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="#" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Bus No.</label>
                                            <div class="col-sm-9">
                                               <?php echo $vehicle_fet['bus_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Bus Reg. No.</label>
                                            <div class="col-sm-9">
                                                <?php echo $vehicle_fet['bus_registration_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Vehicle Type</label>
                                            <div class="col-sm-9">
                                                <?php echo $vehicle_fet['vehicle_type']; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Insurance Ending Date</label>
                                            <div class="col-sm-7">
                                                <?php echo $vehicle_fet['insurance_ending_date']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">FC Ending Date</label>
                                            <div class="col-sm-7">
                                                <?php echo $vehicle_fet['fc_ending_date']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>


</body>
</html>
