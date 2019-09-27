<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['id'])){
    $examid = $_GET['id'];
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_sql = "select c.class_name, aca.section_name, aca.class from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$classId = $student_fet['class'];
$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$exam_sql="SELECT * FROM `exam_time_table` where id='$examid'";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);

$exam_class_sql = "SELECT DISTINCT class_id FROM `exam_date_subject` where exam_id='$examid'";
$exam_class_exe = mysql_query($exam_class_sql);
$exam_class_cnt = mysql_num_rows($exam_class_exe);
while($exam_class_fet = mysql_fetch_assoc($exam_class_exe)){
    $class_id[] = $exam_class_fet['class_id'];
}
$class_cnt = count($class_id);

$startdate = $exam_fet['start_date'];
$enddate = $exam_fet['end_date'];

for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
$examdate_cnt = count($examdate);
?>
<div class="panel-body" style="margin:15px; border: 1px grey dotted;">
    <h4><b>View Exam Time Table</b></h4>
    <form action="#" method="post" enctype="multipart/form-data">
	
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="col-md-3">
					<input type="text" value="Exam : <?php echo $exam_fet['exam_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
					</div>
					<div class="col-md-3">
					<input type="text" value="Start Date : <?php echo date_display($exam_fet['start_date']); ?>" class="form-control" readonly style="border: 0px;background: none;" />
					</div>
					
					<div class="col-md-3">
					<input type="text" value="End Date : <?php echo date_display($exam_fet['end_date']); ?>" class="form-control" readonly style="border: 0px;background: none;" />
					</div>
				</div>
			</div> 
		</div>
		 

        <table class="table table-bordered" style="overflow: scroll;">
            <tr>
                <th>Dates</th>
                <th>Subject</th>
				<th>Session</th>
				<th>Syllabus</th>
            </tr>
			
<?php 
$exam_sql = "select * from exam_date_subject where exam_id='$examid' and (class_id='$classId' or class_id=100)";
$exam_exe = mysql_query($exam_sql);
if($exam_cnt = mysql_num_rows($exam_exe)) { 

while($sub_fet = mysql_fetch_assoc($exam_exe)) {
                            ?>
                <tr>
                    <td>
                        <?php
						echo $sub_fet['exam_date'];
                        ?>
                    </td>
					<td>
                        <?php
						echo $sub_fet['subject_name'];
                        ?>
                    </td>
					<td>
                        <?php
						if($sub_fet['exam_session']=="AN") { echo "Afternoon"; } else {  echo "Forenoon"; }
                        ?>
                    </td>
                    <td>
                        <?php
						echo $sub_fet['syllabus'];
                        ?>
                    </td>
                </tr>
<?php }
} else { ?>

<?php } ?>
        </table>
    </form>
</div>