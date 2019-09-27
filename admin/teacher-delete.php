<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$teacherId = $_REQUEST['teacher_id'];
$date = date("Y-m-d");

$insert_staff_sq1 = "UPDATE `users` set delete_status = 0, updated_at='$date' where id = '$teacherId'";
$insert_staff_exe = mysql_query($insert_staff_sq1);

header("Location: teacher-list.php?del=1");

?>