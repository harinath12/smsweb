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

$class_section_sql="SELECT * FROM `classes` where class_status=1";
$class_section_exe=mysql_query($class_section_sql);
$class_section_results = array();
while($class_row = mysql_fetch_assoc($class_section_exe)) {
		$className = $class_row['class_name'];
		$section_class_sql="SELECT cs.id AS cs_id, cs.section_name,c.id AS c_id,c.class_name FROM class_section as cs LEFT JOIN classes as c on c.id = cs.class_id 
		                    WHERE c.class_name = '$className' AND cs.class_section_status='1' order by cs.id ASC";
		$section_class_exe=mysql_query($section_class_sql);
			while($row = mysql_fetch_assoc($section_class_exe)) {
					array_push($class_section_results, $row);
			}
}


$class_joining_sql="SELECT DISTINCT c.class_name FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1";
$class_joining_exe=mysql_query($class_joining_sql);
$class_joining_results = array();
while($row = mysql_fetch_assoc($class_joining_exe)) {
    array_push($class_joining_results, $row);
}
/*
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
}*/
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
                Add Teacher
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Add Teacher</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="doaddteacher.php" id="addStudentForm" method="post" enctype="multipart/form-data">

                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Teacher Info inserted Successfully</strong>
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
                                        <label class="control-label col-lg-4">Teacher Name<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Enter your name" name="teacherName" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Emp No.<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="empno" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Birth</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="dob"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Date of Joining</label>
                                        <div class="col-lg-8">
                                            <input type="date" class="form-control" name="doj"/>
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
                                        <label class="control-label col-lg-4">Qualification</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="qualification">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Experience</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="experience"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Nationality<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" name="nationality" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Religion<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="religion">
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
                                        <label class="control-label col-lg-4">Email<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                    <?php /* ?>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">City<span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="city" id="city">
                                                <option value="">Select City</option>
                                                <?php
                                                foreach($city_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['city_name']; ?>"><?php echo $value['city_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
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

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Pincode</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" maxlength="10" name="pincode">
                                        </div>
                                    </div>
                                <?php */ ?>

                                <div class="col-md-6">
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Post Details<span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="radio" name="postDetails" value="Teaching Staff" /> Teaching Staff&nbsp;&nbsp;
                                                <input type="radio" name="postDetails" value="Non Teaching Staff" /> Non Teaching Staff
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6"  id="teachingSection" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class Teacher</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="className" id="className">
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['class_name']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="sectionName" id="sectionName">
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Subjects Handling</label>
                                            <div class="col-lg-8">
                                                <textarea rows="3" cols="5" class="form-control" name="subjects"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class Handling</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="classHandling">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-4">Class Section Handling</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="classSectionHandling[]" id="classSectionHandling" multiple>
                                                    <option value="">Select Class Section</option>
                                                    <?php
                                                    foreach($class_section_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['class_name'].' '.$value['section_name']; ?>"><?php echo $value['class_name'].' '.$value['section_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6"  id="nonteachingSection" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Department</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="department" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Position</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="position" />
                                            </div>
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
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Certificates
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-9">
                                    <div class="form-group certi-row">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <input type="hidden" class="form-control" name="certiId[0]">
                                                <input type="text" class="form-control" name="certiName0" placeholder="Name" />
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="file" class="form-control" name="certi0" />
                                            </div>
                                            <div class="col-lg-4">
                                                <button type="button" class="btn btn-info add-certi" title="Add More">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <input type="submit" value="ADD" class="btn btn-info form-control"/>
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

<script>
    $(document).ready(function(){
        var counter = 1;
        $('.add-certi').click(function(event){
            event.preventDefault();

            var newRow = $('<div class="row"> <div class="col-lg-4"> <input type="hidden" class="form-control" name="certiId[' + '' +
            counter + ']">  <input type="text" class="form-control" name="certiName'+
            counter + '" placeholder="Name" /> </div> <div class="col-lg-4"> <input type="file" class="form-control" name="certi' +
            counter + '" /> </div> </div>');
            counter++;
            $('.certi-row').append(newRow);

        });
    });
</script>

<script>
    $(document).ready(function(){
        $("input[name='postDetails']").click(function(){
            var post = $("input[name='postDetails']:checked").val();
            if(post == 'Teaching Staff'){
                $('#nonteachingSection').show();
                $('#teachingSection').show();
            }
            else if(post == 'Non Teaching Staff'){
                $('#teachingSection').hide();
                $('#nonteachingSection').show();
            }
        });

    });
</script>

<script>
    $(function() {
        $('#className').change(function() {
            $('#sectionName').empty();
            $.get('sectionscript.php', {cls: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionName").html(list);
            });
        });
    });
</script>
<script>

window.onmousedown = function (e) {
    var el = e.target;
    if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
        e.preventDefault();

        // toggle selection
        if (el.hasAttribute('selected')) el.removeAttribute('selected');
        else el.setAttribute('selected', '');

        // hack to correct buggy behavior
        var select = el.parentNode.cloneNode(true);
        el.parentNode.parentNode.replaceChild(select, el.parentNode);
    
	
		var className = $('#className').val();
		
		if(className.includes("100")) { var className = "100"; }
		
		var startdate = $('#datepicker1').val();
		var enddate = $('#datepicker2').val();
			
		if(className!='' && startdate!="" && enddate!="") {
		$.ajax({
			url: "ajax-add-exam-time-table.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
			context: document.body
		}).done(function(response) {
			$('#timetableentry').html(response);
		});
		}
	}
}
</script>
</body>
</html>