<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$subjectName = $_REQUEST['subjectName'];
$status = $_REQUEST['status'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$class_sql = "Insert into subject_master (subject_name, subject_status, created_by, modified_by )
values('$subjectName','$status','$username','$username') ";
$class_exe = mysql_query($class_sql);
header("Location: subject-list.php?suc=1");

?>