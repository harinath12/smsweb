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

if($_REQUEST['id']){
    $trip_id = $_REQUEST['id'];
}
else{
    exit;
}

$trip_sql="SELECT * FROM `trip` where id='$trip_id'";
$trip_exe=mysql_query($trip_sql);
$trip_fet = mysql_fetch_assoc($trip_exe);
$route_no = $trip_fet['route_no'];

$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id, ts.trip_time as rtrip_time, ts.trip_id FROM `routes` as r
 LEFT JOIN route_stop as rs on rs.route_id = r.id
 LEFT JOIN trip_stop as ts on ts.trip_stop_name = rs.stop_name and ts.trip_id = '$trip_id'
 where route_no='$route_no' ORDER BY rs.route_order ASC";
$trip_stop_exe=mysql_query($trip_stop_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <style>
        .form-group{
            margin-bottom: 0px !important;
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
                            <h3 class="box-title" style="line-height:30px;">Bus Tracking Route View</h3>
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

                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <b>Trip Details</b>
                                    </h4>
                                </div>
                                <div class="panel-body no-padding-bottom">
                                    <div class="row" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Bus No</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['bus_no']; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Route No</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['route_no']; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Pickup / Drop</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['pickup_drop']; ?>
                                                </div>
                                            </div>

                                            <?php if($trip_fet['end_status'] == 1){
                                                ?>
                                                <div class="form-group row">
                                                    <label class="control-label col-lg-4">Trip End Time</label>
                                                    <div class="col-lg-8">
                                                        <?php echo $trip_fet['trip_end_time']; ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Kilometer Readings</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['distance']. " km(s)"; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Trip Date</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['trip_date']; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="control-label col-lg-4">Trip Time</label>
                                                <div class="col-lg-8">
                                                    <?php echo $trip_fet['trip_time']; ?>
                                                </div>
                                            </div>

                                            <?php if($trip_fet['end_status'] == 1){
                                                ?>
                                                <div class="form-group row">
                                                    <label class="control-label col-lg-4">Trip End Readings</label>
                                                    <div class="col-lg-8">
                                                        <?php echo $trip_fet['end_km_readings'] . " km(s)"; ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h4 class="panel-title">
                                            <b>Trip Student Details</b>
                                        </h4>
                                        <?php
                                        while($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
                                            $stop_name = $trip_stop_fet['stop_name'];
                                            $route_id = $trip_stop_fet['route_id'];

                                            $stud_sql = "select gen.*, ts.trip_student_status, ts.trip_id from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
                                            $stud_exe = mysql_query($stud_sql);
                                            ?>
                                    <h3>
                                    <?php echo $stop_name; ?>
                                    <?php if($trip_stop_fet['rtrip_time'] != null){?>
                                    <span style="font-size: 14px;">[<b>Time:</b><?php echo $trip_stop_fet['rtrip_time'];?>]</span>
                                        <?php } ?>
                                    </h3>

                                    <form class="form-horizontal" action="" method="post" style="border-bottom: 1px grey dotted; padding-bottom: 10px;">
                                        <div class="row">
                                            <?php
                                            while ($stud_fet = mysql_fetch_assoc($stud_exe)) {
                                                ?>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="student_id[]" value="<?php echo $stud_fet['user_id']?>" <?php if($stud_fet['trip_student_status'] == '1'){ echo 'checked';}?>/> <?php echo $stud_fet['student_name']?>
                                                </div>
                                            <?php
                                            }?>
                                        </div>
                                    </form>
                                    </hr>
                                    <?php
                                        }?>

                                        </br>
                                    </div>
                                </div>
                            </div>
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
