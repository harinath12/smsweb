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

$id = $_REQUEST['event_id'];
$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];
$title = $_REQUEST['event_title'];

$event_sql = "UPDATE `calendar` set calendar_title='$title', calendar_start_date='$fromdate', calendar_end_date='$todate', updated_by='$username', updated_at='$date' where id='$id'";
$event_exe = mysql_query($event_sql);

header("Location: calendar.php?succ=3");

?>