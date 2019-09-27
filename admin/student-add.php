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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
</head>

<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Student
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Add Student</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doaddstudent.php" id="addStudentForm" method="post" enctype="multipart/form-data">

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
                                        <label class="control-label col-lg-4">Student Name<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your name" name="studentName" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Admission Number<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="admissionNum" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">EMIS Number</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="emisNum">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="dob" id="datepicker1"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Joining</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="doj" id="datepicker2"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class Joining</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="classJoining" id="classJoining">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_joining_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['class_name']; ?>"><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Gender<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="radio" name="gender" value="Male" /> Male &nbsp;&nbsp;
                                            <input type="radio" name="gender" value="Female" /> Female
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Father Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="fatherName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mother Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="motherName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nationality<span class="req"> *</span></label>
                                        <div class="col-lg-8 hidden">
                                            <select class="form-control" name="nationality" id="nationality">
                                                <option value="">Select Country</option>
                                                <?php
                                                foreach($country_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="nationality" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Religion<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Community</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="community">
                                                <option>Select Community</option>
                                                <option value="FC">FC</option>
                                                <option value="BC">BC</option>
                                                <option value="MBC">MBC</option>
                                                <option value="SC">SC</option>
                                                <option value="ST">ST</option>
                                                <option value="OC">OC</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Caste</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="caste">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Aadhar Number</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="aadharNumber">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Visible Mark</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="visibleMark"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Disability (If any)</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="disability"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Vehicle</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="vehicle_by">
                                                <option value="">Select Vehicle</option>
                                                <option value="Self">Self</option>
                                                <option value="Own Vehicle">Own Vehicle</option>
                                                <option value="School Vehicle">School Vehicle</option>
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
                                                    <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
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
                                            <input type="number" class="form-control" maxlength="10" name="mobile">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(2)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile2">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile(3)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile3">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="city" id="city" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">State<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="state" id="state" required>
                                                <option value="">Select State</option>
                                                <?php
                                                foreach($state_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['state_name']; ?>"><?php echo strtoupper($value['state_name']); ?></option>
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
                                                    <option value="<?php echo $value['name']; ?>"><?php echo $value['name']; ?></option>
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
                                            <input type="number" class="form-control" maxlength="10" name="pincode">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Permanent Address<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="permanentAddress"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Temporary Address<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" name="tempAddress"></textarea>
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
                                            <input type="number" class="form-control" name="rollNo">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="className" id="classId">
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Section<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control sectionName" name="sectionName" id="sectionId">
                                                <option value="">Select Section</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Sports</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="sportsDetails"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Position</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="position">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Extra Curricular Activities</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="extraCurricular"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Achievements</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" cols="5" class="form-control" name="achievements"></textarea>
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
                                            <input type="file" class="form-control" name="studPhoto">
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
                                            <input type="file" class="form-control" name="aadharProof"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="submit" value="ADD STUDENT" class="btn btn-info form-control"/>
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
        });
    });
</script>
</body>
</html>