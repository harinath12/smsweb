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

$vehicle_sql="SELECT * FROM `vehicles` where vehicle_status='1'";
$vehicle_exe=mysql_query($vehicle_sql);
$vehicle_cnt=@mysql_num_rows($vehicle_exe);
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
                Transport
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Transport</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Vehicles List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            if(isset($_REQUEST['suc'])){
                                if($_REQUEST['suc'] == 1){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Vehicles inserted Successfully</strong>
                                    </div>
                                <?php
                                }
                                if($_REQUEST['suc'] == 2){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Vehicles deleted Successfully</strong>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="vehicles-list.php"><button type="button" class="form-control btn btn-info" id="myBtn">Vehicles</button></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="routes-list.php"><button type="button" class="form-control btn btn-info">Routes</button></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="expenses-list.php"><button type="button" class="form-control btn btn-info">Expenses</button></a>
                                </div>
                                <div class="col-md-3">
                                    <a href="bus-tracking-view.php"><button type="button" class="form-control btn btn-info">Bus Tracking View</button></a>
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <a href="vehicle-add.php" style="float: right; margin-right: 10px;"><button type="button" class="btn btn-info btn-md" style="margin-bottom:10px;">Create Vehicle</button></a>
                            </div>

                            <table id="example2" class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vehicle No.</th>
                                    <th>Reg. No.</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i =1;
                                while($vehicle_fet=mysql_fetch_array($vehicle_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $vehicle_fet['bus_no']; ?></td>
                                        <td><?php echo $vehicle_fet['bus_registration_no']; ?></td>
                                        <td><?php echo $vehicle_fet['vehicle_type']; ?></td>
                                        <td>
                                            <a href="vehicle-view.php?id=<?php echo $vehicle_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View</button></a> &nbsp;&nbsp;
                                            <a href="vehicle-edit.php?id=<?php echo $vehicle_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</button></a> &nbsp;&nbsp;
                                            <a href="vehicle-delete.php?id=<?php echo $vehicle_fet['id']; ?>" onclick="return confirm('Do you want to delete the vehicle?');"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-trash"></i> Delete</button></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>

                            </table>
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

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs:[
                    {
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets: [1,2,3]
                    },
                    {
                        width: '25%',
                        targets: 4,
                        orderable:false
                    }
                ],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 100
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
</script>
<!-- page script -->

</body>
</html>
