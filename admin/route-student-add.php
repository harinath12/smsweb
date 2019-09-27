<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['id']))
{
    $routeId = $_REQUEST['id'];
}
else{
    exit;
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];



$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$route_sql="SELECT * FROM `routes` where id='$routeId'";
$route_exe=mysql_query($route_sql);
$route_fet=mysql_fetch_array($route_exe);

$route_student_sql="SELECT * FROM `route_student` where route_id='$routeId' ORDER BY id ASC";
$route_student_exe=mysql_query($route_student_sql);
$route_student_cnt=mysql_num_rows($route_student_exe);

/*
$stop_sql="SELECT * FROM `stopping_master` where stopping_status='1'";
$stop_exe=mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}
*/

$stop_sql="SELECT * FROM `route_stop` where route_id='$routeId' ORDER BY route_order ASC";
$stop_exe=mysql_query($stop_sql);
$stop_cnt=mysql_num_rows($stop_exe);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}


?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <style>.control-label{line-height:32px;}  .form-group{line-height:32px;}</style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Route
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="routes-list.php"> Routes List</a></li>
                <li class="active">Add Routes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Routes Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
						
						<form role="form" action="#" method="post">
                            <div class="box-body">
                        
						            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Route No.</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['route_no']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Num of Stopping</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['num_of_stopping']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Starting Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['pickup_starting_point']; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Ending Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['pickup_ending_point']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Drop Starting Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['dropping_starting_point']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Drop Ending Point</label>
                                            <div class="col-sm-7">
                                                <?php echo $route_fet['dropping_ending_point']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

							</div>
						</form>
						
						
                        <form role="form" action="docreateroutestudent.php" method="post">
                            <div class="box-body">
                                
                                <div class="row">
                                    <div class="form-group col-md-12 addRouteRow" id="addRouteRow">
                                        <h4>Bus Stops</h4>
										
										<?php
										foreach($stop_results as $key => $value){ 
										?>
										<?php $stop_id = $value['id']; ?>
                                        <div class="row" style="margin-bottom: 10px;" id="addStops">
                                            <div class="col-lg-4">
												<?php //print_r($value); ?>
												
												
												<input type="hidden" class="stop-name" name="stop_name[<?php echo $stop_id; ?>]" id="stop_name" value="<?php echo $value['stop_name']; ?>" required  />
												<?php echo $value['stop_name']; ?>
												<?php /* ?>
                                                <select class="form-control stop-name" name="stop_name[]" id="stop_name">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ 
													?>
                                                        <option value="<?php echo $value['stop_name']; ?>"><?php echo $value['stop_name']; ?></option>
                                                    <?php
                                                    }
													?>
                                                </select>
												<?php */ ?>
                                            </div>
                                            <div class="col-lg-3">
                                                
												
<?php
$stop_name = $value['stop_name'];

$stud_sql = "select gen.*, cl.class_name,sa.section_name from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
LEFT JOIN `classes` AS cl on sa.class = cl.id
where usr.delete_status='1' and gen.stop_from = '$stop_name'";

$stud_exe = mysql_query($stud_sql);
$stop_student_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    $stop_student_results[] = array(
        'studentid' => $row['user_id'],
		'studentadmissionid' => $row['admission_number'],
        'studentname' => $row['student_name']
    );
}
?>
												<select class="form-control student-name" name="student_name[<?php echo  $stop_id; ?>][]" id="student_name" multiple required >
												<?php
												foreach($stop_student_results as $key => $value){ 
												?>
													<option value="<?php echo $value['studentid']; ?>"><?php echo $value['studentname']; ?></option>
												<?php
												}
												?>
												</select>
												
                                            </div>
                                            
                                            <div class="col-lg-1">
											<!--
                                                <button type="button" class="btn btn-info add-stop" title="Add More">+</button>
											-->
                                            </div>
                                        </div>
										<?php
										}
										?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-5"></div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-info add-route">Save Student</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

<script>
    $(function(){
        var counter = 1;
        $('.add-stop').click(function(){
            var input1 = $("#distance").val();
            $.get('ajaxroutestoplist.php?id=<?php echo $routeId; ?>', function(result){
                var list = "<option value=''>Select Stop</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.stopname + "'>" + item.stopname + "</option>";
                });
                var newRow = $('<div class="row" style="margin-bottom: 10px;" id="addStops'+counter+'"> ' +
                '<div class="col-lg-4"> ' +
                '<select name="stop_name[]" class="form-control stop-name" id="stop_name">'+
                list +
                '</select>'+
                '</div>' +
                '<div class="col-lg-3"><select class="form-control student-name" name="student_name[]" id="student_name" multiple></select></div> ' +
                '<div class="col-lg-1">'+
                '<i class="btn btn-danger removeStop" id="removeStop'+counter+'" data-id="'+counter+'"><span class="fa fa-trash"> </span></i>'+
                '</div>'+
                '</div>');
                counter++;
                $('.addRouteRow').append(newRow);
            });
        });
		
		
        $(document).on('click', '.removeStop' , function(){
            $('#addStops'+$(this).data('id')).remove();
            counter--;
        });
		
		$(document).on('change', '.stop-name' , function(){
		    var stop_name = $(this).val();
			console.log(stop_name);
			$.get('ajaxroutestopstudentlist.php?stop_name='+stop_name+'', function(result){
				console.log(result);
                var studentlist = "<option value=''>Select Student</option>";
                $.each(JSON.parse(result), function(i,item) {
                    studentlist = studentlist + "<option value='" + item.studentid + "'>" + item.studentname +" ( "+ item.studentadmissionid +" ) "+"</option>";
                });
                $('.student-name').html(studentlist);
            });
        });
		
    });
</script>

</body>
</html>
