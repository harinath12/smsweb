<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$exam_name = $_REQUEST['exam_name'];
$className = $_REQUEST['className'];
$startdate = $_REQUEST['start_date'];
$enddate = $_REQUEST['end_date'];

$class_cnt = count($className);
if($class_cnt == 1){
    if($className[0] == 100){
        $class_cnt = 15;
        for($i = 0; $i<15; $i++){
            $className[$i] = $i + 1;
        }
    }
}

/*
for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
	echo $i;
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
*/

$start = strtotime($startdate);
$end = strtotime($enddate);
$days_between = ceil(abs($end - $start) / 86400);
for($i=0;$i <= $days_between; $i++)
{
	$si = date('d-m-Y', strtotime($startdate . ' + '.$i.' days'));
	
	if (date('N', strtotime($si)) <= 6) {
        $examdate[] = $si;
    }
	
}

//print_r($examdate);

$examdate_cnt = count($examdate);
//echo $examdate[1]; exit;
//echo $examdate_cnt;

$examdate_cnt = count($examdate);
//echo $examdate[1]; exit;
//echo $examdate_cnt;
$exam_sql = "INSERT INTO `exam_time_table` (exam_name, start_date, end_date, created_by, updated_by, created_at, updated_at) VALUES
('$exam_name','$startdate', '$enddate', '$username', '$username', '$date','$date')";
$exam_exe = mysql_query($exam_sql);
$last_id = mysql_insert_id();
//echo $last_id; exit;
//echo $exam_sql;

for($j=0; $j<$class_cnt; $j++) {
    for($z = 0; $z < $examdate_cnt; $z++) {
        $subject = $_REQUEST['subject'.$j.$z];
        $session = $_REQUEST['session'.$j.$z];
        $examdat = $examdate[$z];
        $class_id = $className[$j];
    if(!empty($subject)){
        $time_table_sql = "INSERT into exam_date_subject (exam_id, exam_date, class_id, subject_name, exam_session, created_by, updated_by, created_at, updated_at) VALUES
('$last_id','$examdat', '$class_id', '$subject', '$session', '$username', '$username', '$date','$date')";
        $time_table_exe = mysql_query($time_table_sql);
		
		//echo $time_table_sql;
		
    }
    }
}

header("Location: exam-time-table.php?succ=1");

?>