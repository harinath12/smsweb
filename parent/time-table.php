<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];
/*
$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$date = date("Y-m-d");
*/


/*
//$exam_sql="SELECT * FROM `time_table` where id='$examid'";
$exam_sql="SELECT * FROM `time_table` WHERE `class`='$className' AND `section`='$sectionName' AND `time_table_status`=1";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);
$className = $exam_fet['class'];

$class_sql = mysql_query("SELECT `id` FROM `classes` WHERE `class_name`='$className'");
$class_fet = mysql_fetch_assoc($class_sql);
$class_id = $class_fet['id'];


$sub_sql = mysql_query("select distinct subject_name from class_subject where class_subject_status=1 and class_id=$class_id order by subject_name ASC");
$sub_results = array();
while($row = mysql_fetch_assoc($sub_sql)) {
array_push($sub_results, $row);
}

*/


$exam_sql="SELECT * FROM `time_table` WHERE `class`='$className' AND `section`='$sectionName' AND `time_table_status`=1";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>
    <style>
        .req{
            color: red;
        }
    </style>
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
                        <h4><i class="fa fa-th-large position-left"></i> TIME TABLE</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Time Table</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                             
                            <div class="panel-body">


<div class="panel-body" style="margin:15px; border: 1px grey dotted;">
    <h4><b>View Time Table # <span style="color:#02d502;" ><?php echo $exam_fet['class']; ?> <?php echo $exam_fet['section']; ?></span></b></h4>
   
   
   
<style>
	table thead tr td { font-weight:bold; }
	table tfoot tr td { font-weight:bold; }
	table tbody tr td.head { font-weight:bold; }
</style>
<div class="row"  style="overflow: scroll;">
    <table id="time-table" class="table">
	<thead>
		<tr>
				<td>Day</td>
				<td>Period I</td>
				<td>Period II</td>
				<td>Period III</td>
				<td>Period IV</td>
				<td>Period V</td>
				<td>Period VI</td>
				<td>Period VII</td>
				<td>Period VIII</td>
		<tr>
	</thead>
	<tbody>
		<tr>
				<td class="head">Monday</td>
				<td>
				<?php echo $exam_fet['day_1_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Tuesday</td>
				<td>
				<?php echo $exam_fet['day_2_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Wednesday</td>
				<td>
				<?php echo $exam_fet['day_3_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Thursday</td>
				<td>
				<?php echo $exam_fet['day_4_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Friday</td>
				<td>
				<?php echo $exam_fet['day_5_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_8']; ?>
				</td>
		<tr>

	
	<tbody>
	<tfoot>
		<tr>
				<td>Day</td>
				<td>Period I</td>
				<td>Period II</td>
				<td>Period III</td>
				<td>Period IV</td>
				<td>Period V</td>
				<td>Period VI</td>
				<td>Period VII</td>
				<td>Period VIII</td>
				
		<tr>
	</tfoot>
    </table>
</div>

</div>
							 

                            </div>
                        </div>
                        <!-- /basic datatable -->

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
<script>
    $(function() {
        $('#term').change(function() {
			var term  = $('#term').val();
			if(term!="") 
			{
				$('#showsubject').show();
			}
			else
			{
				$('#showsubject').hide();
			}
			
		});
		
		
		
		/*
		$('#term').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#subjectId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });
		*/
    });
	
	function showvideos(subjectid,classid) {
		 var subjectName = subjectid;
		 var className = classid;
		 var termName  = $('#term').val();
		 
		 
		 window.location = 'books-view.php?subjectName='+subjectName+'&className='+className+'&term='+termName;
		
	}
</script>


</body>
</html>