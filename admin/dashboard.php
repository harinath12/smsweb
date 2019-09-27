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
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #367fa9; min-height:690px !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
        </section>

        <!-- Main content -->
        <section id="admindashboard" class="content">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="student-count.php">
                        <img src="image/logo/student.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="teacher-list.php">
                        <img src="image/logo/teacher.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="student-attendance.php">
                        <img src="image/logo/attendance.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="gallery.php">
                        <img src="image/logo/gallery.png" style="height:140px"/>
                    </a>
                </div>

                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="home-work.php">
                        <img src="image/logo/home-work.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="class-notes.php">
                        <img src="image/logo/class-notes.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="project-list.php">
                        <img src="image/logo/projects.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="circular-list.php">
                        <img src="image/logo/circular.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="information_teacher.php">
                        <img src="image/logo/parent-request.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="report-daily-test.php">
                        <img src="image/logo/test.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="report-self-test.php">
                        <img src="image/logo/self-test-result.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="teacher-remarks.php">
                        <img src="image/logo/teachers-remarks.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="exam-time-table.php">
                        <img src="image/logo/exam-time-table.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="marks-list.php">
                        <img src="image/logo/mark-entry.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="result.php">
                        <img src="image/logo/results.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="question-bank.php">
                        <img src="image/logo/question-bank.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="question-paper.php">
                        <img src="image/logo/question-paper.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="bus-tracking-view.php">
                        <img src="image/logo/transport.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="notes.php">
                        <img src="image/logo/fair-note.png" title="Notes" style="height:140px"/>
                    </a>
                </div>

                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="student-leave-list.php">
                        <img src="image/logo/leave-applied-by-students.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="teacher-leave-list.php">
                        <img src="image/logo/leave-applied-by-teachers.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="time-table.php">
                        <img src="image/logo/time-table.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="#" class="comingsoon">
                        <img src="image/logo/substitute.png" style="height:140px"/>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="notes.php">
                        <img src="image/logo/text.png" style="height:140px"/>
                    </a>
                </div>
				<div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="calendar.php">
                        <img src="image/logo/calendar.png" style="height:140px"/>
                    </a>
                </div>
				
				<div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="book-list.php">
                        <img src="image/logo/book.png" title="BOOKS" style="height:140px"/>
                    </a>
                </div>
				
				<div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="video-book-list.php">
                        <img src="image/logo/videobook.png" title="BOOKS" style="height:140px"/>
                    </a>
                </div>
				
				<div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="aptitude-question-bank.php">
                        <img src="image/logo/aptitude-question-bank.png" title="APTITUDE Question Bank" style="height:140px"/>
                    </a>
                </div>
				
				
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="report-aptitude-test.php">
                        <img src="image/logo/aptitude-test.png" title="APTITUDE Test" style="height:140px"/>
                    </a>
                </div>
				
				
				<div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="students-promotion.php">
                        <img src="image/logo/promotion.png" title="Students Promotions" style="height:140px"/>
                    </a>
                </div>

                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="fees_list.php">
                        <img src="image/logo/fees.png" title="Fees" style="height:140px"/>
                    </a>
                </div>
				
            </div><!-- /.row -->
        </section><!-- /.content -->

        <section class="content hidden">
            <div class="row">
                <div class="col-md-3">
                    <a href="student-count.php"><button class="btn btn-info form-control">Students</button></a>
                </div>
                <div class="col-md-3">
                    <a href="teacher-list.php"><button class="btn btn-info form-control">Teachers</button></a>
                </div>
                <div class="col-md-3">
                    <a href="student-attendance.php"><button class="btn btn-info form-control">Attendance</button></a>
                </div>
                <div class="col-md-3">
                    <a href="gallery.php"><button class="btn btn-info form-control">Gallery</button></a>
                </div>
            </div><!-- /.row -->
            </br>

            <div class="row">
                <div class="col-md-3">
                    <a href="home-work.php"><button class="btn btn-info form-control">Homework</button></a>
                </div>
                <div class="col-md-3">
                    <a href="class-notes.php"><button class="btn btn-info form-control">Class Notes</button></a>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info form-control">Leave Applied</button>
                </div>
                <div class="col-md-3">
                    <a href="circular-list.php"><button class="btn btn-info form-control">Circular</button></a>
                </div>
            </div><!-- /.row -->
            </br>

            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-info form-control">Time Table</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info form-control">Substitute</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info form-control">Exam Time Table</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info form-control">Message and Notice</button>
                </div>
            </div><!-- /.row -->
            </br>

            <div class="row">
                <div class="col-md-3">
                    <a href="question-bank.php"><button class="btn btn-info form-control">Question Bank</button></a>
                </div>
                <div class="col-md-3">
                    <a href="notes.php"><button class="btn btn-info form-control">Notes</button></a>
                </div>
            </div><!-- /.row -->
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
<script>
    $(function(){
        $('.comingsoon').click(function(){
            alert("Coming Soon!!!");
        });
    });
</script>
</body>
</html>
