<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

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

$studId = $_REQUEST['student_id'];

$student_sql="SELECT stu.*, aca.roll_number, aca.class, aca.section, aca.position, aca.sports, aca.extra_curricular, aca.achievements, c.class_name, aca.section_name FROM `student_general` as stu
left join student_academic as aca on aca.admission_number = stu.admission_number
left join classes as c on c.id = aca.class
where stu.user_id = $studId";
$student_exe=mysql_query($student_sql);
$student_fet = mysql_fetch_assoc($student_exe);
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
        .req, .error{
            color : red;
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
                        <h4><i class="fa fa-th-large position-left"></i> STUDENT EDIT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="student.php">Student</a></li>
                        <li class="active">Student Edit</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doeditstudentacademic.php" id="addStudentForm" method="post" enctype="multipart/form-data">

                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Info updated Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>

                    <div class="row">
                        <div class="panel panel-flat">
                            </br>
                            <div class="row">
                                <div class="col-md-3" style="float: right">
                                    <a href="student-edit.php?student_id=<?php echo $studId; ?>"><button type="button" class="form-control btn btn-info">Edit Student (General)</button></a>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Academic Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Roll No.</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="rollNo" value="<?php echo $student_fet['roll_number']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="" value="<?php echo $student_fet['class_name']; ?>" readonly />
                                            <input type="hidden" class="form-control" name="className" value="<?php echo $student_fet['class']; ?>" readonly />
                                            <?php /* ?>
                                            <select class="form-control" name="className" id="className">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($student_fet['class'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <?php */ ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="sectionName" value="<?php echo $student_fet['section_name']; ?>" readonly />
                                            <?php /* ?>
                                            <select class="form-control" name="sectionName" id="sectionName">
                                                <option value="">Select Section</option>
                                                <?php
                                                foreach($section_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"  <?php if($student_fet['section'] == $value['id']) { echo 'selected'; } ?> ><?php echo $value['section_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
 <?php */ ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Sports</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="sportsDetails"><?php echo $student_fet['sports']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Position</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="position" value="<?php echo $student_fet['position']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Extra Curricular Activities</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="extraCurricular"><?php echo $student_fet['extra_curricular']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Achievements</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="achievements"><?php echo $student_fet['achievements']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="hidden" name="studentId" value="<?php echo $student_fet['user_id']; ?>">
                            <input type="submit" value="SUBMIT" class="btn btn-info form-control"/>
                        </div>
                    </div>
                </form>
                <!-- /form horizontal -->
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