<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/* $className = null;
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
$classId = $cls_fet['id']; */

$markid = $_REQUEST['id'];

$mark_sql = "select sm.*, ett.exam_name, c.class_name from student_mark as sm
left join exam_time_table as ett on ett.id=sm.exam_id
left join classes as c on c.id=sm.classid
where sm.id='$markid'";
$mark_exe = mysql_query($mark_sql);
$mark_fet = mysql_fetch_array($mark_exe);

$classId = $mark_fet['classid'];
$sectionName = $mark_fet['section_name'];
$exam = $mark_fet['exam_id'];
$sub = $mark_fet['subject_name'];

$cls_sql="SELECT * FROM `classes` where id='$classId'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$className = $cls_fet['class_name'];

$student_exe = mysql_query("SELECT gen.student_name, gen.admission_number, sm.subject_name, sm.mark, sm.remarks, sm.id as student_mark_id, gen.user_id FROM student_general AS gen
LEFT JOIN student_academic AS aca ON aca.user_id = gen.user_id
LEFT JOIN users AS u ON u.id = gen.user_id
left JOIN student_mark AS sm ON sm.student_id = gen.user_id and sm.subject_name='$sub' and sm.exam_id='$exam'
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1' ");

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
                        <li class="active">Mark View</li>
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
                                <form action="doeditmarkentry.php" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Exam Name </label>
                                                <div class="col-lg-8">
                                                    <input type="text" value="<?php echo $mark_fet['exam_name'];?>" class="form-control" readonly />
                                                    <input type="hidden" class="form-control" name="examName" value="<?php echo $mark_fet['exam_id'];?>" readonly/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Subject Name </label>
                                                <div class="col-lg-8">
                                                    <input type="text" value="<?php echo $mark_fet['subject_name'];?>" class="form-control" name="subjectName" readonly />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Class</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="className" id="className" value="<?php echo $className;?>" readonly/>
                                                    <input type="hidden" class="form-control" name="classId" value="<?php echo $classId;?>" readonly/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Section</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Student Name</th>
                                            <th>Admission Number</th>
                                            <th>Marks</th>
                                            <th>Remarks</th>
                                        </tr>
                                        <?php
                                        $sno =1;
                                        while($student_fet = mysql_fetch_assoc($student_exe)){
                                            ?>
                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $student_fet['student_name']; ?></td>
                                                <td><?php echo $student_fet['admission_number']; ?></td>
                                                <td><input type="number" name="marks[]" value="<?php if($student_fet['mark'] != 0){ echo $student_fet['mark']; }?>"/> </td>
                                                <td><input type="text" name="remarks[]" value="<?php echo $student_fet['remarks']; ?>"/></td>
                                                <input type="hidden" name="markId[]" value="<?php echo $student_fet['student_mark_id']; ?>" />
                                                <input type="hidden" name="studentid[]" value="<?php echo $student_fet['user_id']; ?>" />
                                            </tr>
                                            <?php
                                            $sno++;
                                        }
                                        ?>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-lg-2">
                                                    <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                                                </div>
                                            </div>
                                        </div>
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
<!-- /page container -->

</body>
</html>