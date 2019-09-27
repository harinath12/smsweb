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

$className = $_REQUEST['clsName'];
$sectionName = $_REQUEST['sectionName'];
$cnt = count($sectionName);
$subjectName = $_REQUEST['subjectName'];
$termName = $_REQUEST['termName'];
$chapter = $_REQUEST['chapterName'];
$description = $_REQUEST['description'];

$projtarget1 = null;
$projtarget2 = null;
$projtarget3 = null;

if(isset($_FILES['project1'])){
    $profinfo1 = pathinfo($_FILES['project1']['name']);
    $projbase1 = basename($_FILES['project1']['name']);
    if(!empty($projbase1)) {
        $projext1 = $profinfo1['extension'];
        $projname1 = "book-" . $className.$sectionName.$subjectName. $normaldate . "-1." . $projext1;
        $projtarget1 = 'upload/book/' . $projname1;
        $moveprojFile1 = move_uploaded_file($_FILES['project1']['tmp_name'], $projtarget1);
    }
}

if(isset($_FILES['project2'])){
    $profinfo2 = pathinfo($_FILES['project2']['name']);
    $projbase2 = basename($_FILES['project2']['name']);
    if(!empty($projbase2)) {
        $projext2 = $profinfo2['extension'];
        $projname2 = "book-" . $className.$sectionName.$subjectName. $normaldate . "-2." . $projext2;
        $projtarget2 = 'upload/book/' . $projname2;
        $moveprojFile2 = move_uploaded_file($_FILES['project2']['tmp_name'], $projtarget2);
    }
}

if(isset($_FILES['project3'])){
    $profinfo3 = pathinfo($_FILES['project3']['name']);
    $projbase3 = basename($_FILES['project3']['name']);
    if(!empty($projbase3)) {
        $projext3 = $profinfo3['extension'];
        $projname3 = "book-" . $className.$sectionName.$subjectName. $normaldate . "-3." . $projext3;
        $projtarget3 = 'upload/book/' . $projname3;
        $moveprojFile3 = move_uploaded_file($_FILES['project3']['tmp_name'], $projtarget3);
    }
}

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
 $secName = "";
    $user_sql = "INSERT INTO `books` (teacher_id, class, section, subject, term, chapter, date, description, project1, project2, project3, project_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id','$className', '$secName', '$subjectName', '$termName', '$chapter', '$date', '$description','$projtarget1', '$projtarget2', '$projtarget3', '1','$username', '$username', '$date','$date')";
    $user_exe = mysql_query($user_sql);


header("Location: book-list.php?succ=1");

?>