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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                Edit Vehicle
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="vehicles-list.php"> Vehicles List</a></li>
                <li class="active">Edit Vehicle</li>
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
                            <h3 class="box-title">Edit Vehicle Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="doeditvehicle.php" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Bus No.<span class="req"> *</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="bus_no" id="bus_no" value="<?php echo $vehicle_fet['bus_no'];?>" required />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Bus Reg. No.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="bus_reg_no" id="bus_reg_no" value="<?php echo $vehicle_fet['bus_registration_no'];?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-3 control-label">Vehicle Type</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="vehicle_type" id="vehicle_type">
                                                    <option value="">Select Vehicle Type</option>
                                                    <option value="Bus" <?php if($vehicle_fet['vehicle_type'] == 'Bus'){ echo 'Selected';}?>>Bus</option>
                                                    <option value="Mini Bus" <?php if($vehicle_fet['vehicle_type'] == 'Mini Bus'){ echo 'Selected';}?>>Mini Bus</option>
                                                    <option value="Van" <?php if($vehicle_fet['vehicle_type'] == 'Van'){ echo 'Selected';}?>>Van</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Insurance Ending Date</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="insurance" id="datepicker1" value="<?php echo $vehicle_fet['insurance_ending_date'];?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">FC Ending Date</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="fc" id="datepicker2" value="<?php echo $vehicle_fet['fc_ending_date'];?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <input type="hidden" class="form-control" name="vehicle_id" value="<?php echo $vehicle_fet['id'];?>"/>
                                    <div class="form-group col-md-5"></div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-info add-vehicle">Save Changes</button>
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
        });
    } );

    $( function() {
        $( "#datepicker2").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
        });
    } );
</script>

</body>
</html>
