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
$normaldate = date("d-m-Y");

$fee_id = $_REQUEST['fee_id'];

$fee_sql = "UPDATE `fee_info` set fee_status=0, updated_date='$date' where id='$fee_id'";
$fee_exe = mysql_query($fee_sql);

header("Location: fees_list.php?del=1");

?>