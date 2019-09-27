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

$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];
$title = $_REQUEST['event_title'];
$type = $_REQUEST['event_type'];

$event_sql = "INSERT INTO `calendar` (calendar_title, calendar_type, calendar_start_date, calendar_end_date, calendar_status, created_by, updated_by, created_at, updated_at)
VALUES ('$title', '$type', '$fromdate', '$todate', '1', '$username', '$username', '$date','$date')";
$event_exe = mysql_query($event_sql);

header("Location: calendar.php?succ=1");

?>