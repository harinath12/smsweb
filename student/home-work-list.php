<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$student_sql = "select c.class_name, s.section_name from student_academic as aca
left join classes as c on c.id = aca.class
left join section as s on s.id = aca.section
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$classname = $student_fet['class_name'];
$sectionname = $student_fet['section_name'];
$classsection = $classname . " " . $sectionname;

$home_sql = "select hm.* from teacher_academic as taca
left join home_work as hm on hm.teacher_id = taca.user_id
where taca.class_teacher = '$classsection'";
$home_exe = mysql_query($home_sql);
$home_cnt = @mysql_num_rows($home_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> HOME WORK</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Home Work</li>
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
                                <h4 class="panel-title">Home Work</h4>
                            </div>
                            </br>
                            <form method="post">
                                <?php
                                if($home_cnt>0)
                                {
                                    ?>
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>TITLE</th>
                                            <th>DATE</th>
                                            <th>DESCRIPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i =1;
                                        while($home_fet=mysql_fetch_array($home_exe))
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $home_fet['title']; ?></td>
                                                <td><?php echo $home_fet['date'] ?></td>
                                                <td><?php echo $home_fet['description']; ?></td>
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
                                    <p><b> No Results Found. </b></p>
                                <?php
                                }
                                ?>
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
                                        targets:[ 1,2]
                                    },
                                    {
                                        width: '45%',
                                        targets: 3
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