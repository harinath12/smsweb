<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$bus_no = $_REQUEST['bus_no'];
$bus_reg_no = $_REQUEST['bus_reg_no'];
$vehicle_type = $_REQUEST['vehicle_type'];
$insurance = $_REQUEST['insurance'];
$fc = $_REQUEST['fc'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$sql = "INSERT into vehicles (bus_no, bus_registration_no, vehicle_type, insurance_ending_date, fc_ending_date, vehicle_status)
values ('$bus_no', '$bus_reg_no', '$vehicle_type', '$insurance', '$fc', '1')";
$exe = mysql_query($sql);
header("Location: vehicles-list.php?suc=1");

?>