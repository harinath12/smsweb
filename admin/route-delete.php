<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id']))
{
    $routeId = $_REQUEST['id'];
}
else{
    exit;
}

$route_sql = "UPDATE routes set route_status = '0' where id='$routeId'";
$route_exe = mysql_query($route_sql);

if($route_exe){
    $stop_sql = "DELETE FROM route_stop where route_id='$routeId'";
    $stop_exe = mysql_query($stop_sql);
    header("Location: routes-list.php?suc=2");
}
else{
    header("Location: routes-list.php?err=1");
}

?>