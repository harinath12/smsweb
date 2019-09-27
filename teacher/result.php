<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$examid =null;
if(isset($_REQUEST['examid']))
{
    $examid = $_REQUEST['examid'];
}

$exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 AND (class_id='$classId' OR class_id='100') GROUP BY exam_name";
$exam_exe=mysql_query($exam_sql);
$exam_cnt = mysql_num_rows($exam_exe);
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li>Result</li>
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
                                <table id="" class="datatable">
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