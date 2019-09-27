<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

if(isset($_REQUEST['homeAdminStatus'])){
    $home_sql = "update home_work set admin_status = '1' where date='$date'";
    $home_exe = mysql_query($home_sql);
    header("Location: home-work.php?suc=1");
}

else if(isset($_REQUEST['classNotesAdminStatus'])){
    $home_sql = "update class_notes set admin_status = '1' where date='$date'";
    $home_exe = mysql_query($home_sql);
    header("Location: class-notes.php?suc=1");
}

else if(isset($_REQUEST['studAttendanceAdminStatus'])){
    $home_sql = "update attendance set admin_status = '1' where attendance_date='$date'";
    $home_exe = mysql_query($home_sql);
    header("Location: student-attendance.php?suc=1");
}

else if(isset($_REQUEST['projectAdminStatus'])){
    $home_sql = "update project set admin_status = '1' where date='$date'";
    $home_exe = mysql_query($home_sql);
    header("Location: project-list.php?suc=1");
}

/* else if(isset($_REQUEST['remarksAdminStatus'])){
    $home_sql = "update teacher_remarks set admin_status = '1' where remarks_date='$date'";
    $home_exe = mysql_query($home_sql);
    header("Location: teacher-remarks.php?suc=1");
} */


?>