<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_GET['id'])){
    $hid = $_GET['id'];
}
else{
    header("Location: home-work.php?err=1");
}

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;

$home_work_sql = "UPDATE home_work set home_work_status='0', modified_by='$username', updated_at='$date' where id='$hid'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: home-work.php?succ=3");

?>