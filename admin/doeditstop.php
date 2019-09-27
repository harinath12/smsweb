<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['stop_id'])) {
    $stop_id = $_REQUEST['stop_id'];
    $stopping_name = $_REQUEST['stopping_name'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `stopping_master` SET `stopping_name` = '$stopping_name', `updated_at` = '$date' WHERE `id` = '$stop_id'";
    $exe = mysql_query($sql);
    header("Location: stops.php?suc=1");
}
else{
    header("Location: stops.php?err=1");
}

?>