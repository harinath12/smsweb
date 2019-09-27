<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$leaveId = $_REQUEST['leave_id'];
$admin_status = $_REQUEST['admin_status'];
$date = date("Y-m-d"); 

$insert_staff_sq1 = "UPDATE `student_leave` SET leave_status = '$admin_status', admin_status='$admin_status' WHERE id = '$leaveId'";
$insert_staff_exe = mysql_query($insert_staff_sq1);

header("Location: student-leave.php?update=1"); 

?>