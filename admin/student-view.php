<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$studId = $_REQUEST['student_id'];

$student_sql="SELECT stu.*, aca.roll_number, aca.position, aca.sports, aca.extra_curricular, aca.achievements, c.class_name, aca.class, aca.section_name FROM `student_general` as stu
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
                Student View
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="students-list.php?classId=<?php echo $classId; ?>&sectionName=<?php echo $section_name;?>">Student List</a></li>

                <li class="active">Student View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="" id="addStudentForm" method="post" enctype="multipart/form-data">
                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Info inserted Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Personal Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Student Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="studentName" value="<?php echo $student_fet['student_name']; ?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Admission Number</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="admissionNum" value="<?php echo $student_fet['admission_number'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">EMIS Number</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="allIndiaNum" value="<?php echo $student_fet['emis_number'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" value="<?php echo $student_fet['dob'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Joining</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="doj" value="<?php echo $student_fet['doj'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class Joining</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="classJoining" value="<?php echo $student_fet['class_joining'];?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Gender</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="gender" class="form-control" value="<?php echo $student_fet['gender'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Father Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="fatherName" value="<?php echo $student_fet['father_name'];?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mother Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="motherName" value="<?php echo $student_fet['mother_name'];?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nationality</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="nationality" value="<?php echo $student_fet['nationality'];?>" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Religion</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion" value="<?php echo $student_fet['religion'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Community</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="community" value="<?php echo $student_fet['community'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Caste</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="caste" value="<?php echo $student_fet['caste'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Aadhar Number</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="aadharNumber" value="<?php echo $student_fet['aadhar_number'];?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Visible Mark</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="visibleMark" readonly><?php echo $student_fet['visible_mark'];?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Disability (If any)</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="disability" readonly><?php echo $student_fet['disability'];?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Vehicle</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="nationality" value="<?php echo $student_fet['vehicle_by'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Stop From</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="nationality" value="<?php echo $student_fet['stop_from'];?>" readonly />
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
                                        <label class="control-label col-lg-4">Mobile</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(2)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile2'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(3)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile3'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" value="<?php echo $student_fet['email'];?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="city" value="<?php echo $student_fet['city'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">State</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="state" value="<?php echo $student_fet['state'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Country</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="country" value="<?php echo $student_fet['country'];?>" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Pincode</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="pincode" value="<?php echo $student_fet['pincode'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Permanent Address</label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="permanentAddress" readonly><?php echo $student_fet['permanent_address']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Temporary Address</label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="tempAddress" readonly> <?php echo $student_fet['temporary_address']; ?></textarea>
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
                                    Academic Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Roll No.</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="rollNo" value="<?php echo $student_fet['roll_number'];?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="<?php echo $student_fet['class_name'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="<?php echo $student_fet['section_name'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Sports</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="sportsDetails" readonly><?php echo $student_fet['sports'];?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Position</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="position" value="<?php echo $student_fet['position'];?>" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Extra Curricular Activities</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="extraCurricular" readonly><?php echo $student_fet['extra_curricular'];?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Achievements</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="achievements" readonly><?php echo $student_fet['achievements'];?></textarea>
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
                                            <?php if($student_fet['photo'] != null){
                                                ?>
                                                <img src="<?php echo $student_fet['photo'];?>" style="width:100px; height:100px;"/>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Date of Birth (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="dobProof">
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Community (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="communityProof">
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Address (Proof)</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="addressProof">
                                        </div>
                                    </div>
                                </div>
                            </div>
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