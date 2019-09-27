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

$school_sql="SELECT si.* FROM `school_info` AS `si`
WHERE `si`.user_id = $user_id";
$school_exe=mysql_query($school_sql);
$school_cnt=@mysql_num_rows($school_exe);
$school_fet=mysql_fetch_array($school_exe);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MySkoo - Profile</title>
    <?php include "head-inner.php"; ?>
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
                        <h4><i class="fa fa-th-large position-left"></i> USER PROFILE</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Edit User Profile</li>
                    </ul>

                    <?php
                    if(isset($_REQUEST['err'])) {
                        if ($_REQUEST['err'] == 1) {
                            ?>
                            <div class="alert alert-warning alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Profile Photo should be of image type.</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
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
                                <h4 class="panel-title">Edit User Profile</h4>
                                <div class="row">
                                    <a href="user-profile.php"><button class="btn btn-info"style="float: right;">View Profile</button></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form role="form" id="" class="form-horizontal" method="post" action="doupdateprofile.php" enctype="multipart/form-data">
                                <table id="example2" class="table table-bordered table-hover">
                                    <tr>
                                        <th>User Name</th>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Enter your name" name="userName"  value="<?php echo $school_fet['name_school']; ?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>User Email</th>
                                        <td><?php echo $user_email; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Photo</th>
                                        <td>
                                            <?php
                                            if(!empty($school_fet['school_photo']))
                                            {
                                                ?>
                                                <img style="height: 150px; width: 150px;" src="<?php echo $school_fet['school_photo']; ?>" alt="<?php echo $school_fet['name_school']; ?>" title="<?php echo $school_fet['name_school']; ?>" />
                                            <?php
                                            }
                                            ?>
                                            <input type="file" class="form-control" name="profilePhoto">
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2">
                                            <button class="btn btn-info">Save</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>

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
</body>
</html>