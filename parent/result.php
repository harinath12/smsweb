<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 AND (class_id='$classId' OR class_id='100') GROUP BY exam_name";
$exam_exe=mysql_query($exam_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Parent</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> RESULT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Result</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-flat">
                            <form method="post">
                                <table class="datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Exam Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sno = 1;
                                    while($exam_fet = mysql_fetch_assoc($exam_exe)){
                                        ?>
                                        <tr>
                                            <td><?php echo $sno; ?></td>
                                            <td><?php echo $exam_fet['exam_name']; ?></td>
                                            <td>
											<?php //echo $exam_fet['start_date']; ?>
											<?php echo date_display($exam_fet['start_date']); ?>
											</td>
                                            <td>
											<?php //echo $exam_fet['end_date']; ?>
											<?php echo date_display($exam_fet['end_date']); ?>
											</td>
                                            <td>
                                                <button type="button" class="btn btn-info viewExamBtn" title="View" value="<?php echo $exam_fet['id'];?>"><i class="fa fa-eye"></i></button>
                                                <input type="hidden" class="examId" value="<?php echo $exam_fet['id'];?>"/>
                                            </td>
                                        </tr>
                                        <?php
                                        $sno++;
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </form>

                            <div class="row">
                                <div id="studentlist">

                                </div>
                            </div>
                        </div><!-- /.box -->


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.content -->
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
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '30%',
                        targets: 1
                    },
                    {
                        width: '25%',
                        targets:[2,3]
                    },
                    {
                        width: '10%',
                        targets:4,
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

<?php
if(isset($_REQUEST['examid'])) {
    $eid = $_REQUEST['examid'];
    ?>
    <input type="hidden" class="eid" value="<?php echo $eid;?>"/>
    <script>
        $(function() {
            var examid = $('.eid').val();
            $.ajax({
                url: "ajaxstudentmarkresult.php?examid=" + examid,
                context: document.body
            }).done(function(response) {
                $('#studentlist').html(response);
            });
        });
    </script>
<?php
}
?>

<script>
    $(function() {
        $('.viewExamBtn').click(function() {
            //$('#studentlist').toggle();
            var examid = $(this).val();
            $.ajax({
                url: "ajaxstudentmarkresult.php?examid=" + examid,
                context: document.body
            }).done(function (response) {
                $('#studentlist').html(response);
            });

            $('.datatable1').DataTable({

            });
        });
    });
</script>


</body>
</html>