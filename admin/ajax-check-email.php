<?php
include "config.php";
$user_status = array();
$email=$_REQUEST['email'];
$user_sql="SELECT * FROM `users` WHERE `email`='$email'";
$user_exe=mysql_query($user_sql);
$user_cnt=mysql_num_rows($user_exe);
if($user_cnt==0)
{
    $user_status['status']="1";
    $user_status['email']=$email;
}
else
{
    $user_status['status']="2";
    $user_status['email']=$email;
}
echo html_entity_decode(json_encode($user_status));
?>

