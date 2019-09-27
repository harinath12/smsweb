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
	<title>SMS Student Dashboard</title>
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
                <a href="attendance.php">
                    <img src="../admin/image/logo/attendance.png" style="height:140px"/>
                </a>
            </div>
			
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="home-work.php">
                    <img src="../admin/image/logo/home-work.png"  title="Home Work" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="class-notes.php">
                    <img src="../admin/image/logo/class-notes.png" title="Class Notes" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="project-list.php">
                    <img src="../admin/image/logo/projects.png" title="Projects" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="gallery.php">
                    <img src="../admin/image/logo/gallery.png" title="Gallery" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="daily-test.php">
                    <img src="../admin/image/logo/test.png" title="Daily Test" style="height:140px"/>
                </a>
            </div>
        
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="self-test.php">
                    <img src="../admin/image/logo/self-test.png" title="Self Test" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="notes.php">
                    <img src="../admin/image/logo/fair-note.png" title="Notes" style="height:140px"/>
                </a>
            </div>

			<div class="col-md-2 col-sm-3 col-xs-4">
                <a href="calendar.php">
                    <img src="../admin/image/logo/calendar.png"  title="School Calendar" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="time-table.php">
                    <img src="../admin/image/logo/time-table.png" title="Time Table" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="exam-time-table.php">
                    <img src="../admin/image/logo/exam-time-table.png" title="Exam Time Table" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="result.php">
                    <img src="../admin/image/logo/results.png" title="Result" style="height:140px"/>
                </a>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="bus-tracking-view.php">
                    <img src="../admin/image/logo/transport.png" title="Transport" style="height:140px"/>
                </a>
            </div>
			
			
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="books.php">
                    <img src="../admin/image/logo/book.png" title="Book" style="height:140px"/>
                </a>
            </div>
			
			
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="video-books.php">
                    <img src="../admin/image/logo/videobook.png" title="Video Book" style="height:140px"/>
                </a>
            </div>
			
			<div class="col-md-2 col-sm-3 col-xs-4">
                <a href="aptitude-test.php">
                    <img src="../admin/image/logo/aptitude-test.png" title="Aptitude Test" style="height:140px"/>
                </a>
            </div>
			
			<?php if($teacher_fet['class_name']=='I') { ?>
			<div class="col-md-2 col-sm-3 col-xs-4">
                <a href="maths-test.php">
                    <img src="../admin/image/logo/maths-test.png" title="Maths Test" style="height:140px"/>
                </a>
            </div>
			<?php } ?>
			
			
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
<script>
    $(function(){
        $('.comingsoon').click(function(){
            alert("Coming Soon!!!");
        });
    });
</script>
</body>
</html>