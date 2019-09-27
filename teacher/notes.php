<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT distinct c.* FROM `class_section` as cs LEFT JOIN classes as c on c.id = cs.class_id where c.class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

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

$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
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
        span.req{
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
                        <h4><i class="fa fa-th-large position-left"></i> NOTES</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Notes</li>
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
                                Notes
                            </h4>
                        </div>
                        <div class="panel-body">

                            <form action="notes-view.php" method="post">
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
                                            <select class="form-control subjectName" name="subjectName" id="subjectId">
                                                <option value="">Select Subject</option>
                                                <?php
                                                foreach($sub_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['subject_name']; ?>"><?php echo $value['subject_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="term" id="term" required>
                                                <option value="">Select Term</option>
                                                <option value="Term 1">Term 1</option>
                                                <option value="Term 2">Term 2</option>
                                                <option value="Term 3">Term 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control chapterName" name="chapter" id="chapter" required>
                                                <option value="">Select Chapter</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" name="chapter" value="" required/> -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Question Type <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="questionType" id="questionType" required>
                                                <option value="">Select Question Type</option>
                                                <option value="1">Only Questions</option>
                                                <option value="2">Question & Answer</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-2">
                                            <input type="submit" value="OK" class="btn btn-info form-control"/>
                                        </div>
                                    </div>
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
</html>

<script>
    /*$(function() {
        $('#classId').change(function() {
            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var sublist = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(sublist);
            });
        });
    });*/
</script>

<script>
    $(function() {
        $('#term').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#subjectId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        /*$('#classId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });*/
    });
</script>