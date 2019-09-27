
<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$sectionName = $_REQUEST['sectionName'];
$status = $_REQUEST['status'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$class_sql = "Insert into section (section_name, section_status, created_by, modified_by, created_at, updated_at )
values('$sectionName','$status','$username','$username','$date','$date') ";
$class_exe = mysql_query($class_sql);
header("Location: section-list.php?suc=1");

?>