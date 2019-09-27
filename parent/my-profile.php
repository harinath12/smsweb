<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$student_sql="SELECT stu.*, aca.roll_number, aca.position, aca.sports, aca.extra_curricular, aca.achievements, c.class_name, s.section_name FROM `student_general` as stu
left join student_academic as aca on aca.admission_number = stu.admission_number
left join classes as c on c.id = aca.class
left join section as s on s.id = aca.section
where stu.user_id = '$user_id'";
$student_exe=mysql_query($student_sql);
$student_fet = mysql_fetch_assoc($student_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> MY PROFILE</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">My Profile</li>
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
                                Personal Details
                            </h4>
                        </div>
                        <div class="panel-body">
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Nationality</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="nationality" value="<?php echo $student_fet['nationality'];?>" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Religion</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="religion" value="<?php echo $student_fet['religion'];?>" readonly />
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

                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Mobile</label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile'];?>" readonly />
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

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Pincode</label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" name="pincode" value="<?php echo $student_fet['pincode'];?>" readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
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
                        <div class="panel-body">
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
                                    <label class="control-label col-lg-4">Section<span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" value="<?php echo $student_fet['section_name'];?>" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Sports</label>
                                    <div class="col-lg-8">
                                        <textarea rows="3" cols="5" class="form-control" name="sportsDetails"><?php echo $student_fet['sports'];?></textarea>
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
                                        <textarea rows="3" cols="5" class="form-control" name="extraCurricular"><?php echo $student_fet['extra_curricular'];?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Achievements</label>
                                    <div class="col-lg-8">
                                        <textarea rows="3" cols="5" class="form-control" name="achievements"><?php echo $student_fet['achievements'];?></textarea>
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
                        <div class="panel-body">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Photo</label>
                                    <div class="col-lg-8">
                                        <?php if($student_fet['photo'] != null){
                                            ?>
                                            <img src="<?php echo '../admin/' . $student_fet['photo'];?>" style="width:100px; height:100px;"/>
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