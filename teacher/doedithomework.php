<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$homeworkId = $_REQUEST['homeworkId'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];
//echo $subjectName; exit;
$period = $_REQUEST['period'];
//$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
$testName = $_REQUEST['testName'];
$testNames =implode(",",$testName);

$username = $_SESSION['adminusername'];

$target = null;

if(isset($_FILES['homeWorkFile'])){
    $info = pathinfo($_FILES['homeWorkFile']['name']);
    $base = basename($_FILES['homeWorkFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "homework-" . $className.$sectionName.$subjectName. $normaldate . "." . $ext;
        $target = 'upload/homework/' . $newname;
        $moveFile = move_uploaded_file($_FILES['homeWorkFile']['tmp_name'], $target);

        $hw_attachment_sql = "UPDATE home_work set home_work_file_path='$target', modified_by='$username', updated_at='$date' where id='$homeworkId'";
        $hw_attachment_exe = mysql_query($hw_attachment_sql);
    }
}

$home_work_sql = "UPDATE home_work set subject='$subjectName', period='$period', description='$description', home_work_test_names ='$testNames', modified_by='$username', updated_at='$date' where id='$homeworkId'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: home-work.php?succ=2");

?>