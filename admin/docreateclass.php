<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$status = $_REQUEST['status'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$class_sql = "Insert into class_section (class_id, section_name, class_section_status, created_by, modified_by, created_at, updated_at )
values('$className','$sectionName','$status','$username','$username','$date','$date') ";
$class_exe = mysql_query($class_sql);
header("Location: classes.php?suc=1");

?>