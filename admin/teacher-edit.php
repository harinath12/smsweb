<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$class_joining_sql="SELECT DISTINCT c.class_name FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1";
$class_joining_exe=mysql_query($class_joining_sql);
$class_joining_results = array();
while($row = mysql_fetch_assoc($class_joining_exe)) {
    array_push($class_joining_results, $row);
}

/*
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

$city_sql="SELECT * FROM `cities` where `city_status`=1";
$city_exe=mysql_query($city_sql);
$city_results = array();
while($row = mysql_fetch_assoc($city_exe)) {
    array_push($city_results, $row);
}

$state_sql="SELECT * FROM `states` where `state_status`=1";
$state_exe=mysql_query($state_sql);
$state_results = array();
while($row = mysql_fetch_assoc($state_exe)) {
    array_push($state_results, $row);
}

$country_sql="SELECT * FROM `countries` where `country_status`=1";
$country_exe=mysql_query($country_sql);
$country_results = array();
while($row1 = mysql_fetch_assoc($country_exe)) {
    array_push($country_results, $row1);
}
*/

$teacherId = $_REQUEST['teacher_id'];

$student_sql="SELECT tea.*, aca.department, aca.position, aca.post_details, aca.class_teacher, aca.subject, aca.class_handling FROM `teacher_general` as tea
left join teacher_academic as aca on aca.emp_no = tea.emp_no
where tea.user_id = $teacherId";
$student_exe=mysql_query($student_sql);
$student_fet = mysql_fetch_assoc($student_exe);
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
                Teacher Edit
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="teacher-list.php">Teacher List</a></li>
                <li class="active">Teacher Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doeditteachergeneral.php" id="addStudentForm" method="post" enctype="multipart/form-data">

                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Teacher Info updated Successfully</strong>
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
                                    <a href="reset-password.php?teacher_id=<?php echo $teacherId; ?>"><button type="button" class="form-control btn btn-info">Reset Password</button></a>
                                </div>
                                <div class="col-md-3" style="float: right">
                                    <a href="teacher-academic-edit.php?teacher_id=<?php echo $teacherId; ?>"><button type="button" class="form-control btn btn-info">Edit Teacher (Academic)</button></a>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Personal Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Teacher Name<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your name" name="teacherName" value="<?php echo $student_fet['teacher_name']; ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Emp No.<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="empNo" value="<?php echo $student_fet['emp_no']; ?>" readonly required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="dob" value="<?php echo $student_fet['dob']; ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Joining</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="doj" value="<?php echo $student_fet['doj']; ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class Joining</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="classJoining" id="classJoining">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_joining_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['class_name']; ?>" <?php if($student_fet['class_joining'] == $value['class_name']){ echo 'selected'; } ?> ><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Gender<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="radio" name="gender" value="Male" <?php if($student_fet['gender'] == 'Male') {echo 'checked'; } ?> /> Male &nbsp;&nbsp;
                                            <input type="radio" name="gender" value="Female" <?php if($student_fet['gender'] == 'Female') {echo 'checked'; } ?> /> Female
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Father Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="fatherName" value="<?php echo $student_fet['father_name']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mother Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="motherName" value="<?php echo $student_fet['mother_name']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Qualification</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="qualification" value="<?php echo $student_fet['qualification']; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Experience</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="experience"><?php echo $student_fet['experience']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nationality<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="nationality" class="form-control" value="<?php echo $student_fet['nationality']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Religion<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion" value="<?php echo $student_fet['religion']; ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Caste</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="caste" value="<?php echo $student_fet['caste']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Aadhar Number</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="aadharNumber" value="<?php echo $student_fet['aadhar_number']; ?>"  />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Visible Mark</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="visibleMark"><?php echo $student_fet['visible_mark']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Disability (If any)</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="disability"><?php echo $student_fet['disability']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Contact Details
                                </h4>
                            </div>

                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile']; ?>" required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(2)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile2" value="<?php echo $student_fet['mobile2'];?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(3)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile3" value="<?php echo $student_fet['mobile3'];?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" value="<?php echo $student_fet['email']; ?>" required readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Permanent Address<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="permanentAddress"><?php echo $student_fet['permanent_address']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Temporary Address<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="tempAddress"><?php echo $student_fet['temporary_address']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Attachments
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Photo</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="teacherPhoto">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="dobProof">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Community (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="communityProof">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Address (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="addressProof">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Aadhar Card</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="aadharProof">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="hidden" name="teacherId" value="<?php echo $student_fet['user_id']; ?>">
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