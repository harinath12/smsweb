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

$questionbank_id = $_REQUEST['question_id'];

$ques_sql="SELECT * FROM `question_bank` where id='$questionbank_id'";
$ques_exe=mysql_query($ques_sql);
$ques_fet = mysql_fetch_assoc($ques_exe);
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
                        <h4><i class="fa fa-th-large position-left"></i> QUESTION BANK EDIT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="question-bank.php">Question Bank</a></li>
                        <li class="active">Question Bank Edit</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Question Details
                            </h4>
                        </div>
                        <div class="panel-body">
                            <form action="docreatequestionbank.php" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="className" value="<?php echo $className;?>" readonly/>
                                                <input type="hidden" class="form-control" name="classId" id="classId" value="<?php echo $classId;?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="subjectName" value="<?php echo $ques_fet['subject_name'];?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="term" value="<?php echo $ques_fet['term'];?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="chapter" value="<?php echo $ques_fet['chapter'];?>" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Question Type <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="questionType" id="questionType" required>
                                                    <option value="">Select Question Type</option>
                                                    <option value="Meaning">Meaning</option>
                                                    <option value="Opposite">Opposite</option>
                                                    <option value="Fill up">Fill up</option>
                                                    <option value="Choose">Choose</option>
                                                    <option value="True or False">True or False</option>
                                                    <option value="Match">Match</option>
                                                    <option value="One or Two words">One or Two words</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" style="display: none;" id="othertype">
                                            <label class="control-label col-lg-4">Other Type</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="otherType" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="questions">

                                </div>

                            </form>

                        </div>
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
</body>

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
                        width: '20%',
                        targets: 0
                    },
                    {
                        width: '40%',
                        targets:[ 1,2]
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

<script>
    $(function() {
        $('#questionType').change(function() {
            var qtype = $('#questionType').val();
            if(qtype == 'Other'){
                $('#othertype').show();
            }
            else{
                $('#othertype').hide();
            }

            $.ajax({
                url: "ajax-questions.php?qtype=" + qtype,
                context: document.body
            }).done(function(response) {
                $('#questions').html(response);
            });
        });
    });
</script>
</html>
