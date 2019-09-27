<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];



$studentsId = $_REQUEST['student'];
$studentsCount = count($studentsId);
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

/*
print_r($_REQUEST);
echo "<hr/>";
print_r($studentsId);
echo "<hr/>";
print_r($studentsCount);
echo "<hr/>";
print_r($className);
echo "<hr/>";
print_r($sectionName);
echo "<hr/>";
*/

for($s=0;$s<$studentsCount;$s++)
{
$studentId 	= $studentsId[$s];
$student_sql = "UPDATE `student_academic` SET `class` = '$className', `section_name` = '$sectionName', `updated_at` = '$date', `updated_by` = '$username' WHERE `user_id` = '$studentId'";

$student_exe = mysql_query($student_sql);
/*
echo "<hr/>";
echo $student_sql;
echo "<hr/>";
*/
}


header("Location: students-list-promotion.php?classId=$className&sectionName=$sectionName");

/*
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
*/
?>