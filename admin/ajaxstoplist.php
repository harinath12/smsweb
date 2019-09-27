<?php
include 'config.php';

$stop_sql = "select * from stopping_master where stopping_status='1'";
$stop_exe = mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    $stop_results[] = array(
        'stopid' => $row['id'],
        'stopname' => $row['stopping_name']
    );
}
echo json_encode($stop_results);

