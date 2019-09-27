<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$remark_sql = "select info.*, gen.student_name from information_teacher as info
LEFT JOIN student_general as gen on gen.user_id = info.student_id
where teacher_id='$user_id' and admin_status='1' and remarks_status='1' order by id DESC";
$remark_exe = mysql_query($remark_sql);

$remark_cnt = @mysql_num_rows($remark_exe);
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
        .req{
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
                        <h4><i class="fa fa-th-large position-left"></i> PARENT REQUEST</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Parent Request</li>
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
                            <form method="post">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>STUDENT NAME</th>
                                        <th>TEACHER NAME</th>
                                        <th>TITLE</th>
                                        <th>DETAILS</th>
                                        <th style="text-align: center;">ATTACHMENT</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($remark_fet=mysql_fetch_array($remark_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php echo $remark_fet['student_name'];?>
                                            </td>
                                            <td><?php echo $remark_fet['teacher_name']; ?></td>
                                            <td><?php echo $remark_fet['title']; ?></td>
                                            <td><?php echo $remark_fet['remark_details']; ?></td>
                                            <td style="text-align: center;">
                                                <?php
                                                if($remark_fet['remark_filepath']!="")
                                                {
                                                ?>
                                                    <a href="<?php echo '../parent/' . $remark_fet['remark_filepath']; ?>" target="_blank"> <i class="fa fa-microphone"></i> </a>
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
                            </form>
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
                                        width: '15%',
                                        targets: 0
                                    },
                                    {
                                        width: '20%',
                                        targets:[1,2]
                                    },
                                    {
                                        width: '25%',
                                        targets: 3
                                    },
                                    {
                                        width: '20%',
                                        targets: 4,
                                    }
                                ],
                                order: [[ 0, 'asc' ]],
                                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                                language: {
                                    search: '<span>Search:</span> _INPUT_',
                                    lengthMenu: '<span>Show:</span> _MENU_',
                                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                                },
                                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                                displayLength: 10
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
</body>
</html>