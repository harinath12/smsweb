<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$oldPass = $_REQUEST['old_password'];
$newPass = $_REQUEST['new_password'];
$confPass = $_REQUEST['confirm_password'];

$sql="SELECT * FROM `users` WHERE `id`='$user_id' ";
$exe=mysql_query($sql);
$cnt=@mysql_num_rows($exe);
$fet=mysql_fetch_array($exe);

$newpassword = md5($newPass);

if($fet['password'] == md5($oldPass)){
    $sql1 = "UPDATE `users` SET `password` = '$newpassword' WHERE `users`.`id` = '$user_id'";
    $exe1 = mysql_query($sql1);

    unset($_SESSION['adminuserid']);
    unset($_SESSION['adminusername']);
    unset($_SESSION['adminuseremail']);
    unset($_SESSION['adminuserrole']);

    header("Location: index.php?success=1");
}

else{
    header("Location: change-password.php?err=1");
}

?>