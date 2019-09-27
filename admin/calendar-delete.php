<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$event_sql = "UPDATE `calendar` set calendar_status = 0, updated_by='$username', updated_at='$date' where id='$id'";
$event_exe = mysql_query($event_sql);

header("Location: calendar.php?succ=2");

?>