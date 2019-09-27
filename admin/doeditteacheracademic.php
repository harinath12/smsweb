<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$teacherId = $_REQUEST['teacherId'];
$postDetails = $_REQUEST['postDetails'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjects = $_REQUEST['subjects'];
$classHandling = $_REQUEST['classHandling'];
$department = $_REQUEST['department'];
$position = $_REQUEST['position'];
$classTeacher = $className . " " . $sectionName;

$classSectionHandling = "";
if(count($_REQUEST['classSectionHandling'])) {
$classSectionHandling = implode(",",$_REQUEST['classSectionHandling']);
}

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$student_sql = "UPDATE `teacher_academic` set post_details = '$postDetails', class_teacher = '$classTeacher', subject = '$subjects', position = '$position',
department = '$department', class_handling = '$classHandling', class_section_handling='$classSectionHandling', updated_at = '$date', updated_by = '$username' where user_id = '$teacherId'";
$student_exe = mysql_query($student_sql);

header("Location: teacher-view.php?teacher_id=$teacherId");

?>