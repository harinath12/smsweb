<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['className'])){
    $className = $_GET['className'];
    if (isset($_GET['section'])){
        $sectionName = $_GET['section'];
    }
    else{
        exit;
    }
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/* $teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1]; */

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$student_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");
?>

<div class="panel-body">
    <table class="table table-bordered">
        <tr>
            <th>S.No.</th>
            <th>Student Name</th>
            <th>Admission Number</th>
            <th>Marks</th>
            <th>Remarks</th>
        </tr>
    <?php
    $sno =1;
        while($student_fet = mysql_fetch_assoc($student_exe)){
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $student_fet['student_name']; ?></td>
                <td><?php echo $student_fet['admission_number']; ?></td>
                <td><input type="number" name="marks[]" min="0"/> </td>
                <td><input type="text" name="remarks[]" /></td>
                <input type="hidden" name="studentid[]" value="<?php echo $student_fet['user_id']; ?>" />
            </tr>
    <?php
            $sno++;
        }
    ?>
    </table>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-lg-2">
                    <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                </div>
            </div>
        </div>
    </div>
</div>