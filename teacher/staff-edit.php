<?php session_start();
ob_start();
include "config.php";

$city_sql="SELECT * FROM `cities` where `city_status`=1";
$city_exe=mysql_query($city_sql);
$city_results = array();
while($row = mysql_fetch_assoc($city_exe)) {
    array_push($city_results, $row);
}

$staffId = $_REQUEST['staff_id'];
$staff_sql="SELECT si.*, c.city_name FROM `staff_info` as si
LEFT JOIN `cities` as c ON c.id = si.city
LEFT JOIN `users` ON users.id = si.user_id
where si.user_id=$staffId and users.delete_status=1";
$staff_exe=mysql_query($staff_sql);
$staff_cnt=@mysql_num_rows($staff_exe);
$staff_fet=mysql_fetch_array($staff_exe);
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
    <title>MySkoo - Edit Staff</title>
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
                        <h4><i class="fa fa-pencil position-left"></i> EDIT STAFF</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="staff.php">Staff</a></li>
                        <li class="active">Edit Staff</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <form role="form" id="addStaffForm" class="form-horizontal" method="post" action="doupdatestaff.php" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control"  value="<?php echo $staff_fet['firstname_person']; ?>" placeholder="Enter your first name" name="firstName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Last Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your last name" name="lastName"  value="<?php echo $staff_fet['lastname_person']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Job Type </label>
                                        <div class="col-lg-8">
                                            <select name="jobType" class="form-control">
                                                <option value="">Select Job Type</option>
                                                <option value="1" <?php if($staff_fet['job_type'] == 1) echo "selected"; ?>>Teaching Staff</option>
                                                <option value="2" <?php if($staff_fet['job_type'] == 2) echo "selected"; ?>>Non Teaching Staff</option>
                                                <option value="3" <?php if($staff_fet['job_type'] == 3) echo "selected"; ?>>Office Clerk</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Job Position </label>
                                        <div class="col-lg-8">
                                            <select name="jobPosition" class="form-control">
                                                <option value="">Select Job Position</option>
                                                <option value="1" <?php if($staff_fet['job_position'] == 1) echo "selected"; ?>>Principal</option>
                                                <option value="2" <?php if($staff_fet['job_position'] == 2) echo "selected"; ?>>Junior Staff</option>
                                                <option value="3" <?php if($staff_fet['job_position'] == 3) echo "selected"; ?>>Senior Staff</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="dob" value="<?php echo $staff_fet['dob']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Gender</label>
                                        <div class="col-lg-8">
                                            <select name="gender" class="form-control">
                                                <option value=" ">Select Gender</option>
                                                <option value="Male" <?php if($staff_fet['gender'] == 'Male') echo "selected"; ?>>Male</option>
                                                <option value="Female" <?php if($staff_fet['gender'] == 'Female') echo "selected"; ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Photo</label>
                                        <div class="col-lg-8">
                                            <?php if(!empty($staff_fet['photo'])){ ?>
                                            <img style="height: 150px; width: 150px;" src="<?php echo $staff_fet['photo']; ?>" alt="<?php echo $staff_fet['firstname_person']; ?>" title="<?php echo $staff_fet['firstname_person']; ?>" />
                                           <?php } ?>
                                            <input type="file" class="form-control" name="staffPhoto">
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
                                            <input type="number" class="form-control" maxlength="10" name="mobile" value="<?php echo $staff_fet['mobile']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $staff_fet['email']; ?>"readonly>
                                            <span class="error" id="emailstatus"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Address</label>
                                        <div class="col-lg-8">
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Address" name="address"> <?php echo $staff_fet['address']; ?> </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="cityId" id="cityId">
                                                <option value="">Select City</option>
                                                <?php
                                                foreach($city_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($staff_fet['city'] == $value['id']) echo "selected"; ?>><?php echo $value['city_name']; ?></option>
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
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="hidden" class="form-control" name="staffId" value="<?php echo $staffId; ?>">
                            <input type="submit" value="SAVE" class="btn btn-info form-control"/>
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

<script>
    $("input#email").change(function(){
        var email = $("input#email").val();
        var BASEURL = "http://localhost/eSchool/webapp/";
        var status = 1;
        var callurl = BASEURL + 'ajax-check-email.php?email='+email;

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

<script src="js/jquery.validate.min.js"></script>

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
        $("form#addStaffForm").validate({
            // Specify validation rules
            rules: {
                firstName: {
                    required: true,
                    lettersonly: true
                },
                mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true
                }
            },
            // Specify validation error messages
            messages: {
                firstName: {
                    required: "Please enter your Name",
                    lettersonly: "Your Name must be of characters"
                },
                mobile: {
                    required: "Please provide the Mobile Number",
                    minlength: "Your mobile number must be 10 characters long",
                    maxlength: "Your mobile number must be 10 characters long"
                },
                email: {
                    required: "Please provide a valid email"
                }
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