<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$className = $_REQUEST['clsName'];
$sectionName = $_REQUEST['sectionName'];
$cnt = count($sectionName);
$subjectName = $_REQUEST['subjectName'];
$period = $_REQUEST['period'];
//$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
$testName = $_REQUEST['testName'];
$testNames =implode(",",$testName);
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;

if(isset($_FILES['homeWorkFile'])){
    $info = pathinfo($_FILES['homeWorkFile']['name']);
    $base = basename($_FILES['homeWorkFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "homework-" . time() . "." . $ext;
        $target = 'upload/homework/' . $newname;
        $movetarget = '../teacher/upload/homework/' . $newname;
        $moveFile = move_uploaded_file($_FILES['homeWorkFile']['tmp_name'], $movetarget);
    }
}

for($i =0 ; $i<$cnt; $i++){
    $secName = $sectionName[$i];
    $home_sql = "INSERT INTO `home_work` (teacher_id, class, section, subject, period, date, description, home_work_file_path, home_work_test_names, home_work_status, admin_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id','$className', '$secName', '$subjectName', '$period', '$date', '$description', '$target', '$testNames', '1', '1', '$username', '$username', '$date','$date')";
    $home_exe = mysql_query($home_sql);
}

header("Location: home-work.php?succ=1");

?>