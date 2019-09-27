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

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$ques_sql = "select q.*, c.class_name from aptitude_question_bank as q
left join classes as c on c.id = q.class_id
where question_bank_status='1' and class_id='$classId' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Aptitude Question Bank</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Questions inserted Successfully</strong>
                            </div>
                        <?php
                        }
                        else  if ($_REQUEST['succ'] == 2) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Questions imported Successfully</strong>
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
                                <div class="col-md-6"></div>
                                <div class="col-md-3" style="float: right">
                                    <a href="aptitude-questionbankimport.php"><button type="button" class="form-control btn btn-info">Import Aptitude Question Bank</button></a>
                                </div>
                                <div class="col-md-3" style="float: right">
                                    <a href="aptitude-questionbankadd.php"><button type="button" class="form-control btn btn-info">Create Aptitude Question Bank</button></a>
                                </div>
                            </div>
                            </br>
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>CLASS</th>
                                    <th>SUBJECT</th>
                                    <th>CHAPTER</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <?php
                                if($ques_cnt>0)
                                {
                                    ?>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($ques_fet=mysql_fetch_array($ques_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $ques_fet['class_name']; ?></td>
                                            <td><?php echo $ques_fet['subject_name'] ?></td>
                                            <td><?php echo $ques_fet['chapter']; ?></td>
                                            <td class="text-center">
                                                <ul class="icons-list">
                                                    <li><a href="aptitude-questionbankview.php?question_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="aptitude-questionbankedit.php?question_id=<?php echo $ques_fet['id']; ?>" title="Edit"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;

                                                    <?php /* ?>
 <li><a href="excelphp.php?question_id=<?php echo $ques_fet['id']; ?>" title="Download"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-download"></i></button></a></li>&nbsp;&nbsp;
 <li><a href="question-bank-view.php?question_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="question-bank-edit.php?question_id=<?php echo $ques_fet['id']; ?>" title="Edit"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="question-bank-chapter-edit.php?question_id=<?php echo $ques_fet['id']; ?> ?>" title="Edit Chapter"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
 <li>
                                                        <form action="pdf/question-bank.php" method="post">
                                                            <input type="hidden" name="questionId" value="<?php echo $ques_fet['id']; ?>"/>
                                                            <input type="hidden" name="clsName" value="<?php echo $className; ?>"/>
                                                            <button type="submit" class="btn btn-info btn-xs" title="Download"><i class="fa fa-download"></i></button>
                                                        </form>
                                                    </li>&nbsp;&nbsp;
                                                    <?php */?>

                                                </ul>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table>
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
                                        width: '10%',
                                        targets: 0
                                    },
                                    {
                                        width: '15%',
                                        targets:[1,2,3]
                                    },
                                    {
                                        width: '20%',
                                        targets: 4,
                                        orderable: false
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