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
$date = date("Y-m-d");

$mark_sql = "select sm.*, ett.exam_name, c.class_name from student_mark as sm
left join exam_time_table as ett on ett.id=sm.exam_id
left join classes as c on c.id=sm.classid
where exam_status='1' group by exam_id, classid, section_name";
$mark_exe = mysql_query($mark_sql);
?>
<!DOCTYPE html>
<html>
<head>
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
                Marks List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Mark List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body" id="predate">
                            <form method="post">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>EXAM</th>
                                        <th>CLASS</th>
                                        <th>SECTION</th>
                                        <th>SUBJECT</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($mark_fet=mysql_fetch_array($mark_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $mark_fet['exam_name']; ?></td>
                                            <td><?php echo $mark_fet['class_name']; ?></td>
                                            <td><?php echo $mark_fet['section_name']; ?></td>
                                            <td>
                                                <?php
                                                $exam_id = $mark_fet['exam_id'];
                                                $classid = $mark_fet['classid'];
                                                $section_name = $mark_fet['section_name'];
                                                $sub_exe = mysql_query("SELECT DISTINCT subject_name FROM student_mark where classid=$classid and exam_id=$exam_id and section_name='$section_name'");
                                                $subcnt = mysql_num_rows($sub_exe);
                                                $sub = 1;
                                                while($sub_fet = mysql_fetch_array($sub_exe)){
                                                    if($sub == $subcnt){
                                                        echo $sub_fet['subject_name'];
                                                    }
                                                    else{
                                                        echo $sub_fet['subject_name'] . ',';
                                                    }
                                                    $sub++;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="marks-view.php?id=<?php echo $mark_fet['id']; ?>" title="View">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-eye"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,

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
