<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$studentId = $_REQUEST['student_id'];
$date = date("Y-m-d");

$insert_staff_sq1 = "UPDATE `users` set delete_status = 0, updated_at='$date' where id = '$studentId'";
$insert_staff_exe = mysql_query($insert_staff_sq1);

header("Location: student-list.php?del=1");

?>