<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_GET['id'])){
    $examid = $_GET['id'];
}
else{
    header("Location: exam-time-table.php?err=1");
}

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;

$del_exam_sql = "UPDATE exam_time_table set exam_status='0', updated_by='$username', updated_at='$date' where id='$examid'";
$del_exam_exe = mysql_query($del_exam_sql);

header("Location: exam-time-table.php?succ=3");

?>