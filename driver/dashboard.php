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

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SMS Driver Dashboard</title>
	<?php include "head-dashboard.php"; ?>
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
<div class="content-wrapper" style="background-color: #3F51B5;">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="fa fa-home position-left"></i> <span>Dashboard</span></h4>
			</div>										
			<ul class="breadcrumb">
				<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
				<li class="active">Dashboard</li>
			</ul>					
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div id="studentdashboard" class="content">

        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="trip-list.php">
                    <img src="../admin/image/logo/trip.png"  title="Trtp" style="height:140px; width:170px;"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="expenses-list.php">
                    <img src="../admin/image/logo/expenses.png"  title="Expenses" style="height:140px"/>
                </a>
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
</body>
</html>