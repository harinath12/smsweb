<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['section_id'])) {
    $sectionId = $_REQUEST['section_id'];
    $sectionName = $_REQUEST['sectionName'];
    $status = $_REQUEST['status'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `section` SET `section_name` = '$sectionName', `section_status` = '$status',
            `modified_by` = '$username', `updated_at` = '$date'
            WHERE `section`.`id` = '$sectionId'";
    $exe = mysql_query($sql);
    header("Location: section-list.php?suc=1");
}
else{
    header("Location: section-list.php?err=1");
}

?>