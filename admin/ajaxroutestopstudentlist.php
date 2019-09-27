<?php
include 'config.php';


if(isset($_REQUEST['stop_name']))
{
    $routeId = $_REQUEST['stop_name'];
}
else{
    exit;
}

//$stop_sql = "select * from stopping_master where stopping_status='1'";
$stop_sql="SELECT * FROM `route_stop` where route_id='$routeId' ORDER BY route_order ASC";

 $stud_sql = "select gen.*, cl.class_name,sa.section_name from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
LEFT JOIN `student_academic` AS sa on sa.user_id = gen.user_id
LEFT JOIN `classes` AS cl on sa.class = cl.id
where usr.delete_status='1' and gen.stop_from = '$stop_name'";

$stud_exe = mysql_query($stud_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    $stop_results[] = array(
        'studentid' => $row['user_id'],
		'studentadmissionid' => $row['admission_number'],
        'studentname' => $row['student_name']
    );
}
echo json_encode($stop_results);

