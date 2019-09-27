<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$subjectId = $_REQUEST['subjectid'];
$subjectName = $_REQUEST['subjectName'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$sub_count = count($subjectId);

for($i = 0; $i<$sub_count; $i++){
    $id = $subjectId[$i];
    $subname = $subjectName[$i];

    $sql = "UPDATE `class_subject` SET `subject_name` = '$subname', `class_subject_status` = '1', `updated_by` = '$username', updated_at='$date' WHERE `id` = '$id'";
    $exe = mysql_query($sql);
}

header("Location: subjects.php?suc=1");

?>