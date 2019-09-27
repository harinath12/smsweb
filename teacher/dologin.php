<?php
error_reporting(0);
session_start();
ob_start();

if(isset($_SESSION['adminuserid']))
{
    header("Location: dashboard.php");
}

/*
$_SESSION['scaleuppuser']="1";
header("Location: index.php");
*/

include "config.php";

if(isset($_REQUEST['login']))
{
    $email=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    $password_md5=md5($password);
    $sql="SELECT * FROM `users`
LEFT JOIN `role_user` ON users.id = role_user.user_id
WHERE `email`='$email' AND `password`='$password_md5' and `delete_status`='1' and role_id=3";
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
        $fet=@mysql_fetch_array($exe);
        $user_id=$fet['id'];

        $role_sql="SELECT * FROM `role_user` WHERE `user_id`='$user_id'";
        $role_exe=mysql_query($role_sql);
        $role_fet=@mysql_fetch_array($role_exe);
        $role_id=$role_fet['role_id'];


        $_SESSION['adminuserid']=$user_id;
        $_SESSION['adminusername']=$fet['name'];

        $_SESSION['adminuseremail']=$fet['email'];
        $_SESSION['adminuserrole']=$role_id;

        header("Location: dashboard.php");
    }
    else
    {
        header("Location: index.php?err=1");
    }
}
else
{
    header("Location: index.php?err=1");
}
?>