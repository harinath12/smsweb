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

$school_sql="SELECT si.*, `countries`.`name` AS country_name, cities.city_name, users.delete_status
FROM `school_info` AS `si`
LEFT JOIN `users` ON users.id = si.user_id
LEFT JOIN `countries` ON countries.id = si.country
LEFT JOIN `cities` ON cities.id = si.city";
$school_exe=mysql_query($school_sql);
$school_cnt=@mysql_num_rows($school_exe);


?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
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
                School List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">School List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">School List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <a href="createprofile.php" style="float: right; margin-right: 10px;"><button type="button" class="btn btn-info btn-md" style="margin-bottom:10px;">Create School</button></a>
                            </div>

                            <?php
                            if($school_cnt>0)
                            {
                                ?>
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>School Code</th>
                                        <th>School Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sl=0;
                                    while($school_fet=mysql_fetch_array($school_exe))
                                    {
                                        $sl++;
                                        ?>
                                        <tr>
                                            <td><?php echo $sl; ?></td>
                                            <td><?php echo $school_fet['school_code']; ?></td>
                                            <td><?php echo $school_fet['name_school']; ?></td>
                                            <td><?php echo $school_fet['mobile']; ?></td>
                                            <td><?php echo $school_fet['email']; ?></td>
                                            <td>
                                                <?php if($school_fet['delete_status'] == 1)
                                                {?>
                                                    <button type="button" class="btn btn-success btn-xs">Active</button>
                                                <?php
                                                }
                                                else{
                                                    ?>
                                                    <button type="button" class="btn btn-danger btn-xs">Inactive</button>
                                                <?php
                                                }?>
                                            </td>
                                            <td>
                                                <a href="schoolview.php?school_id=<?php echo $school_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View</button></a>
                                                &nbsp;&nbsp;&nbsp;

                                                &nbsp;&nbsp;&nbsp;
                                                <a class="hidden" href="product-delete.php?delete=1&product_id=<?php echo $school_fet['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Delete</button></a>

                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            <?php
                            }
                            else{
                                ?>
                                <p><b> Records are being updated. </b></p>
                            <?php
                            }
                            ?>
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

</body>
</html>
