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
                        <h4><i class="fa fa-th-large position-left"></i> EXPENSE EDIT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="expenses-list.php"> Expenses List</a></li>
                        <li class="active">Expense Edit</li>
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
                                <h4 class="panel-title">Expense Edit</h4>
                            </div>
                            </br>

                            <form role="form" action="doeditexpenses.php" method="post" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Expenses Details</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="expenses_details"><?php echo $vehicle_fet['expenses_details'];?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Amount</label>
                                                <div class="col-sm-9">
                                                    <input type="number" step="0.01" min="0" class="form-control" name="amount" value="<?php echo $vehicle_fet['amount'];?>" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-3 control-label">Amount Paid</label>
                                                <div class="col-sm-9">
                                                    <input type="number" step="0.01" min="0" class="form-control" name="amount_paid" value="<?php echo $vehicle_fet['amount_paid'];?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Expense Date</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="expense_date" id="datepicker1" value="<?php echo $vehicle_fet['expense_date'];?>" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label class="col-sm-5 control-label">Bill</label>
                                                <div class="col-sm-7">
                                                    <?php
                                                    if($vehicle_fet['bill']){
                                                        ?>
                                                        <img src="<?php echo $vehicle_fet['bill']; ?>" height="100px" width="100px" title="<?php echo $vehicle_fet['expenses_details']; ?>"/>
                                                    <?php
                                                    }
                                                    ?>
                                                    <input type="file" class="form-control" name="bill" value="" accept="image/*" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-5"></div>
                                        <div class="form-group col-md-2">
                                            <input type="hidden" name="expenseId" value="<?php echo $expenseId; ?>" />
                                            <button type="submit" class="btn btn-info add-vehicle">Save Changes</button>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
        });
    } );
</script>
<!-- page script -->

</body>
</html>