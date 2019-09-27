<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['chapter_id'])) {
    $chapterId = $_REQUEST['chapter_id'];
    $className = $_REQUEST['className'];
    $term = $_REQUEST['term'];
    $subject = $_REQUEST['subject'];
    $lesson = $_REQUEST['lesson'];
    $chapter = $_REQUEST['chapter'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `chapter_master` SET `class_id` = '$className', `term` = '$term', `subject` = '$subject', `lesson` = '$lesson', `chapter` = '$chapter', `updated_at` = '$date'
            WHERE `id` = '$chapterId'";
    $exe = mysql_query($sql);
    header("Location: chapters.php?suc=1");
}
else{
    header("Location: chapters.php?err=1");
}

?>