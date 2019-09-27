<?php session_start();
ob_start();
 
if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_name=$_SESSION['adminusername'];
$date = date("Y-m-d");

$staff_sql = "select * from teacher_academic where user_id='$user_id'";
$staff_exe = mysql_query($staff_sql);
$staff_fet = mysql_fetch_assoc($staff_exe);
$staff_cnt = @mysql_num_rows($staff_exe);

if($staff_cnt > 0){
    $classTeacher = explode(" ", $staff_fet['class_teacher']);
    $class = $classTeacher[0];
    $section = $classTeacher[1];
    $cls_sql="SELECT * FROM `classes` where class_name='$class'";
    $cls_exe=mysql_query($cls_sql);
    $cls_fet = mysql_fetch_assoc($cls_exe);
    $classId = $cls_fet['id'];
}

$students = $_REQUEST['students'];

$students_cnt = count($_REQUEST["students"]);


    for ($i = 0; $i < $students_cnt; $i++) {
		$student_id = $students[$i];
		$query_student = "UPDATE `student_academic` SET `section_name` = '$section' WHERE `user_id` = '$student_id'";
		$query_student_exe = mysql_query($query_student);
	}
header("Location: student.php?succ=2");

?>