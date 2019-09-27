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
//print_r($teacher_fet);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$classHandling = $teacher_fet['class_handling'];
$clsteacherhandling = explode(",", $classHandling);
$clsteacherhandling_array=array_map('trim',$clsteacherhandling);
//print_r($clsteacherhandling_array); exit;

$subjectHandling = $teacher_fet['subject'];
$sbjteacherhandling = explode(",", $subjectHandling);
$sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);
//print_r($sbjteacherhandling_array);

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql = "SELECT distinct subject_name FROM exam_date_subject WHERE class_id = '$classId' or class_id='100'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 AND (class_id='$classId' OR class_id='100') GROUP BY exam_name";
$exam_exe=mysql_query($exam_sql);
$exam_results = array();
while($row = mysql_fetch_assoc($exam_exe)) {
    array_push($exam_results, $row);
}
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
                        <li><a href="marks-list.php">Marks List</a></li>
                        <li class="active">Mark Entry</li>
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
                                <form action="dostudentmarkentry.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                                <div class="col-lg-8">
                                                    <?php if(empty($classHandling)) { ?>
                                                        <input type="text" class="form-control className" name="className" id="className" value="<?php echo $className;?>" readonly/>
                                                    <?php } else { ?>
                                                        <select class="form-control className" name="className" id="className" required>
                                                            <option value="">Select Class</option>
                                                            <?php
                                                            foreach($clsteacherhandling_array as $key => $value){ ?>
                                                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
<?php  ?>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Section <span class="req"> *</span></label>
                                                <div class="col-lg-8">
                                                    <?php if(!empty($sectionName)){
                                                        if(($classId > 1) && ($classId < 9) ){
                                                            ?>
                                                            <input type="text" class="form-control sectionName" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                                        <?php } else { if(empty($classHandling)) { ?>
                                                            <input type="text" class="form-control sectionName" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                                        <?php } else { ?>
                                                            <select class="form-control sectionName" name="sectionName" id="sectionName" required>
                                                                <option value="">Select Section</option>
                                                            </select>
                                                        <?php } }
                                                    } else { ?>
                                                           <select class="form-control sectionName" name="sectionName" id="sectionName" required>
                                                                <option value="">Select Section</option>
                                                            </select>
                                                     
                                                    <?php } ?>
                                                </div>
                                            </div>
<?php /*  ?>                                            
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Section <span class="req"> *</span></label>
                                                <div class="col-lg-8">
                                                    <?php if(empty($classHandling)) { ?>
                                                        <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                                    <?php } else { ?>
                                                        <select class="form-control sectionName" name="sectionName" id="sectionName" required>
                                                            <option value="">Select Section</option>
                                                        </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
<?php */ ?>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Exam Name <span class="req"> *</span> </label>
                                                <div class="col-lg-8">
                                                    <select class="form-control examName" name="examName" id="examId" required>
                                                        <option value="">Select Exam</option>
                                                        <?php
                                                        foreach($exam_results as $key => $value){ ?>
                                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['exam_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Subject Name <span class="req"> *</span> </label>
                                                <div class="col-lg-8">
                                                    <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                        foreach($sbjteacherhandling_array as $key => $value){ ?>
                                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php /* ?>
                                                    <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                        <option value="">Select Subject</option>
                                                        <?php
                                                        foreach($sub_results as $key => $value){ ?>
                                                            <option value="<?php echo $value['subject_name']; ?>"><?php echo $value['subject_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php */ ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="studentlist">

                                    </div>
                                </form>
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
<script>
    $(function() {
        $('.className').change(function() {
            var clsId = $('#className').val();
            $('#sectionName').empty();
            $('#examId').empty();

            $.get('ajaxsection.php', {cid: clsId}, function(result){
                var sublist = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.section_name + "'>" + item.section_name + "</option>";
                });
                $("#sectionName").html(sublist);
            });
            $.get('ajaxexamtimetable.php', {cid: clsId}, function(result){
                var examlist = "<option value=''>Select Exam</option>";
                $.each(JSON.parse(result), function(i,item) {
                    examlist = examlist + "<option value='" + item.exam_id + "'>" + item.exam_name + "</option>";
                });
                $("#examId").html(examlist);
            });
        });
    });
</script><!-- /page container -->



<script>
    $(function() {
        $('.sectionName').change(function() {
            var className = $('.className').val();
            var sectionName = $('.sectionName').val();
            $.ajax({
                url: "ajax-student-list-for-mark.php?className=" + className + "&section=" + sectionName,
                context: document.body
            }).done(function(response) {
                $('#studentlist').html(response);
            });
        });
    });

    $(function() {
        $('.subjectName').change(function() {
            var className = $('.className').val();
            var sectionName = $('.sectionName').val();
            $.ajax({
                url: "ajax-student-list-for-mark.php?className=" + className + "&section=" + sectionName,
                context: document.body
            }).done(function(response) {
                $('#studentlist').html(response);
            });
        });
    });
</script>

</body>
</html>