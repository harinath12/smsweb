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
    <title>SMS - Teacher</title>
    <?php include "head-inner.php"; ?>
    <style>
        span.req{
            color: red;
        }
    </style>
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
                        <h4><i class="fa fa-th-large position-left"></i> CHANGE PASSWORD</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Change Password</li>
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
                                <h4 class="panel-title">Change Password</h4>
                            </div>
                            <div class="panel-body">
                                <form action="dochangepassword.php" method="post">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <tr>
                                            <th><label>Old Password</label> <span class="req"> *</span></th>
                                            <td>
                                                <input name="old_password" id="old_password" type="password" class="form-control" placeholder="Old Password" />
                                                <div id="errOldPassword" style="color:red"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><label>New Password</label> <span class="req"> *</span></th>
                                            <td>
                                                <input name="new_password" id="new_password" type="password" class="form-control" placeholder="New Password" />
                                                <div id="errNewPassword" style="color:red"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><label>Confirm Password</label> <span class="req"> *</span></th>
                                            <td>
                                                <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="Re-enter New Password" />
                                                <div id="errConfirmPassword" style="color:red"></div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <button name="changepassword" type="submit" class="btn btn-primary btn-md changepassword">Save Changes</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>

                        </div>
                        <!-- /basic datatable -->
                    </div>
                </div>

                <script type='text/javascript'>
                    $(document).ready(function() {
                        $(function() {
                            $('.styled').uniform();
                        });
                        $(function() {

                            // DataTable setup
                            $('.datatable').DataTable({
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        width: '10%',
                                        targets: 0
                                    },
                                    {
                                        width: '30%',
                                        targets: [1,2]
                                    },
                                    {
                                        orderable: false,
                                        width: '10%',
                                        targets: 4
                                    },
                                    {
                                        width: '20%',
                                        targets: 3
                                    }
                                ],
                                order: [[ 0, 'desc' ]],
                                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                                language: {
                                    search: '<span>Search:</span> _INPUT_',
                                    lengthMenu: '<span>Show:</span> _MENU_',
                                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                                },
                                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                                displayLength: 5,
                            });

                            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

                            $('.dataTables_length select').select2({
                                minimumResultsForSearch: Infinity,
                                width: '60px'
                            });
                        });
                    });
                </script>
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