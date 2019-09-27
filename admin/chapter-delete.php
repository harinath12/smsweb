<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_GET["chapter_id"])) {
    $chapterId = $_GET["chapter_id"];
    $del_chapter_sq1 = "DELETE FROM chapter_master where id = '$chapterId'";
    $del_chapter_exe = mysql_query($del_chapter_sq1);

    header("Location: chapters.php?suc=2");
}

else{
    header("Location: chapters.php?err=1");
}

?>