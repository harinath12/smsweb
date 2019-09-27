<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$stop = $_REQUEST['stopping_name'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$stop_sql = "INSERT into stopping_master (stopping_name, created_by, created_at) values ('$stop', '$username', '$date')";
$stop_exe = mysql_query($stop_sql);
header("Location: stops.php?suc=1");

?>