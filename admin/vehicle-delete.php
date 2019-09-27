<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id']))
{
    $vehicleId = $_REQUEST['id'];
}
else{
    exit;
}

$vehicle_sql = "UPDATE vehicles set vehicle_status = '0' where id='$vehicleId'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    header("Location: vehicles-list.php?suc=2");
}
else{
    header("Location: vehicles-list.php?err=1");
}

?>