<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_GET["id"])) {
    $stopId = $_GET["id"];
    $del_stop_sq1 = "DELETE FROM stopping_master where id = '$stopId'";
    $del_stop_exe = mysql_query($del_stop_sq1);

    header("Location: stops.php?suc=2");
}

else{
    header("Location: stops.php?err=1");
}

?>