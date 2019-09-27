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
$id = $_REQUEST['id'];
/*
$update_gal = mysql_query("UPDATE gallery set admin_status='1' where gallery_status='1'");
*/

$update_gal = mysql_query("UPDATE gallery SET `admin_status`='1' WHERE `gallery_status`='1' AND `id`='$id'");
header("Location: gallery.php?succ=1");

?>