<?php
include 'config.php';


if(isset($_REQUEST['id']))
{
    $routeId = $_REQUEST['id'];
}
else{
    exit;
}

//$stop_sql = "select * from stopping_master where stopping_status='1'";
$stop_sql="SELECT * FROM `route_stop` where route_id='$routeId' ORDER BY route_order ASC";
$stop_exe = mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    $stop_results[] = array(
        'stopid' => $row['id'],
        'stopname' => $row['stop_name']
    );
}
echo json_encode($stop_results);

