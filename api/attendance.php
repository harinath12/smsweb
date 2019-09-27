<?php
function get_student_attendance(){
	$user_id = $_REQUEST['user_id'];
	$data = array();

	$sql="SELECT * from calendar where calendar_status = 1";
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
    	
        while($row=@mysql_fetch_array($exe)){
        	if($row['calendar_type'] == 1){
        		$data[] = array('title' => $row['calendar_title'], 'start' => $row['calendar_start_date'], 'className' => array('event', 'blueEvent'));
        	} elseif($row['calendar_type'] == 2) {
        		$data[] = array('title' => $row['calendar_title'], 'start' => $row['calendar_start_date'], 'className' => array('event', 'greenEvent'));
        	}
        }
    }

    $sql="SELECT * from attendance where user_id = ".$user_id;
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
    	
        while($row=@mysql_fetch_array($exe)){
        	if($row['forenoon'] == 'on' || $row['afternoon'] == 'on'){
        		$data[] = array('title' => 'Present', 'start' => $row['attendance_date'], 'className' => array('event', 'presentEvent'));
        	} elseif($row['calendar_type'] == 2) {
        		$data[] = array('title' => 'Absent', 'start' => $row['attendance_date'], 'className' => array('event', 'absentEvent'));
        	}
        }
    }

    return array('status' => 'Success', 'data' => $data);
}