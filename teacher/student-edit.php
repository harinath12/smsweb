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

$class_joining_sql="SELECT DISTINCT c.class_name FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1";
$class_joining_exe=mysql_query($class_joining_sql);
$class_joining_results = array();
while($row = mysql_fetch_assoc($class_joining_exe)) {
    array_push($class_joining_results, $row);
}

$stop_sql="SELECT * FROM `stopping_master` where stopping_status='1' order by stopping_name ASC";
$stop_exe=mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}

$studId = $_REQUEST['student_id'];

$student_sql="SELECT stu.*, aca.roll_number, aca.position, aca.sports, aca.extra_curricular, aca.achievements, c.class_name, s.section_name FROM `student_general` as stu
left join student_academic as aca on aca.admission_number = stu.admission_number
left join classes as c on c.id = aca.class
left join section as s on s.id = aca.section
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                <form class="form-horizontal" action="doeditstudentgeneral.php" id="addStudentForm" method="post" enctype="multipart/form-data">

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
                                    <a href="student-academic-edit.php?student_id=<?php echo $studId; ?>"><button type="button" class="form-control btn btn-info">Edit Student (Academic)</button></a>
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
                                        <label class="control-label col-lg-4">Student Name<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your name" name="studentName" value="<?php echo $student_fet['student_name']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Admission Number<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="admissionNum" value="<?php echo $student_fet['admission_number']; ?>" readonly required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">EMIS Number</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="emisNum" value="<?php echo $student_fet['emis_number'];?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" value="<?php echo $student_fet['dob']; ?>" id="datepicker1"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Joining</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="doj" value="<?php echo $student_fet['doj']; ?>" id="datepicker2"/>
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
                                            <?php $gend = strtolower($student_fet['gender']); ?>
                                            <input type="radio" name="gender" value="Male" <?php if($gend == 'male') {echo 'checked'; } ?> /> Male &nbsp;&nbsp;
                                            <input type="radio" name="gender" value="Female" <?php if($gend == 'female') {echo 'checked'; } ?> /> Female
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
                                        <label class="control-label col-lg-4">Nationality<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="nationality" class="form-control" value="<?php echo $student_fet['nationality']; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Religion<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion" value="<?php echo $student_fet['religion']; ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Community</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="community">
                                                <option value="FC" <?php if($student_fet['community'] == 'FC') { echo 'selected';} ?>>FC</option>
                                                <option value="BC" <?php if($student_fet['community'] == 'BC') { echo 'selected';} ?>>BC</option>
                                                <option value="MBC" <?php if($student_fet['community'] == 'MBC') { echo 'selected';} ?>>MBC</option>
                                                <option value="SC/ST" <?php if($student_fet['community'] == 'SC/ST') { echo 'selected';} ?>>SC/ST</option>
                                                <option value="OC" <?php if($student_fet['community'] == 'OC') { echo 'selected';} ?>>OC</option>
                                            </select>
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

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Vehicle</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="vehicle_by">
                                                <option value="">Select Vehicle</option>
                                                <option value="Self" <?php if($student_fet['vehicle_by'] == 'Self') { echo 'selected'; }?>>Self</option>
                                                <option value="Own Vehicle" <?php if($student_fet['vehicle_by'] == 'Own Vehicle') { echo 'selected'; }?>>Own Vehicle</option>
                                                <option value="School Vehicle" <?php if($student_fet['vehicle_by'] == 'School Vehicle') { echo 'selected'; }?>>School Vehicle</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Stop From</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="stop_from" id="stop_from">
                                                <option value="">Select Stop</option>
                                                <?php
                                                foreach($stop_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['stopping_name']; ?>" <?php if($student_fet['stop_from'] == $value['stopping_name']) { echo 'selected'; }?>><?php echo $value['stopping_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
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
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $student_fet['mobile']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(2)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile2" value="<?php echo $student_fet['mobile2']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(3)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile3" value="<?php echo $student_fet['mobile3']; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" value="<?php echo $student_fet['email']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="city" value="<?php echo $student_fet['city']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">State<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="state" id="state" required>
                                                <option value="">Select State</option>
                                                <?php
                                                foreach($state_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['state_name']; ?>" <?php if($student_fet['state'] == $value['state_name']){ echo 'selected'; } ?> ><?php echo strtoupper($value['state_name']); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Country<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="country" id="country">
                                                <option value="">Select Country</option>
                                                <?php
                                                foreach($country_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['name']; ?>" <?php if($student_fet['country'] == $value['name']){ echo 'selected'; } ?> ><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Pincode</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="pincode" value="<?php echo $student_fet['pincode']; ?>">
                                        </div>
                                    </div>

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
                                            <input type="file" class="form-control" name="studPhoto" accept="image/*">
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'dd-mm-yy'
        });
    } );
    $( function() {
        $( "#datepicker2").datepicker({
            dateFormat:'dd-mm-yy'
        });
    } );
</script>
</body>
</html>