<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}

$subject_sql="SELECT * FROM `subject_master` where subject_status=1";
$subject_exe=mysql_query($subject_sql);
$subject_results = array();
while($row = mysql_fetch_assoc($subject_exe)) {
    array_push($subject_results, $row);
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
                        <h4><i class="fa fa-th-large position-left"></i> ADD PROJECT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="project-list.php">Project</a></li>
                        <li class="active">Add Project</li>
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
                                Project Details
                            </h4>
                        </div>
                        <div class="panel-body">

                            <form action="doaddproject.php" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Title</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="title" value=""/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="className" id="className" value="<?php echo $className;?>" readonly/>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Subject</label>
                                        <div class="col-lg-8">
                                            <select class="form-control subjectName" name="subjectName" id="subjectId" required>
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
                                    </br>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Period</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="period" id="period">
                                                <option value="">Select Period</option>
                                                <option value="I">I</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                                <option value="V">V</option>
                                                <option value="VI">VI</option>
                                                <option value="VII">VII</option>
                                                <option value="VIII">VIII</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Project Details</label>
                                        <div class="col-lg-8">
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Project File(1)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="project1" value=""/>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Project File(2)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="project2" value=""/>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Project File(3)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="project3" value=""/>
                                        </div>
                                    </div>
                                    </br>

                                    <div class="form-group">
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
<script type="text/javascript">
    function show_confirm() {
        var className_Message =  'Class::'+$('#className').val();
        var sectionName_Message =  'Section::'+$('#sectionName').val();
        var subjectName_Message =  'Subject::'+$('#subjectId').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to add the Project?'+'\n'+className_Message+'\n'+sectionName_Message+'\n'+subjectName_Message+'\n'+details_Message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<script>
    $(function() {
        $('#classId').change(function() {
            $('#sectionId').empty();
            $.get('sectionscript.php', {region: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionId").html(list);
            });

            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var sublist = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(sublist);
            });
        });
    });
</script>
</body>
</html>