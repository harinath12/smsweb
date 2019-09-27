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

$examid = $_REQUEST['examName'];
$classId = $_REQUEST['classId'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];

$student_mark_id = $_REQUEST['markId'];
$studentid = $_REQUEST['studentid'];
$marks = $_REQUEST['marks'];
$remarks = $_REQUEST['remarks'];
$stud_cnt = count($student_mark_id);

for($i =0 ;$i < $stud_cnt; $i++){
    if(!empty($marks[$i])){
        if(!empty($student_mark_id[$i])) {
            $mark_sql = "UPDATE `student_mark` set mark='$marks[$i]', remarks = '$remarks[$i]', updated_by='$username', updated_at='$date' where id='$student_mark_id[$i]'";
            $mark_exe = mysql_query($mark_sql);
        }
        else{
            $mark_sql = "INSERT INTO `student_mark` (teacher_id, student_id, exam_id, subject_name, classid, section_name, mark, remarks, mark_entry_date, mark_status, created_by, created_at) VALUES
('$user_id', '$studentid[$i]','$examid', '$subjectName', '$classId', '$sectionName',  '$marks[$i]', '$remarks[$i]', '$normaldate', '1','$username', '$date')";
            $mark_exe = mysql_query($mark_sql);
        }
    }
}

header("Location: marks-list.php?succ=1");

?>