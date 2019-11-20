<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

date_default_timezone_set('Asia/Kolkata');
$time = date('h:i a', time());

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("d-m-Y");

if(isset($_REQUEST['endtrip'])){
    if($_REQUEST['endtrip'] == 1){
        $trip_id = $_REQUEST['tripId'];
        $endreadings = $_REQUEST['endreadings'];

        $end_trip_sql = "UPDATE trip SET end_km_readings='$endreadings', end_status='1', trip_end_time='$time' where id = '$trip_id'";
        $end_trip_exe = mysql_query($end_trip_sql);

        header("Location: trip-list.php?succ=1");
    }
}

else{
    $bus_no = $_REQUEST['bus_no'];
    $route_no = $_REQUEST['route_no'];
    $pickup_drop = $_REQUEST['pickup_drop'];
    $distance = $_REQUEST['distance'];

    $trip_sql = "INSERT INTO `trip` (bus_no, driver_id, route_no, pickup_drop, distance, trip_date, trip_time, start_status, created_by) VALUES
('$bus_no', '$user_id', '$route_no', '$pickup_drop', '$distance', '$date', '$time', '1','$username')";
    $trip_exe = mysql_query($trip_sql);

    if($trip_exe){
        $trip_id = mysql_insert_id();
        header("Location: trip-edit.php?id=$trip_id&succ=1");
    }
    else{
        header("Location: trip.php?err=1");
    }
}

?>