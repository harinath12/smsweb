<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$vehicle_id = $_REQUEST['vehicle_id'];
$bus_no = $_REQUEST['bus_no'];
$bus_reg_no = $_REQUEST['bus_reg_no'];
$vehicle_type = $_REQUEST['vehicle_type'];
$insurance = $_REQUEST['insurance'];
$fc = $_REQUEST['fc'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$vehicle_sql = "UPDATE vehicles set bus_no = '$bus_no', bus_registration_no = '$bus_reg_no', vehicle_type = '$vehicle_type', insurance_ending_date = '$insurance', fc_ending_date = '$fc' where id='$vehicle_id'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    header("Location: vehicle-view.php?id=$vehicle_id&suc=1");
}
else{
    header("Location: vehicle-edit.php?err=1");
}

?>