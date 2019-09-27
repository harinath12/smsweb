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

$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];
$description = $_REQUEST['description'];

$projtarget1 = null;
$projtarget2 = null;
$projtarget3 = null;

if(isset($_FILES['project1'])){
    $profinfo1 = pathinfo($_FILES['project1']['name']);
    $projbase1 = basename($_FILES['project1']['name']);
    if(!empty($projbase1)) {
        $projext1 = $profinfo1['extension'];
        $projname1 = "project-" . $className.$sectionName.$subjectName. $normaldate . "-1." . $projext1;
        $projtarget1 = 'upload/project/' . $projname1;
        $moveprojFile1 = move_uploaded_file($_FILES['project1']['tmp_name'], $projtarget1);
    }
}

if(isset($_FILES['project2'])){
    $profinfo2 = pathinfo($_FILES['project2']['name']);
    $projbase2 = basename($_FILES['project2']['name']);
    if(!empty($projbase2)) {
        $projext2 = $profinfo2['extension'];
        $projname2 = "project-" . $className.$sectionName.$subjectName. $normaldate . "-2." . $projext2;
        $projtarget2 = 'upload/project/' . $projname2;
        $moveprojFile2 = move_uploaded_file($_FILES['project2']['tmp_name'], $projtarget2);
    }
}

if(isset($_FILES['project3'])){
    $profinfo3 = pathinfo($_FILES['project3']['name']);
    $projbase3 = basename($_FILES['project3']['name']);
    if(!empty($projbase3)) {
        $projext3 = $profinfo3['extension'];
        $projname3 = "project-" . $className.$sectionName.$subjectName. $normaldate . "-3." . $projext3;
        $projtarget3 = 'upload/project/' . $projname3;
        $moveprojFile3 = move_uploaded_file($_FILES['project3']['tmp_name'], $projtarget3);
    }
}

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$user_sql = "INSERT INTO `project` (teacher_id, class, section, subject, date, description, project1, project2, project3, project_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id','$className', '$sectionName', '$subjectName', '$date','$description','$projtarget1', '$projtarget2', '$projtarget3', '1','$username', '$username', '$date','$date')";
$user_exe = mysql_query($user_sql);

header("Location: project-list.php?succ=1");

?>