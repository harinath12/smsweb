<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$duration = $_REQUEST['duration'];
$fromdate = $_REQUEST['fromdate'];
$todate = $_REQUEST['todate'];
$title = $_REQUEST['title'];
$leaveType = $_REQUEST['leaveType'];
$description = $_REQUEST['description'];
$username = $_SESSION['adminusername']; 
$date = date("Y-m-d");

$target = null;

if(isset($_FILES['LeaveApplyFile'])){
    $info = pathinfo($_FILES['LeaveApplyFile']['name']);
    $base = basename($_FILES['LeaveApplyFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "leaveppply-" . $user_id.$normaldate.$fromdate.$todate. "." . $ext;
        $target = 'upload/leaveppply/' . $newname;
        $moveFile = move_uploaded_file($_FILES['LeaveApplyFile']['tmp_name'], $target);
    }
}

if(isset($_FILES['descriptionfile'])){
    $info = pathinfo($_FILES['descriptionfile']['name']);
    $base = basename($_FILES['descriptionfile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "leavedescription-" . $user_id.$normaldate.$fromdate.$todate. "." . $ext;
        $description = 'upload/leaveppply/' . $newname;
        $moveFile = move_uploaded_file($_FILES['descriptionfile']['tmp_name'], $description);
    }
}


if($duration == 'More Than One Day'){
    $user_sql = "INSERT INTO `student_leave` (student_id, title, leave_type, leave_details, leave_filepath, leave_from_date, leave_to_date, leave_status, admin_status, created_by, updated_by, created_at, updated_at) VALUES
('$user_id', '$title', '$leaveType', '$description', '$target', '$fromdate', '$todate', '0', '0', '$username', '$username', '$date','$date')";
}
else{
    $user_sql = "INSERT INTO `student_leave` (student_id, title, leave_type, leave_details, leave_filepath, leave_from_date, leave_to_date, leave_status, admin_status, created_by, updated_by, created_at, updated_at) VALUES
('$user_id', '$title', '$leaveType', '$description', '$target', '$fromdate', '$fromdate', '0', '0', '$username', '$username', '$date','$date')";
}

$user_exe = mysql_query($user_sql);

header("Location: student-leave.php?succ=1");

?>