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

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$class_id[] = $cls_fet['id'];

$classHandling = $teacher_fet['class_handling'];
$clsteacherhandling = explode(",", $classHandling);
$clsteacherhandling_array=array_map('trim',$clsteacherhandling);
$cnt = count($clsteacherhandling_array);

if(!empty($classHandling)){
    for($i=0; $i<$cnt; $i++){
        $clas = $clsteacherhandling_array[$i];
        $clas_fet = mysql_fetch_array(mysql_query("SELECT * FROM `classes` where class_name='$clas'"));
        $class_id[$i] = $clas_fet['id'];
    }
}
$class_cnt = count($class_id);


$exam_sql="SELECT * FROM `exam_time_table` where id='$examid'";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);
$startdate = $exam_fet['start_date'];
$enddate = $exam_fet['end_date'];

for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
$examdate_cnt = count($examdate);
?>

<?php /* ?>
<div class="panel-body" style="margin:15px; border: 1px grey dotted;">
    <h4><b>View Exam Time Table</b></h4>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Exam</label>
                        <div class="col-lg-8">
                            <?php echo $exam_fet['exam_name']; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Start Date</label>
                        <div class="col-lg-8">
                            <?php //echo $exam_fet['start_date']; ?>
							<?php echo date_display($exam_fet['start_date']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">End Date</label>
                        <div class="col-lg-8">
                            <?php //echo $exam_fet['end_date']; ?>
							<?php echo date_display($exam_fet['end_date']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-bordered" style="overflow: scroll;">
            <tr>
                <th>Class/Dates</th>
                <?php
                for($z = 0; $z < $examdate_cnt; $z++) {
                    ?>
                    <th><?php //echo $examdate[$z]; ?><?php echo date_display($examdate[$z]); ?></th>
                <?php
                }
                ?>
            </tr>
            <?php
            for($j=0; $j<$class_cnt; $j++) {
                ?>
                <tr>
                    <td>
                        <?php
                        if($class_id[$j] == '100'){
                            echo 'All';
                        }
                        else{
                            $class_fet = mysql_fetch_assoc(mysql_query("Select class_name from classes where id=$class_id[$j]"));
                            echo $class_fet['class_name'];
                        }
                        ?>
                    </td>
                    <?php
                    for($z = 0; $z < $examdate_cnt; $z++) {
                        ?>
                        <td>
                            <?php $sub_fet = mysql_fetch_assoc(mysql_query("select subject_name from exam_date_subject where exam_id='$examid' and exam_date='$examdate[$z]' and (class_id='$class_id[$j]' or class_id=100)"));
                            echo $sub_fet['subject_name'];
                            ?>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>

        </table>
    </form>
</div>
<?php */ ?>

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
                <th>Class</th>
				<th>Dates</th>
                <th>Subject</th>
				<th>Session</th>
				<th>Syllabus</th>
            </tr>
			<?php for($j=0; $j<$class_cnt; $j++) { ?>
<?php 
$exam_sql = "select * from exam_date_subject where exam_id='$examid' and (class_id='$class_id[$j]' or class_id=100)";
$exam_exe = mysql_query($exam_sql);
if($exam_cnt = mysql_num_rows($exam_exe)) { 

while($sub_fet = mysql_fetch_assoc($exam_exe)) {
                            ?>
                <tr>
                    <td>
                        <?php
						$sub_class_id=$sub_fet['class_id'];
					    $class_fet = mysql_fetch_assoc(mysql_query("Select class_name from classes where id=$sub_class_id"));
                        echo $class_fet['class_name']; 
                        ?>
                    </td>
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
<?php } ?>
        </table>
    </form>
</div>