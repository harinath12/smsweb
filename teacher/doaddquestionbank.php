<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$classId = $_REQUEST['classId'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];
$otherType = $_REQUEST['otherType'];

$ques_sql = "INSERT INTO `question_bank` (class_id, subject_name, term, chapter, question_type, other_type, question_bank_status, created_by, updated_by, created_at, updated_at) VALUES
('$classId', '$subjectName', '$term', '$chapter', '$questionType', '$otherType','1','$username', '$username', '$date','$date')";
$ques_exe = mysql_query($ques_sql);
$questionbank_id = mysql_insert_id();

header("Location: questions.php?question_bank_id=$questionbank_id");

?>