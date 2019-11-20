<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['id']))
{
    $expenseId = $_REQUEST['id'];
}
else{
    exit;
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$vehicle_sql="SELECT * FROM `expenses` where id='$expenseId'";
$vehicle_exe=mysql_query($vehicle_sql);
$vehicle_fet=mysql_fetch_array($vehicle_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Driver</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
</head>
<body>
<!-- Main navbar -->
<?php
include 'header.php';
?>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container" style="min-height:700px">

    <!-- Page content -->
    <div class="page-content"><!-- Main sidebar -->
        <div class="sidebar sidebar-main hidden-xs">
            <?php include "sidebar.php"; ?>
        </div>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> EXPENSE VIEW</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="expenses-list.php"> Expenses List</a></li>
                        <li class="active">View Expenses</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">Expense View Details</h4>
                            </div>
                            </br>

                            <div class="box-body" id="predate">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Expenses Details</label>
                                                <div class="col-sm-7">
                                                    <?php echo $vehicle_fet['expenses_details']; ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Expense Date</label>
                                                <div class="col-sm-7">
                                                    <?php //echo $vehicle_fet['expense_date']; ?>
													<?php echo date_display($vehicle_fet['expense_date']); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Amount</label>
                                                <div class="col-sm-7">
                                                    <?php echo $vehicle_fet['amount']; ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Amount Paid</label>
                                                <div class="col-sm-7">
                                                    <?php echo $vehicle_fet['amount_paid']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if($vehicle_fet['bill']) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Bill</label>
                                                    <div class="col-sm-7">
                                                        <img src="<?php echo $vehicle_fet['bill']; ?>" height="300px" width="300px" title="<?php echo $vehicle_fet['expenses_details']; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box-body -->
                        </div>
                        <!-- /basic datatable -->
                    </div>
                </div>

                <!-- Footer -->
                <?php include "footer.php"; ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<!-- page script -->

</body>
</html>