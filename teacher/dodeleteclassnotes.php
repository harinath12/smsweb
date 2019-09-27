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
    header("Location: class-notes.php?err=1");
}

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;

$home_work_sql = "UPDATE class_notes set class_notes_status='0', modified_by='$username', updated_at='$date' where id='$hid'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: class-notes.php?succ=3");

?>