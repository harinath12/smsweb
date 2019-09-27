<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['id']))
{
    $routeId = $_REQUEST['id'];
}
else{
    exit;
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$route_sql="SELECT * FROM `routes` where id='$routeId'";
$route_exe=mysql_query($route_sql);
$route_fet=mysql_fetch_array($route_exe);

$stop_sql="SELECT * FROM `route_stop` where route_id='$routeId' ORDER BY route_order ASC";
$stop_exe=mysql_query($stop_sql);
$stop_cnt=mysql_num_rows($stop_exe);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
        .form-group{
            margin-bottom: 2px !important;
        }
        .control-label{font-weight: bold;}
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
                View Routes
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="routes-list.php"> Routes List</a></li>
                <li class="active">View Routes</li>
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
                            <h3 class="box-title">View Route Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="#" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Route No.</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['route_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Num of Stopping</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['num_of_stopping']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Starting Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['pickup_starting_point']; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Ending Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['pickup_ending_point']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Drop Starting Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['dropping_starting_point']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Drop Ending Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['dropping_ending_point']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if($stop_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <h4>Bus Stops</h4>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <label class="control-label">S.No.</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">Stop Name</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label">Distance</label>
                                                </div>
												<div class="col-sm-2">
                                                    <label class="control-label">Order</label>
                                                </div>
                                            </div>
                                            <?php
                                            $sno = 1;
                                            while($stop_fet = mysql_fetch_assoc($stop_exe)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                        <?php echo $sno++ . ")"; ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <?php echo $stop_fet['stop_name']; ?>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <?php echo $stop_fet['distance'] . " km(s)"; ?>
                                                    </div>
													<div class="col-sm-2">
                                                        <?php echo $stop_fet['route_order']; ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

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
