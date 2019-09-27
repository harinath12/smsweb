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

$className = $_REQUEST['classId'];
$sectionName = $_REQUEST['sectionId'];
$leave_status = $_REQUEST['leave_status'];

$cnt = count($_POST["userId"]);
for ($i = 0; $i < $cnt; $i++) {
    $forenoon = 'off';
    $afternoon = 'off';
    $remarks = null;
    $studId = null;

    $fn_entry_status = 0;
    $an_entry_status = 0;

    $studId = $_REQUEST['userId'][$i];
    if(isset($_POST["forenoon"][$i])){
        $fn_entry_status = '1';
        $forenoon = $_POST["forenoon"][$i];
    }
    if(isset($_POST["afternoon"][$i])){
        $an_entry_status = '1';
        $afternoon = $_POST["afternoon"][$i];
    }
    if(isset($_POST["remarks"][$i])){
        $remarks = $_POST["remarks"][$i];
    }

    $stud_sql = "select * from attendance where user_id = '$studId' and attendance_date='$date'";
    $stud_exe = mysql_query($stud_sql);
    $stud_cnt = @mysql_num_rows($stud_exe);

    if($stud_cnt == 0){
        $attendance_sql = "INSERT INTO `attendance` (user_id, class_id, section_name, forenoon, afternoon, attendance_date, fn_entry_status, an_entry_status, remarks, leave_status, created_by, created_at) VALUES
('$studId','$className', '$sectionName', '$forenoon', '$afternoon', '$date', '$fn_entry_status', '$an_entry_status','$remarks', '$leave_status', '$username', '$date')";
        $attendance_exe = mysql_query($attendance_sql);
    }
    else{
        $update_remarks_sql = "update attendance set forenoon = '$forenoon', afternoon='$afternoon', remarks = '$remarks', updated_by='$username', updated_at = '$date' where user_id='$studId';";
        $update_attendance_exe = mysql_query($update_remarks_sql);
    }

    if($forenoon='off' || $afternoon='off'){
        if(!empty($remarks)){
            $leave_sql = "select * from student_leave where student_id = '$studId' and leave_from_date='$date'";
            $leave_exe = mysql_query($leave_sql);
            $leave_cnt = @mysql_num_rows($leave_exe);

            if($leave_cnt>0){
                $update_leave_sql = "update student_leave set title = '$remarks', updated_by='$username', updated_at = '$date' where student_id='$studId';";
                $update_leave_exe = mysql_query($update_leave_sql);
            }
            else{
                $insert_leave_sql = "insert into student_leave (student_id,title, leave_from_date, created_by, created_at) values ('$studId','$remarks','$date','$username','$date');";
                $insert_leave_exe = mysql_query($insert_leave_sql);
            }
        }
    }


}

header("Location: attendance.php?succ=1");

?>