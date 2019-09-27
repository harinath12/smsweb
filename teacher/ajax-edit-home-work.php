<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['id'])){
    $hid = $_GET['id'];
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


$classHandling = $teacher_fet['class_handling'];
$clsteacherhandling = explode(",", $classHandling);
$clsteacherhandling_array=array_map('trim',$clsteacherhandling);
//print_r($clsteacherhandling_array);

$subjectHandling = $teacher_fet['subject'];
$sbjteacherhandling = explode(",", $subjectHandling);
$sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);
//print_r($sbjteacherhandling_array);


$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$home_exe = mysql_query("Select * from home_work where id='$hid'");
$home_fet = mysql_fetch_array($home_exe);
$test_array=explode(",",$home_fet['home_work_test_names']); 

$ques_sql = "select q.*, c.class_name from daily_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' and class_id IN ($classId) order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
?>

<div class="panel-body">
    <form action="doedithomework.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
            <b>Edit Home Work</b>
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-lg-4">Class</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="className" id="className" value="<?php echo $home_fet['class'];?>" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Section</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $home_fet['section'];?>" readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Subject <span class="req"> *</span> </label>
                    <div class="col-lg-8">
					<input type="text" class="form-control" name="subjectName" id="subjectName" value="<?php echo $home_fet['subject'];?>" readonly/>
					<?php /* ?>
                        <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                            <option value="">Select Subject</option>
                            <?php
                            foreach($sub_results as $key => $value){ ?>
                                <option value="<?php echo $value['subject_name']; ?>" <?php if($home_fet['subject'] == $value['subject_name']){ echo 'selected'; } ?>><?php echo $value['subject_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
					<?php */ ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Period</label>
                    <div class="col-lg-8">
                        <select class="form-control" name="period" id="period">
                            <option value="">Select Period</option>
                            <option value="I" <?php if($home_fet['period'] == 'I'){ echo 'selected'; } ?>>I</option>
                            <option value="II" <?php if($home_fet['period'] == 'II'){ echo 'selected'; } ?>>II</option>
                            <option value="III" <?php if($home_fet['period'] == 'III'){ echo 'selected'; } ?>>III</option>
                            <option value="IV" <?php if($home_fet['period'] == 'IV'){ echo 'selected'; } ?>>IV</option>
                            <option value="V" <?php if($home_fet['period'] == 'V'){ echo 'selected'; } ?>>V</option>
                            <option value="VI" <?php if($home_fet['period'] == 'VI'){ echo 'selected'; } ?>>VI</option>
                            <option value="VII" <?php if($home_fet['period'] == 'VII'){ echo 'selected'; } ?>>VII</option>
                            <option value="VIII" <?php if($home_fet['period'] == 'VIII'){ echo 'selected'; } ?>>VIII</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group hidden">
                    <label class="control-label col-lg-4">Title</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $home_fet['title'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Home Work Details</label>
                    <div class="col-lg-8">
                        <textarea name="description" id="description" class="form-control"><?php echo $home_fet['description'];?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Attachment</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="homeWorkFile">
                    </div>
                    <?php
                    if($home_fet['home_work_file_path'])
                    {
                        ?>
                        <div class="col-lg-1">
                            <a href="<?php echo $home_fet['home_work_file_path']; ?>" download>
                                <button type="button" class="btn btn-info" ><i class="fa fa-download"></i></button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
				
				<div class="form-group">
					<label class="control-label col-lg-4">Daily Test</label>
					<div class="col-lg-8">
						<select class="form-control testName" name="testName[]" id="testName" multiple style="height: 100px;">
						<option value="">Select Test</option>
							<?php
							while($ques_fet = mysql_fetch_assoc($ques_exe)) {
							?>
								<option value="<?php echo $ques_fet['id']; ?>" <?php if (in_array($ques_fet['id'],$test_array )) { echo "selected"; } ?> ><?php echo $ques_fet['daily_test_name']; ?></option>
							<?php
							}
							?>
						</select>
					
					</div>
				</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-lg-2">
                        <input type="hidden" name="homeworkId" value="<?php echo $hid; ?>"/>
                        <input type="submit" value="SAVE" class="btn btn-info form-control" onclick="return show_confirm();"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>