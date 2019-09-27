<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$classId=$_GET['classId'];
$sectionName=$_GET['sectionName'];

$stu_sql = "select si.*, aca.section_name, c.class_name from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
LEFT JOIN classes as c on c.id = aca.class
where users.delete_status=1 and aca.class ='$classId' and aca.section_name='$sectionName'";
$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);



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
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
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
                Student List Promotion
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="students-promotion.php">Students Promotion</a></li>

                <li class="active">Students List Promotion</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body">
                            <form method="post" action="do-students-promotion.php">
                                <div class="panel-body">
                                    <?php
                                    if(isset($_REQUEST['import'])){
                                        if($_REQUEST['import'] == 1){
                                            ?>
                                            <div class="alert alert-success alert-dismessible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Students Promoted Successfully</strong>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                    
                                </div>
                                <?php
                                if($stu_cnt>0)
                                {
                                    ?>
                                    <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th class="hiddenX"><input type="checkbox" class="stuCheck" onClick="toggle(this)" /> Select All</th>
                                                <th>S.No.</th>
                                                <th>PHOTO</th>
												<th>NAME</th>
                                                <th>ADMISSION NO.</th>
                                                <th>CLASS</th>
                                                <th>MOBILE</th>
                                                <th>FATHER NAME</th> 
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i =1;
                                            while($stu_fet=mysql_fetch_array($stu_exe))
                                            {
                                                ?>
                                                <tr>
                                                    <td class="hiddenX"><input type="checkbox" class="stuCheck" name="student[]" value="<?php echo $stu_fet['user_id'] ?>"/> </td>
                                                    <td><?php echo $i++; ?></td>
													<td>
													<img src=" <?php echo '../admin/' . $stu_fet['photo']; ?>" alt="<?php echo $stu_fet['student_name']; ?>" title="<?php echo $user_name; ?>" class="img-circle img-lgX" style="width:60px;height:60px;" />
													</td>
                                                    <td><?php echo $stu_fet['student_name']; ?></td>
                                                    <td><?php echo $stu_fet['admission_number'] ?></td>
                                                    <td><?php echo $stu_fet['class_name'] . "-" . $stu_fet['section_name']; ?></td>
                                                    <td><?php echo $stu_fet['mobile']; ?></td>
                                                    <td><?php echo $stu_fet['father_name']; ?></td>
                                                     
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </span>
									
									<div class="row">
										<div class="col-md-3">
                                            
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
													<option value="0">LEFT</option>
												</select>
											</div>
											</div>
											
                                        </div>
                                        <div class="col-md-3">
										
										
											<div class="form-group">
											<label class="control-label col-lg-4">Section<span class="req"> *</span></label>
											<div class="col-lg-8">
												<input type="text" class="form-control" name="sectionName" value="<?php echo $student_fet['section_name']; ?>" />
												(If Student LEFT mean - Mention LEFT on Section)
											</div>
											</div>
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="form-control btn btn-info" onclick="return confirm('Do you want to promote?');">Promote Student</button>
                                        </div>
                                        <div class="col-md-3">
                                            
                                        </div>
                                    </div>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> Records are being updated. </b></p>
                                <?php
                                }
                                ?>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
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

<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatableX').DataTable({
            "scrollX": true,
            columnDefs: [
                {
                    orderable: false,
                    targets: 7
                }
            ]
        });
    } );
</script>
<!-- page script -->
<script language="JavaScript">
function toggle(source) {
  classname = "stuCheck";	
  checkboxes = document.getElementsByClassName(classname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
</body>
</html>