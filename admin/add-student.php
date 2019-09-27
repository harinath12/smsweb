<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$class_sql="SELECT DISTINCT c.* FROM `classes` as c
LEFT JOIN `class_section` as cs ON cs.class_id = c.id
where c.class_status=1 and cs.class_section_status=1 and cs.school_id=$user_id";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$section_sql="SELECT DISTINCT s.* FROM `section` as s
LEFT JOIN `class_section` as cs ON cs.section_id = s.id
where s.section_status=1 and cs.class_section_status=1 and cs.school_id=$user_id";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MySkoo - Add Student</title>
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
                        <h4><i class="fa fa-pencil position-left"></i> ADD STUDENT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="student.php">Student</a></li>
                        <li class="active">Add Student</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doaddstudent.php" id="addStudentForm" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        Personal Details
                                    </h4>
                                </div>
                                <div class="panel-body no-padding-bottom">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">First Name<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your first name"name="firstName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Last Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your last name" name="lastName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="className" id="className">
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
                                            <select class="form-control" name="sectionName" id="sectionName">
                                                <option value="">Select Section</option>
                                                <?php
                                                foreach($section_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['section_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="dob"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Gender<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select name="gender" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Blood Group</label>
                                        <div class="col-lg-8">
                                            <select name="bloodGroup" class="form-control">
                                                <option>Select your Blood Group</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Nationality<span class="req"> *</span></label>
                                        <div class="col-lg-8">
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
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Language</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="language">
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Religion<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Photo</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="studPhoto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        Contact Details
                                    </h4>
                                </div>

                                <div class="panel-body no-padding-bottom">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Mobile<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="mobile">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email">
                                            <span class="error" id="emailstatus"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Address<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Address" name="address"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="cityId" id="cityId">
                                                <option value="">Select City</option>
                                                <?php
                                                foreach($city_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['city_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">State<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="state" id="state" required>
                                                <option value="">Select State</option>
                                                <?php
                                                foreach($state_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo strtoupper($value['state_name']); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Country<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="countryId" id="countryId">
                                                <option value="">Select Country</option>
                                                <?php
                                                foreach($country_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Pincode</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="pincode">
                                        </div>
                                    </div>

                                    <div class="form-group hidden">
                                        <label class="control-label col-lg-4">Telephone</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" name="telephone">
                                        </div>
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
                <!-- Content area -->

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

<?php /* ?>
<script>
    $("input#email1").change(function(){
        var email = $("input#email").val();
        var BASEURL = "http://localhost/eSchool/webapp/";
        var status = 1;
        var callurl = BASEURL + 'ajax-check-student-email.php?email='+email;

        $.ajax({
            url: callurl,
            type: "get",
            data: {"email": email, "status": status},
            success: function (data) {
                var obj = JSON.parse(data);
                if(obj.status==1)
                {
                    $("#emailstatus").text("");
                }
                else if(obj.status==2)
                {
                    $("input#email").val("");
                    $("#emailstatus").text(obj.email+" Email Already Exists!");
                }
            }
        });
    });
</script>
<?php */ ?>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

<script>
    // Wait for the DOM to be ready
    $(function() {

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        });

        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        });

        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form#addStudentForm").validate({
            // Specify validation rules
            rules: {
                firstName: {
                    required: true,
                    lettersonly: true
                },
                dob: {
                    required: true
                },
                gender: {
                    required: true
                },
                mobile: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true
                },
                cityId: "required",
                address: "required"
            },
            // Specify validation error messages
            messages: {
                firstName: {
                    required: "Please enter your Name",
                    lettersonly: "Your Name must be of characters"
                },
                dob: {
                    required: "Please provide the DOB"
                },
                gender: {
                    required: "Please provide the Gender"
                },
                mobile: {
                    required: "Please provide the Mobile Number",
                    minlength: "Your mobile number must be 10 characters long",
                    maxlength: "Your mobile number must be 10 characters long"
                },
                email: {
                    required: "Please provide a valid email"
                },
                cityId: "Please choose your City",
                address: "Please enter your Address"
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>