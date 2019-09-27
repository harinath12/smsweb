<?php session_start();
ob_start();
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
$classId= $student_fet['class'];
$section_name = $student_fet['section_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <title>Admin Panel</title>
    <?php include "head1.php"; ?>
</head>

<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Student Edit
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="students-list.php?classId=<?php echo $classId; ?>&sectionName=<?php echo $section_name;?>">Student List</a></li>
                <li class="active">Student Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
                                            <select class="form-control" name="className" id="className">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($student_fet['class'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="sectionName" value="<?php echo $student_fet['section_name']; ?>" />
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
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>
<!-- page script -->
</body>
</html>