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
$target = null;
$ext = null;
$remark_details = null;

$student = $_REQUEST['studentId'];
$cnt = count($student);

$title = $_REQUEST['title'];
$remarksType = $_REQUEST['remarksType'];
if($remarksType == 'Text'){
    $remark_details = $_REQUEST['remark_details'];
}
else if($remarksType == 'Audio'){
    if(isset($_FILES['remarkFile'])){
        $info = pathinfo($_FILES['remarkFile']['name']);
        $base = basename($_FILES['remarkFile']['name']);
        if(!empty($base)) {
            $ext = $info['extension'];
            $newname = "remarks-" . time() . "." . $ext;
            $target = 'upload/remarks/' . $newname;
            $moveFile = move_uploaded_file($_FILES['remarkFile']['tmp_name'], $target);
        }
    }
}

for($i = 0; $i < $cnt; $i++){
    $remark_sql = "Insert into teacher_remarks (teacher_id, student_id, title, remarks_type, remark_details, remark_filepath, file_extension, remarks_date, remarks_status, created_by, updated_by, created_at, updated_at )
values('$user_id','$student[$i]', '$title', '$remarksType', '$remark_details', '$target', '$ext', '$date', '1', '$username','$username','$date','$date') ";
    $remark_exe = mysql_query($remark_sql);
}

header("Location: teacher-remarks.php?succ=1");

?>