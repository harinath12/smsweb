<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$teacherId = $_REQUEST['teacher_id'];

$student_sql="SELECT * FROM `teacher_general` where user_id = $teacherId";
$student_exe=mysql_query($student_sql);
$student_fet = mysql_fetch_assoc($student_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <title>Admin Panel</title>
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
                Teacher Edit
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="teacher-list.php">Teacher List</a></li>
                <li class="active">Reset Password</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doresetteacherpassword.php" id="addStudentForm" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="panel panel-flat">
                            </br>
                            <div class="row">
                                <div class="col-md-3" style="float: right">
                                    <a href="teacher-edit.php?teacher_id=<?php echo $teacherId; ?>"><button type="button" class="form-control btn btn-info">Edit Teacher (General)</button></a>
                                </div>
                                <div class="col-md-3" style="float: right">
                                    <a href="teacher-academic-edit.php?teacher_id=<?php echo $teacherId; ?>"><button type="button" class="form-control btn btn-info">Edit Teacher (Academic)</button></a>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Password Reset
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Teacher Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="teacherName" value="<?php echo $student_fet['teacher_name']; ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Emp No.</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="empNo" value="<?php echo $student_fet['emp_no']; ?>" readonly required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email/User Login</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" value="<?php echo $student_fet['email']; ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">New Password<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" name="new_password" id="new_password"/>
                                            <div id="errNewPassword" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Confirm Password<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"/>
                                            <div id="errConfirmPassword" style="color:red"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="hidden" name="teacherId" value="<?php echo $student_fet['user_id']; ?>">
                            <input type="submit" value="SUBMIT" class="btn btn-info form-control changepassword"/>
                        </div>
                    </div>
                </form>
                <!-- /form horizontal -->
            </div>
            <!-- /content area -->
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
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function(){
        $(".changepassword").click(function(){
            $("div#errNewPassword").html( " " );
            $("div#errConfirmPassword").html( " " );
            var newPass = $('#new_password').val();
            var len = newPass.length;
            if(!newPass){
                $("div#errNewPassword").html( "This field is required" );
                return false;
            }
            if(len < 6){
                $("div#errNewPassword").html( "The new password should be minimum of 6 characters");
                return false;
            }
            var confPass = $('#confirm_password').val();
            if(!confPass){
                $("div#errConfirmPassword").html( "This field is required" );
                return false;
            }
            if(confPass != newPass){
                $("div#errConfirmPassword").html( "The new password and confirm password should be same");
                return false;
            }
        });
    });
</script>
</body>
</html>