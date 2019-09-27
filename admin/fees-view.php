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

$fee_id = $_REQUEST['fee_id'];

$fee_sql = "select * from fee_info where id = $fee_id";
$fee_exe = mysql_query($fee_sql);
$fee_fet = mysql_fetch_array($fee_exe);

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color: red;
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
                Fees View
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="fees_list.php"> Fees</a></li>
                <li class="active">Fees View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body no-padding-bottom">
                            <div class="col-md-6">
                                <form action="#" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Name </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="fee_name" value="<?php echo $fee_fet['fee_name']; ?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Amount</label>
                                            <div class="col-lg-8">
                                                <input type="number" min="0" step="0.01" class="form-control" name="fee_amount" value="<?php echo $fee_fet['fee_amount']; ?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Terms </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="fee_name" value="<?php echo $fee_fet['fee_terms']; ?>" readonly/>
                                            </div>
                                        </div>

                                        <?php
                                        $term_sql = "select * from fee_terms where fee_id = $fee_id and fee_term_status=1";
                                        $term_exe = mysql_query($term_sql);
                                        while($term_fet = mysql_fetch_array($term_exe)){
                                            ?>
                                            <div id="term1">
                                                <label class="control-label col-lg-4"><?php echo $term_fet['fee_term'];?> </label>
                                                <div class="col-lg-4">
                                                    <label>Start Date :</label>
                                                    <div class="form-group">
                                                        <input type="text" name="term1_startdate" class="form-control" value ="<?php echo $term_fet['fee_term_start_date'];?>" readonly/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>End Date :</label>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input type="text" name="term1_startdate" class="form-control" value ="<?php echo $term_fet['fee_term_end_date'];?>" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </form>
                            </div>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.row -->
            </div>
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

</body>
</html>
