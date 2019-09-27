<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['class_id'])) {
    $classId = $_REQUEST['class_id'];
    $className = $_REQUEST['className'];
    $status = $_REQUEST['status'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `classes` SET `class_name` = '$className', `class_status` = '$status',
            `modified_by` = '$username', `updated_at` = '$date'
            WHERE `classes`.`id` = '$classId'";
    $exe = mysql_query($sql);
    header("Location: class-list.php?suc=1");
}
else{
    header("Location: class-list.php?err=1");
}

?>