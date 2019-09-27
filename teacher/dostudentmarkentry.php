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
//$classId = $_REQUEST['classId'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$studentid = $_REQUEST['studentid'];
$marks = $_REQUEST['marks'];
$remarks = $_REQUEST['remarks'];
$stud_cnt = count($studentid);

for($i =0 ;$i < $stud_cnt; $i++){
    if(!empty($marks[$i])){
        $sm_sql = mysql_query("select * from student_mark where student_id=$studentid[$i] and exam_id=$examid and subject_name='$subjectName'");
        $sm_fet = mysql_fetch_assoc($sm_sql);
        $sm_cnt = mysql_num_rows($sm_sql);
        if($sm_cnt> 0){
            $id= $sm_fet['id'];
            $mrk_sql = "update student_mark set mark='$marks[$i]', remarks='$remarks[$i]' where id=$id";
            $mrk_exe = mysql_query($mrk_sql);
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