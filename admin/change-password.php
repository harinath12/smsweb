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
<style>
    .req{
        color : red;
    }
</style>
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Change Password
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Change Password</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Change Password</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <form action="dochangepassword.php" method="post">
                                <div class="form-group row has-feedback">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"><label>Old Password</label> <span class="req"> *</span></div>
                                    <div class="col-md-4">
                                        <input name="old_password" id="old_password" type="password" class="form-control" placeholder="Old Password" />
                                        <div id="errOldPassword" style="color:red"></div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="form-group row has-feedback">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"><label>New Password</label><span class="req"> *</span></div>
                                    <div class="col-md-4">
                                        <input name="new_password" id="new_password" type="password" class="form-control" placeholder="New Password" />
                                        <div id="errNewPassword" style="color:red"></div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="form-group row has-feedback">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"><label>Confirm New Password</label><span class="req"> *</span></div>
                                    <div class="col-md-4">
                                        <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="Re-enter New Password" />
                                        <div id="errConfirmPassword" style="color:red"></div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-xs-4">
                                        <button name="changepassword" type="submit" class="btn btn-primary btn-block btn-flat changepassword">Save Changes</button>
                                    </div><!-- /.col -->
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".changepassword").click(function(){
            $("div#errOldPassword").html( " " );
            $("div#errNewPassword").html( " " );
            $("div#errConfirmPassword").html( " " );
            var oldPass = $('#old_password').val();
            if(!oldPass){
                $("div#errOldPassword").html( "This field is required" );
                return false;
            }
            var newPass = $('#new_password').val();
            var len = newPass.length;
            if(!newPass){
                $("div#errNewPassword").html( "This field is required" );
                return false;
            }
            if(oldPass == newPass){
                $("div#errNewPassword").html( "The new password should be different from old password");
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
