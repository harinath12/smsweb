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

$exam_name = $_REQUEST['editexamname'];
$className = $_REQUEST['className'];
$startdate = $_REQUEST['editstartdate'];
$enddate = $_REQUEST['editenddate'];
$examid = $_REQUEST['examid'];

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


$examdate_cnt = count($examdate);

$exam_sql = "UPDATE `exam_time_table` set exam_name = '$exam_name', start_date = '$startdate', end_date = '$enddate', updated_by='$username',  updated_at='$date' where id='$examid'";
$exam_exe = mysql_query($exam_sql);

$del_exam_sub_sql = "Delete from exam_date_subject where exam_id='$examid'";
$del_exam_sub_exe = mysql_query($del_exam_sub_sql);

for($j=0; $j<$class_cnt; $j++) {
    for($z = 0; $z < $examdate_cnt; $z++) {
        $subject = $_REQUEST['subject'.$j.$z];
        $session = $_REQUEST['session'.$j.$z];
        $examdat = $examdate[$z];
        $class_id = $className[$j];
        if(!empty($subject)){
            $time_table_sql = "INSERT into exam_date_subject (exam_id, exam_date, class_id, subject_name, exam_session, created_by, updated_by, created_at, updated_at) VALUES
('$examid','$examdat', '$class_id', '$subject', '$session', '$username', '$username', '$date','$date')";
            $time_table_exe = mysql_query($time_table_sql);
        }
    }
}

header("Location: exam-time-table.php?succ=2");

?>