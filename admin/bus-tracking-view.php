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
$date = date("d-m-Y");

$trip_sql = "select * from trip where trip_status='1' and trip_date='$date' order by id DESC";
$trip_exe = mysql_query($trip_sql);
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
                            <h3 class="box-title" style="line-height:30px;">Bus Tracking View</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
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

                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Bus No</th>
                                    <th>Route No</th>
                                    <th>Pickup/Drop</th>
                                    <th>Current Stop</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sno = 1;
                                while($trip_fet = mysql_fetch_assoc($trip_exe)){
                                    $tripId = $trip_fet['id'];
                                    ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo $trip_fet['bus_no']; ?></td>
                                        <td><a href="bus-tracking-route-view.php?id=<?php echo $tripId; ?>"><?php echo $trip_fet['route_no']; ?></a></td>
                                        <td><?php echo $trip_fet['pickup_drop']; ?></td>
                                        <td>
                                            <?php
                                            $trip_stop_sql = mysql_query("select * from trip_stop where trip_id='$tripId' order by id DESC");
                                            $trip_stop_fet = mysql_fetch_assoc($trip_stop_sql);
                                            echo $trip_stop_fet['trip_stop_name'];
                                            ?>
                                        </td>
                                        <td>
                                           <?php
                                           if(($trip_fet['start_status'] == 1) && ($trip_fet['end_status'] == 0)){
                                               ?>
                                               <button class="btn btn-info">Trip Started</button>
                                            <?php
                                           }
                                           else if($trip_fet['end_status'] == 1){
                                               ?>
                                               <button class="btn btn-info">Trip Closed</button>
                                           <?php
                                           }
                                           ?>
                                        </td>
                                    </tr>
                                <?php
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
                columnDefs: [
                    {
                        targets: 5,
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
                displayLength: 20
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
