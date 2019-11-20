<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$trip_sql = "select * from trip where trip_status='1' and driver_id='$user_id' order by id DESC";
$trip_exe = mysql_query($trip_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Driver</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                        <h4><i class="fa fa-th-large position-left"></i> TRIP LIST</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Trip List</li>
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
                                <h4 class="panel-title">Trip List</h4>
                            </div>
                            <?php
                            if(isset($_REQUEST['suc'])){
                                if($_REQUEST['suc'] == 1){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Trip inserted Successfully</strong>
                                    </div>
                                <?php
                                }
                                if($_REQUEST['suc'] == 2){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Trip deleted Successfully</strong>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-2" style="float: right;">
                                    <a href="trip.php">
                                        <input type="button" class="btn btn-info form-control" value="ADD TRIP"/>
                                    </a>
                                </div>
								<div class="col-sm-2" style="float: right;">
                                    <a href="trip-choose.php">
                                        <input type="button" class="btn btn-info form-control" value="CHOOSE TRIP"/>
                                    </a>
                                </div>
                            </div>
                            </br>

                            <div class="box-body" id="predate">
                                <table id="example2" class="table datatable curdate">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Bus No</th>
                                        <th>Route No</th>
                                        <th>Kilometer Readings</th>
                                        <th>Pickup/Drop</th>
                                        <th>Trip Date</th>
                                        <th>Trip Time</th>
										<th>Trip Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sno = 1;
                                    while($trip_fet = mysql_fetch_assoc($trip_exe)){
                                        ?>
                                        <tr>
                                            <td><?php echo $sno++; ?></td>
                                            <td><?php echo $trip_fet['bus_no']; ?></td>
                                            <td><?php echo $trip_fet['route_no']; ?></td>
                                            <td><?php echo $trip_fet['distance'] . " km(s)"; ?></td>
                                            <td><?php echo $trip_fet['pickup_drop']; ?></td>
                                            <td>
											<?php //echo $trip_fet['trip_date']; ?>
											<?php echo date_display($trip_fet['trip_date']); ?>
											</td>
                                            <td><?php echo $trip_fet['trip_time']; ?></td>
											<td>
												<?php if($trip_fet['end_status']==1) {?>
												<span style="color:green">COMPLETED</span>
												<?php } else if($trip_fet['end_status']==0) {?>
												<span style="color:red">ONGOING</span>
												<?php } ?>
											</td>
                                            <td>
												<?php if($trip_fet['end_status']==1) {?>
                                                <a href="trip-view.php?id=<?php echo $trip_fet['id']; ?>"> <button type="button" class="btn btn-info"> <i class="fa fa-eye"></i> </button> </a>
                                                <a href="trip-delete.php?id=<?php echo $trip_fet['id']; ?>" onclick="return confirm('Do you want to delete the trip?');"> <button type="button" class="btn btn-info"> <i class="fa fa-trash"></i> </button> </a>
												<?php } else if($trip_fet['end_status']==0) {?>
												<a href="trip-edit.php?id=<?php echo $trip_fet['id']; ?>"> <button type="button" class="btn btn-info"> <i class="fa fa-pencil"></i> </button> </a>
                                                <a href="trip-delete.php?id=<?php echo $trip_fet['id']; ?>" onclick="return confirm('Do you want to delete the trip?');"> <button type="button" class="btn btn-info"> <i class="fa fa-trash"></i> </button> </a>
												<?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div><!-- /.box-body -->
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

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs: [
                    {
                        targets: 7,
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