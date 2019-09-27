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

$mark_sql = "select sm.*, ett.exam_name, c.class_name from student_mark as sm
left join exam_time_table as ett on ett.id=sm.exam_id
left join classes as c on c.id=sm.classid
where sm.teacher_id='$user_id' and exam_status='1' group by exam_id, subject_name, classid,section_name";
$mark_exe = mysql_query($mark_sql);
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
                        <li class="active">Marks List</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Marks inserted Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <a href="mark-entry.php">
                                        <button type="button" class="form-control btn btn-info">Enter Marks</button>
                                    </a>
                                </div>
                            </div>

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
                                            <td><?php echo $mark_fet['subject_name']; ?></td>
                                            <td>
                                                <a href="marks-view.php?id=<?php echo $mark_fet['id']; ?>" title="View">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-eye"></i></button>
                                                </a>
                                                <a href="marks-edit.php?id=<?php echo $mark_fet['id']; ?>" title="Edit">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                                                </a>
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
                                autoWidth: true,
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

<script>
    $(function() {
        $('#addHomeWorkBtn').click(function() {
            $('#addHomeWork').toggle();
            $('#editHomeWork').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.editHomeWorkBtn').click(function() {
            $('#addHomeWork').hide();
            $('#editHomeWork').toggle();
            var id = $(this).siblings('.homeworkId').val();
            $.ajax({
                url: "ajax-edit-home-work.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editHomeWork').html(response);
            });
        });
    });
</script>
<script type="text/javascript">
    function show_confirm() {
        var txt = 'HI';
        var className_Message =  'Class::'+$('#className').val();
        var sectionName_Message =  'Section::'+$('#sectionName').val();
        var subjectName_Message =  'Subject::'+$('#subjectId').val();
        var period_Message =  'Period::'+$('#period').val();
        var title_Message =  'Title::'+$('#title').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to add the Home Work?'+'\n'+className_Message+'\n'+sectionName_Message+'\n'+subjectName_Message+'\n'+period_Message+'\n'+title_Message+'\n'+details_Message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
</body>
</html>