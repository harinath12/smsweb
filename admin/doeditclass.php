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
    $sectionName = $_REQUEST['sectionName'];
    $status = $_REQUEST['status'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `class_section` SET `class_id` = '$className', `section_name` = '$sectionName', `class_section_status` = '$status',
            `modified_by` = '$username', `updated_at` = '$date'
            WHERE `class_section`.`id` = '$classId'";
    $exe = mysql_query($sql);
    header("Location: classes.php?suc=1");
}
else{
    header("Location: classes.php?err=1");
}

?>