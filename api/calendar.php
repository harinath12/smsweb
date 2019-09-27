<?php
function get_calendar(){
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

    return $data = array('status' => 'Success', 'data' => $data);
}