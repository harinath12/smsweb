<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$routeId = $_REQUEST['routeId'];
$route_no = $_REQUEST['route_no'];
$num_of_stopping = $_REQUEST['num_of_stopping'];
$pickup_start = $_REQUEST['pickup_start'];
$pickup_end = $_REQUEST['pickup_end'];
$drop_start = $_REQUEST['drop_start'];
$drop_end = $_REQUEST['drop_end'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$route_sql = "UPDATE routes SET route_no = '$route_no', num_of_stopping = '$num_of_stopping', pickup_starting_point = '$pickup_start',
pickup_ending_point = '$pickup_end', dropping_starting_point = '$drop_start', dropping_ending_point = '$drop_end', updated_by = '$username' where id='$routeId'";
$route_exe = mysql_query($route_sql);

$stop_sql = "DELETE FROM route_stop where route_id='$routeId'";
$stop_exe = mysql_query($stop_sql);

$stop_name = $_REQUEST['stop_name'];
$distance = $_REQUEST['distance'];
$order = $_REQUEST['order'];
$stop_count = count($stop_name);
for($s=0;$s<$stop_count;$s++)
{
    if(!empty($stop_name[$s]))
    {
        $insert_stop = "INSERT INTO `route_stop` (`route_id`, `stop_name`, `distance`, `route_order`, `updated_by`) VALUES ('$routeId','$stop_name[$s]','$distance[$s]','$order[$s]', '$username')";
        $insert_stop_exe = mysql_query($insert_stop);
    }
}

header("Location: route-view.php?id=$routeId&suc=1");

?>