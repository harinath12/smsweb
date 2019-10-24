<?php
function get_calendar(){
	$data = array();

	$sql="SELECT * from calendar WHERE calendar_status=1";
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
        
        while($row=@mysql_fetch_assoc($exe)){
            $classes = explode(',',$row['calendar_classes']);
            if(count($classes) == 0 || in_array('All', $classes) || in_array($_GET['class'], $classes)){
                if($row['calendar_type'] == 1){
                    $tdata = array('title' => $row['calendar_title'], 'start' => $row['calendar_start_date'], 'className' => array('event', 'greenEvent'));
                } elseif($row['calendar_type'] == 2) {
                    $tdata = array('title' => $row['calendar_title'], 'start' => $row['calendar_start_date'], 'className' => array('event', 'blueEvent'));
                }
                if($row['calendar_end_date']!="") { 
                    while(strtotime($row['calendar_start_date'])<=strtotime($row['calendar_end_date'])){
                       $tdata['start'] = $row['calendar_start_date'];
                       $data[] = $tdata; 
                       $row['calendar_start_date'] = date('Y-m-d', strtotime('+1 day', strtotime($row['calendar_start_date'])));
                    }
                } else {
                    $data[] = $tdata;
                }
            }
            
            
        }
    }

    return $data = array('status' => 'Success', 'data' => $data);
}