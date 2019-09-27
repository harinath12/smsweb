<?php session_start();
ob_start();

if(isset($_SESSION['adminuserid']))
{
    header("Location: dashboard.php");
}

include "config.php";

$email=$_REQUEST['email'];
$password=$_REQUEST['password'];
$password_md5=md5($password);
$sql="SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password_md5' and (`id`='1' or id=2 or id=3)";
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

?>