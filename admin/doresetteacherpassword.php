<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$teacherId = $_REQUEST['teacherId'];
$newPass = $_REQUEST['new_password'];
$confPass = $_REQUEST['confirm_password'];
$newpassword = md5($newPass);

$sql="SELECT * FROM `users` WHERE `id`='$teacherId' ";
$exe=mysql_query($sql);
$cnt=@mysql_num_rows($exe);
$fet=mysql_fetch_array($exe);

$sql1 = "UPDATE `users` SET `password` = '$newpassword', updated_at='$date' WHERE `users`.`id` = '$teacherId'";
$exe1 = mysql_query($sql1);

header("Location: teacher-view.php?teacher_id=$teacherId");
?>