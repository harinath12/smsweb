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

$home_exe = mysql_query("Select * from project where id='$hid'");
$home_fet = mysql_fetch_array($home_exe);
?>

<div class="panel-body">
    <form action="doeditproject.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
            <b>Edit Project</b>
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-lg-4">Class</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="className" id="className" value="<?php echo $home_fet['class']; ?>" readonly/>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="control-label col-lg-4">Section</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $home_fet['section']; ?>" readonly/>
                    </div>
                </div>
                </br>

                <div class="form-group">
                    <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
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
                </br>

                <div class="form-group">
                    <label class="control-label col-lg-4">Project Details</label>
                    <div class="col-lg-8">
                        <textarea name="description" id="description" class="form-control"><?php echo $home_fet['description']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-lg-4">Project File(1)</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="project1" value=""/>
                    </div>
                    <?php
                    if($home_fet['project1'])
                    {
                        ?>
                        <div class="col-lg-1">
                            <a href="<?php echo $home_fet['project1']; ?>" download> <button type="button" class="btn btn-info" title="Download"><i class="fa fa-download"></i></button> </a>
                        </div>
                    <?php } ?>
                </div>
                </br>

                <div class="form-group">
                    <label class="control-label col-lg-4">Project File(2)</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="project2" value=""/>
                    </div>
                    <?php
                    if($home_fet['project2'])
                    {
                    ?>
                    <div class="col-lg-1">
                        <a href="<?php echo $home_fet['project2']; ?>" download> <button type="button" class="btn btn-info" title="Download"><i class="fa fa-download"></i></button> </a>
                    </div>
                    <?php } ?>
                </div>
                </br>

                <div class="form-group">
                    <label class="control-label col-lg-4">Project File(3)</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="project3" value=""/>
                    </div>
                    <?php
                    if($home_fet['project3'])
                    {
                        ?>
                        <div class="col-lg-1">
                            <a href="<?php echo $home_fet['project3']; ?>" download> <button type="button" class="btn btn-info" title="Download"><i class="fa fa-download"></i></button> </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-lg-2">
                        <input type="hidden" name="projectId" value="<?php echo $hid; ?>"/>
                        <input type="submit" value="SAVE" class="btn btn-info form-control" onclick="return show_confirm();"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>