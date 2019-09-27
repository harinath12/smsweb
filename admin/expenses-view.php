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
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$vehicle_sql="SELECT * FROM `expenses` where id='$expenseId'";
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
                View Expenses
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="expenses-list.php"> Expenses List</a></li>
                <li class="active">View Expenses</li>
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
                            <h3 class="box-title">View Expenses Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="#" method="post">
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
												<?php echo date_display($vehicle_fet['expense_date']);?>
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
                                                    <img src="<?php echo '../driver/' . $vehicle_fet['bill']; ?>" height="300px" width="300px" title="<?php echo '../driver/' . $vehicle_fet['expenses_details']; ?>"/>
                                                </div>
                                            </div>
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
