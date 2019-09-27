<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$examid = $_REQUEST['examid'];

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


for($j=0; $j<$class_cnt; $j++) {
    for($z = 0; $z < $examdate_cnt; $z++) {
        $syllabus = $_REQUEST['syllabus'.$j.$z];
        $examsubid = $_REQUEST['examsubid'.$j.$z];
        if(!empty($syllabus)){
            $exam_sql = "UPDATE `exam_date_subject` set syllabus = '$syllabus',  updated_by='$username',  updated_at='$date' where id='$examsubid'";
            $exam_exe = mysql_query($exam_sql);
        }
    }
}


header("Location: exam-time-table.php?succ=2");

?>