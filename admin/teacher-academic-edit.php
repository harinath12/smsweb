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

$teacherId = $_REQUEST['teacher_id'];

$student_sql="SELECT tea.* FROM `teacher_academic` as tea where tea.user_id = $teacherId";
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
                <form class="form-horizontal" action="doeditteacheracademic.php" id="addStudentForm" method="post" enctype="multipart/form-data">

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
                                    <a href="teacher-edit.php?teacher_id=<?php echo $teacherId; ?>"><button type="button" class="form-control btn btn-info">Edit Teacher (General)</button></a>
                                </div>
                            </div>
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
                                                <input type="radio" name="postDetails" value="Teaching Staff" <?php if($student_fet['post_details'] == 'Teaching Staff') {echo 'checked'; } ?>/> Teaching Staff&nbsp;&nbsp;
                                                <input type="radio" name="postDetails" value="Non Teaching Staff" <?php if($student_fet['post_details'] == 'Non Teaching Staff') {echo 'checked'; } ?> /> Non Teaching Staff
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6" id="teachingSection" style="display: none;">
                                        <?php
                                        if(!empty($student_fet['class_teacher'])){
                                            $classTeacher = explode(" ", $student_fet['class_teacher']);
                                            $class = $classTeacher[0];
                                            $section = $classTeacher[1];
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class Teacher</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="className" id="className">
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['class_name']; ?>" <?php if($class == $value['class_name']){ echo 'selected'; } ?>><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <?php /* ?>
                                                <select class="form-control" name="sectionName" id="sectionName">
                                                    <option value="">Select Section</option>
                                                </select>
<?php */ ?>
                                                <input type="text" name="sectionName" class="form-control" value="<?php echo $section; ?>"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Subjects Handling</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="subjects" value="<?php echo $student_fet['subject']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class Handling</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="classHandling" value="<?php echo $student_fet['class_handling']; ?>">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-lg-4">Class Section Handling</label>
                                            <div class="col-lg-8">
												<?php $class_section_handling = explode(",",$student_fet['class_section_handling']); ?>
                                                <select class="form-control" name="classSectionHandling[]" id="classSectionHandling" multiple>
                                                    <option value="">Select Class Section</option>
                                                    <?php
                                                    foreach($class_section_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['class_name'].' '.$value['section_name']; ?>" <?php if (in_array($value['class_name'].' '.$value['section_name'], $class_section_handling)) { echo "selected"; } ?>><?php echo $value['class_name'].' '.$value['section_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="nonteachingSection" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Department</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="department" value="<?php echo $student_fet['department']; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Position</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="position" value="<?php echo $student_fet['position']; ?>" />
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
                            <input type="hidden" name="teacherId" value="<?php echo $student_fet['user_id']; ?>">
                            <input type="submit" value="SUBMIT" class="btn btn-info form-control"/>
                        </div>
                    </div>
                </form>
                <!-- /form horizontal -->
                <?php include "footer.php"; ?>
            </div>
            <!-- /content area -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

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
    $(window).load(function(){
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
            var sec = $('.sec').val();
            $.get('sectionscript.php', {cls: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    var isec = item.secname;
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                //alert(list);
                $("#sectionName").html(list);
            });
        });
    });
</script>
</body>
</html>