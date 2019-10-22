<?php
function get_student_attendance(){
	$user_id = $_REQUEST['user_id'];
	$data = array();
    $today = '';
	$sql="SELECT * from calendar WHERE calendar_status=1";
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
    	
        while($row=@mysql_fetch_assoc($exe)){
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

    $sql="SELECT * from attendance where user_id = ".$user_id;
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    while($row=@mysql_fetch_assoc($exe)){
        $att_fetch = $row;
        $calendar_remark = $att_fetch['remarks'];

        if($att_fetch['forenoon']=='on' && $att_fetch['afternoon']=='on') {
        $calendar_title = "Present";
        $calendar_type = 1;
        }
        else if($att_fetch['forenoon']=='off' && $att_fetch['afternoon']=='off') {
        $calendar_title = "Absent - ".$calendar_remark;
        $calendar_type = 2;
        }
        else if($att_fetch['forenoon']=='on' && $att_fetch['afternoon']=='off') {
        $calendar_title = "Afternoon Absent - ".$calendar_remark;
        $calendar_type = 2;
        }
        else if($att_fetch['forenoon']=='off' && $att_fetch['afternoon']=='on') {
        $calendar_title = "Forenoon Absent - ".$calendar_remark;
        $calendar_type = 2;
        }
        else {
        $calendar_title = "Absent - ".$calendar_remark;
        $calendar_type = 2;
        }
        
        
        $calendar_start_date = $att_fetch['attendance_date'];
        $calendar_end_date = "";
        $tdata = false;
        if($calendar_type==1){
            $tdata = array('title' => $calendar_title, 'end' => $calendar_end_date, 'start' => $calendar_start_date, 'className' => array('event', 'presentEvent'));
        } elseif($calendar_type==2) {
            if($att_fetch['leave_status']=='1') {
                $tdata = array('title' => $calendar_title, 'end' => $calendar_end_date, 'start' => $calendar_start_date, 'className' => array('event', 'leaveEvent'));
            } else {
                $tdata = array('title' => $calendar_title, 'end' => $calendar_end_date, 'start' => $calendar_start_date, 'className' => array('event', 'absentEvent'));
            }
        }

        if($tdata){
            $data[] = $tdata;

            if($calendar_start_date == date('Y-m-d')){
                $today = $calendar_title;
            }
        }
    }


    $current_date=date("Y-m-d");

    $reopen_date = 0;
    $reopen_sql = "SELECT *  FROM `calendar` WHERE `calendar_title` LIKE 'School Re-Opened' AND `calendar_status`=1 ORDER BY `calendar_start_date` ASC";
    $reopen_exe = mysql_query($reopen_sql);
    $reopen_cnt = @mysql_num_rows($reopen_exe);
    if($reopen_cnt>0)
    {
        $reopen_fet = mysql_fetch_array($reopen_exe);
        $reopen_date = $reopen_fet['calendar_start_date'];
    }
    //echo $reopen_date;
    //echo "<br/>";

    //HOLIDAYS COUNT
    $holidays_date = 0;
    $holidays_sql = "SELECT SUM(calendar_status) AS holidays FROM `calendar` WHERE `calendar_type`=1 AND `calendar_status`=1 ORDER BY `id` ASC ";
    $holidays_exe = mysql_query($holidays_sql);
    $holidays_cnt = @mysql_num_rows($holidays_exe);
    if($holidays_cnt>0)
    {
        $holidays_fet = mysql_fetch_array($holidays_exe);
        $holidays_date = $holidays_fet['holidays'];
    }
    //echo $holidays_date;
    //echo "<br/>";

    //SUNDAYS COUNT
    /*
    $start = new DateTime($reopen_date);
    $end   = new DateTime($current_date);
    $days = $start->diff($end, true)->days;
    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    echo $sundays;
    */
    $sunday_date = 0;
    $start = new DateTime($reopen_date);
    $end   = new DateTime($current_date);
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($start, $interval, $end);
    foreach ($period as $dt)
    {
        if ($dt->format('N') == 7)
        {
            $sunday_date++;
        }
    }
    //echo $sunday_date;
    //echo "<br/>";

    //DATEDIFF COUNT
    $date_diff_date = 0;
    $current_date=date("Y-m-d");
    $date_diff_sql = "SELECT DATEDIFF('$current_date','$reopen_date') AS `days`";
    $date_diff_exe = mysql_query($date_diff_sql);
    $date_diff_cnt = @mysql_num_rows($date_diff_exe);
    if($date_diff_cnt>0)
    {
        $date_diff_fet = mysql_fetch_array($date_diff_exe);
        $date_diff_date = $date_diff_fet['days'];
    }
    //echo $date_diff_date;
    //echo "<br/>";

    $noofholiday = $sunday_date+$holidays_date;
    $noofworking = $date_diff_date-$noofholiday;
    /* */
    //echo $noofworking;

    /* */
    $forenoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `forenoon`='on'"));
    $afternoon = mysql_fetch_array(mysql_query("SELECT COUNT(user_id)  FROM `attendance` WHERE `user_id` = '$user_id' AND `afternoon`='on'"));
    $days = ($forenoon[0]+$afternoon[0])/2;

    return array('status' => 'Success', 'data' => $data, 'noofworking' => $noofworking, 'noofpresent' => $days, 'today' => $today);
}