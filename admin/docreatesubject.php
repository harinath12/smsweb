<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$className = $_REQUEST['className'];
$subjectName = $_REQUEST['subjectName'];
$status = $_REQUEST['status'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$class_sql = "Insert into class_subject (class_id, subject_name, class_subject_status, created_by, updated_by )
values('$className','$subjectName','$status','$username','$username') ";
$class_exe = mysql_query($class_sql);
header("Location: subjects.php?suc=1");

?>