<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

print_r($_REQUEST);

echo "<hr/>";

$stop_name = $_REQUEST['stop_name'];
$student_name = $_REQUEST['student_name'];

echo "<hr/>";
print_r($stop_name);

echo "<hr/>";

print_r($student_name);

/*
$route_no = $_REQUEST['route_no'];
$num_of_stopping = $_REQUEST['num_of_stopping'];
$pickup_start = $_REQUEST['pickup_start'];
$pickup_end = $_REQUEST['pickup_end'];
$drop_start = $_REQUEST['drop_start'];
$drop_end = $_REQUEST['drop_end'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$route_sql = "INSERT into routes (route_no, num_of_stopping, pickup_starting_point, pickup_ending_point, dropping_starting_point, dropping_ending_point, route_status, created_by)
values ('$route_no', '$num_of_stopping', '$pickup_start', '$pickup_end', '$drop_start','$drop_end', '1', '$username')";
$route_exe = mysql_query($route_sql);
$routeId = mysql_insert_id();

$stop_name = $_REQUEST['stop_name'];
$distance = $_REQUEST['distance'];
$order = $_REQUEST['order'];
$stop_count = count($stop_name);
for($s=0;$s<$stop_count;$s++)
{
    if(!empty($stop_name[$s]))
    {
        $insert_stop = "INSERT INTO `route_stop` (`route_id`, `stop_name`, `distance`, `route_order`, `created_by`) VALUES ('$routeId','$stop_name[$s]','$distance[$s]','$order[$s]', '$username')";
        $insert_stop_exe = mysql_query($insert_stop);
    }
}

header("Location: routes-list.php?suc=1");
*/

?>