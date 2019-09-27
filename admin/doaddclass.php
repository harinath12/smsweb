<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$className = $_REQUEST['className'];
$status = $_REQUEST['status'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$class_sql = "Insert into classes (class_name, class_status, created_by, modified_by, created_at, updated_at )
values('$className','$status','$username','$username','$date','$date') ";
$class_exe = mysql_query($class_sql);
header("Location: class-list.php?suc=1");

?>