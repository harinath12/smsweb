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

$username = $_SESSION['adminusername'];
$target = null;
$remark_details = null;

$remarksId = $_REQUEST['remarksId'];
$title = $_REQUEST['title'];
$remarksType = $_REQUEST['editremarksType'];
if($remarksType == 'Text'){
    $remark_details = $_REQUEST['remark_details'];
}
else if($remarksType == 'Audio'){
    if(isset($_FILES['remarkFile'])){
        $info = pathinfo($_FILES['remarkFile']['name']);
        $base = basename($_FILES['remarkFile']['name']);
        if(!empty($base)) {
            $ext = $info['extension'];
            $newname = "remarks-" . $title. $normaldate . "." . $ext;
            $target = 'upload/remarks/' . $newname;
            $moveFile = move_uploaded_file($_FILES['remarkFile']['tmp_name'], $target);

            $remark_attach_sql = "UPDATE teacher_remarks set remark_filepath='$target', modified_by='$username', updated_at='$date' where id='$remarksId'";
            $remark_attach_exe = mysql_query($remark_attach_sql);
        }
    }
}

$home_work_sql = "UPDATE teacher_remarks set title='$title', remarks_type='$remarksType', remark_details='$remark_details', modified_by='$username', updated_at='$date' where id='$homeworkId'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: home-work.php?succ=2");

?>