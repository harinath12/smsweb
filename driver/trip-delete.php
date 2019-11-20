<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id']))
{
    $tripId = $_REQUEST['id'];
}
else{
    exit;
}

$vehicle_sql = "UPDATE trip set trip_status = '0' where id='$tripId'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    header("Location: trip-list.php?suc=2");
}
else{
    header("Location: trip-list.php?err=1");
}

?>