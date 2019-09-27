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

$stud_sql = "SELECT gen.user_id, gen.student_name, aca.class, aca.section_name FROM student_academic as aca
LEFT JOIN student_general as gen on gen.user_id = aca.user_id
LEFT JOIN users as usr on usr.id = gen.user_id
WHERE aca.class = '$classId' and aca.section_name='$sectionName' and usr.delete_status='1'";
$stud_exe = mysql_query($stud_sql);
$stud_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    array_push($stud_results, $row);
}

$remark_sql = "select re.*, gen.student_name from teacher_remarks as re
LEFT JOIN student_general as gen on gen.user_id = re.student_id
where re.id='$hid'";
$remark_exe = mysql_query($remark_sql);
$remark_fet = mysql_fetch_assoc($remark_exe);
?>

<div class="panel-body">
    <form action="doeditremarks.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
            <b>Edit Remarks</b>
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <label class="control-label col-lg-4">Title <span class="req"> *</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $remark_fet['title']; ?>" required/>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="control-label col-lg-4">Remarks Type</label>
                    <div class="col-lg-8">
                        <input type="radio" name="editremarksType" class="editremarksType" value="Text"  <?php if($remark_fet['remarks_type'] == 'Text'){ echo 'checked'; }?>/> Text &nbsp;&nbsp;
                        <input type="radio" name="editremarksType" class="editremarksType" value="Audio" <?php if($remark_fet['remarks_type'] == 'Audio'){ echo 'checked'; }?>/> Audio
                    </div>
                </div>

                <?php
                if($remark_fet['remarks_type'] == 'Text'){
                    ?>
                    <div class="row form-group editremarksText">
                    <label class="control-label col-lg-4">Remarks Details</label>
                    <div class="col-lg-8">
                        <textarea name="remark_details" id="remark_details" class="form-control"><?php echo $remark_fet['remark_details']; ?></textarea>
                    </div>
                </div>
                <?php
                }?>

                <?php
                if($remark_fet['remarks_type'] == 'Audio'){
                ?>
                <div class="row form-group editremarksAudio">
                    <label class="control-label col-lg-4">Attachment</label>
                    <div class="col-lg-6">
                        <input type="file" class="form-control" name="remarkFile" accept="audio/*">
                    </div>
                    <?php
                    if($remark_fet['remark_filepath'])
                    {
                        ?>
                        <div class="col-lg-1">
                            <a href="<?php echo $remark_fet['remark_filepath']; ?>" download>
                                <button type="button" class="btn btn-info" ><i class="fa fa-download"></i></button>
                            </a>
                        </div>
                    <?php }
                    ?>
                </div>
                <?php } ?>

                <div class="row form-group editremarksText" style="display:none;">
                    <label class="control-label col-lg-4">Remarks Details</label>
                    <div class="col-lg-8">
                        <textarea name="remark_details" id="remark_details" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row form-group editremarksAudio" style="display:none;">
                    <label class="control-label col-lg-4">Attachment</label>
                    <div class="col-lg-8">
                        <input type="file" class="form-control" name="remarkFile" accept="audio/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-lg-2">
                        <input type="hidden" name="remarksId" value="<?php echo $hid; ?>"/>
                        <input type="submit" value="SAVE" class="btn btn-info form-control" onclick="return show_confirm();"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('.editremarksType').change(function() {
            var rType = $('input[name="editremarksType"]:checked').val();
            if(rType == 'Text'){
                $('.editremarksAudio').hide();
                $('.editremarksText').show();
            }
            else if(rType == 'Audio'){
                $('.editremarksText').hide();
                $('.editremarksAudio').show();
            }
        });
    });
</script>