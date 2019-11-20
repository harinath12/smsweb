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

$stop_name = $_REQUEST['stop_name'];
$route_id = $_REQUEST['route_id'];
$trip_id = $_REQUEST['trip_id'];
$student_id = $_REQUEST['student_id'];
$extra_student_id = $_REQUEST['extra_student_id'];
$cnt = count($student_id);
$extra_cnt = count($extra_student_id);

$stud_sql = "select gen.* from student_general as gen
LEFT JOIN users as usr on usr.id = gen.user_id
where usr.delete_status='1' and gen.stop_from = '$stop_name'";
$stud_exe = mysql_query($stud_sql);
$stud_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    array_push($stud_results, $row);
}
$stud_cnt = count($stud_results);

$trip_sql = "INSERT INTO `trip_stop` (trip_id, trip_stop_name, trip_time, trip_stop_status, created_by) VALUES
('$trip_id','$stop_name', '$time', '1','$username')";
$trip_exe = mysql_query($trip_sql);

if($trip_exe){
	/*
    for($i =0; $i<$stud_cnt; $i++){
        $stu_id = $stud_results[$i]['user_id'];
        $trip_stud_sql = "INSERT INTO `trip_student` (trip_id, student_id, route_id, trip_student_status, created_by) VALUES
('$trip_id', '$stu_id', '$route_id', '0','$username')";
        $trip_stud_exe = mysql_query($trip_stud_sql);
    }
	*/

    for($j=0; $j<$cnt; $j++){
        $stud_id = $student_id[$j];
        //$trip_student_sql = "UPDATE `trip_student` set trip_student_status ='1' where trip_id='$trip_id' and student_id='$stud_id'";
        //$trip_student_exe = mysql_query($trip_student_sql);
		
		$trip_stud_sql = "INSERT INTO `trip_student` (trip_id, student_id, route_id, stop_id, trip_student_status, created_by) VALUES
('$trip_id', '$stud_id', '$route_id', '$stop_name', '1','$username')";
        $trip_stud_exe = mysql_query($trip_stud_sql);

    }
	
	for($k=0; $k<$extra_cnt; $k++){
		$stud_id = $extra_student_id[$k];
		$trip_stud_sql = "INSERT INTO `trip_student` (trip_id, student_id, route_id, stop_id, trip_student_status, temp_status, created_by) VALUES
('$trip_id', '$stud_id', '$route_id', '$stop_name', '1', '1','$username')";
        $trip_stud_exe = mysql_query($trip_stud_sql);
    }
	
	

    header("Location: trip-edit.php?id=$trip_id&succ=1");
}

else{
    header("Location: trip.php?err=1");
}


?>