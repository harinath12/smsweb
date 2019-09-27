<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$className = $_REQUEST['className'];
$term = $_REQUEST['term'];
$subject = $_REQUEST['subject'];
$lesson = $_REQUEST['lesson'];
$chapter = $_REQUEST['chapter'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$sql = "INSERT into chapter_master (class_id, term, subject, lesson, chapter) values ('$className', '$term', '$subject', '$lesson', '$chapter')";
$exe = mysql_query($sql);
header("Location: chapters.php?suc=1");

?>