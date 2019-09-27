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

if(isset($_REQUEST['id']))
{
    $stopid=$_REQUEST['id'];
}
else
{
    exit;
}

$stop_sql="SELECT * FROM `stopping_master` where id = '$stopid'";
$stop_exe=mysql_query($stop_sql);
$stop_fet=mysql_fetch_array($stop_exe);
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
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Stop
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="stops.php"> Stops</a></li>
                <li class="active">Edit Stop</li>
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
                            <h3 class="box-title">Edit Stop Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="doeditstop.php" method="post">
                            <div class="box-body">

                                <div class="col-md-6">
                                    <style>.control-label{line-height:32px;} .form-group{line-height:32px;}</style>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Stop Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?php echo $stop_fet['stopping_name']; ?>" class="form-control" name="stopping_name" required/>
                                            <div id="errLesson" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-sm-4"> </div>
                                        <div class="col-sm-4">
                                            <input type="hidden" value="<?php echo $stop_fet['id']; ?>" class="form-control" name="stop_id"/>
                                            <button type="submit" class="btn btn-primary btn-block btn-flat save-chapter">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
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

</body>
</html>
