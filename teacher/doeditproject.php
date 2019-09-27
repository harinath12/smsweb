<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$projectId = $_REQUEST['projectId'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];
$title = $_REQUEST['title'];
$description = $_REQUEST['description'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$target = null;

if(isset($_FILES['project1'])){
    $profinfo1 = pathinfo($_FILES['project1']['name']);
    $projbase1 = basename($_FILES['project1']['name']);
    if(!empty($projbase1)) {
        $projext1 = $profinfo1['extension'];
        $projname1 = "project-" . $className.$sectionName.$subjectName. $normaldate . "-1." . $projext1;
        $projtarget1 = 'upload/project/' . $projname1;
        $moveprojFile1 = move_uploaded_file($_FILES['project1']['tmp_name'], $projtarget1);

        $proj_attach_sql = "UPDATE project set project1='$projtarget1', modified_by='$username', updated_at='$date' where id='$projectId'";
        $proj_attach_exe = mysql_query($proj_attach_sql);
    }
}

if(isset($_FILES['project2'])){
    $profinfo2 = pathinfo($_FILES['project2']['name']);
    $projbase2 = basename($_FILES['project2']['name']);
    if(!empty($projbase2)) {
        $projext2 = $profinfo2['extension'];
        $projname2 = "project-" . $className.$sectionName.$subjectName. $normaldate . "-2." . $projext2;
        $projtarget2= 'upload/project/' . $projname2;
        $moveprojFile2 = move_uploaded_file($_FILES['project2']['tmp_name'], $projtarget2);

        $proj2_attach_sql = "UPDATE project set project2='$projtarget2', modified_by='$username', updated_at='$date' where id='$projectId'";
        $proj2_attach_exe = mysql_query($proj2_attach_sql);
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

        $proj3_attach_sql = "UPDATE project set project3='$projtarget3', modified_by='$username', updated_at='$date' where id='$projectId'";
        $proj3_attach_exe = mysql_query($proj3_attach_sql);
    }
}

$home_work_sql = "UPDATE project set subject='$subjectName', title='$title', description='$description', modified_by='$username', updated_at='$date' where id='$projectId'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: project-list.php?succ=2");

?>