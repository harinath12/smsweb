<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$studentId = $_REQUEST['studentId'];
$rollNo = $_REQUEST['rollNo'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$sportsDetails = $_REQUEST['sportsDetails'];
$position = $_REQUEST['position'];
$extraCurricular = $_REQUEST['extraCurricular'];
$achievements = $_REQUEST['achievements'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$pwdtime = time();
$pwd = md5('123456');

$student_sql = "UPDATE `student_academic` set roll_number = '$rollNo', class = '$className', section_name = '$sectionName', position = '$position',
sports = '$sportsDetails', extra_curricular = '$extraCurricular', achievements = '$achievements', updated_at = '$date', updated_by = '$username' where user_id = '$studentId'";
$student_exe = mysql_query($student_sql);

header("Location: student-view.php?student_id=$studentId");

?>