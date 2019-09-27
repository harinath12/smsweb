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

$stud_sql = "SELECT gen.user_id, gen.student_name, aca.class, aca.section_name FROM student_academic as aca
LEFT JOIN student_general as gen on gen.user_id = aca.user_id
LEFT JOIN users as usr on usr.id = gen.user_id
WHERE aca.class = '$classId' and aca.section_name='$sectionName' and usr.delete_status='1'";
$stud_exe = mysql_query($stud_sql);
$stud_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    array_push($stud_results, $row);
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
                        <h4><i class="fa fa-th-large position-left"></i> ADD TEACHER REMARKS</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="teacher-remarks.php">Teacher Remarks</a></li>
                        <li class="active">Add Teacher Remarks</li>
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
                                Remark Details
                            </h4>
                        </div>
                        <div class="panel-body">
                            <form action="doaddremarks.php" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <label class="control-label col-lg-4">Student</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="studentId[]" id="studentId" multiple required>
                                                <option value="">Select Student</option>
                                                <option value="all">All</option>
                                                <?php
                                                foreach($stud_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['student_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" class="form-control" name="studentName" id="studentName" value=""/>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="control-label col-lg-4">Title</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="title" id="title" value="" required/>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="control-label col-lg-4">Remarks Type</label>
                                        <div class="col-lg-8">
                                            <input type="radio" name="remarksType" class="remarksType" value="Text"/> Text &nbsp;&nbsp;
                                            <input type="radio" name="remarksType" class="remarksType" value="Audio"/> Audio
                                        </div>
                                    </div>

                                    <div class="row form-group" id="remarksText" style="display:none;">
                                        <label class="control-label col-lg-4">Remarks Details</label>
                                        <div class="col-lg-8">
                                            <textarea name="remark_details" id="remark_details" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="row form-group" id="remarksAudio" style="display:none;">
                                        <label class="control-label col-lg-4">Attachment</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="remarkFile" accept="audio/*">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <input type="submit" value="ADD" class="btn btn-info form-control" onclick="return show_confirm();"/>
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

<script type="text/javascript">
    $(function() {
        $('#studentId').change(function() {
            var studId =  $('#studentId').val();
            $.get('ajax-student-name.php', {studid: studId}, function(result){
                $("#studentName").val(result.trim());
            });
        });
    });

    function show_confirm() {
        //var remark_details_Message =null;
        var title_Message =  'Title::'+$('#title').val();
        var studentName_Message =  'Student Name::'+$('#studentName').val().trim();
        if($('#remark_details').val()){
            var remark_details_Message =  'Remarks::'+$('#remark_details').val();
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message+'\n'+remark_details_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else{
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
</script>

<script>
    $(function() {
        $('.remarksType').change(function() {
            var rType = $('input[name="remarksType"]:checked').val();
            if(rType == 'Text'){
                $('#remarksAudio').hide();
                $('#remarksText').show();
            }
            else if(rType == 'Audio'){
                $('#remarksText').hide();
                $('#remarksAudio').show();
            }
        });
    });
</script>