<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$className = $_REQUEST['clsName'];
$sectionName = $_REQUEST['sectionName'];
$cnt = count($sectionName);
$subjectName = $_REQUEST['subjectName'];
$period = $_REQUEST['period'];
$title = $_REQUEST['title'];
$description = $_REQUEST['description'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$target = null;

if(isset($_FILES['notesFile'])){
    $info = pathinfo($_FILES['notesFile']['name']);
    $base = basename($_FILES['notesFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "classnotes-" . $className.$sectionName.$subjectName. $normaldate . "." . $ext;
        $target = 'upload/classnotes/' . $newname;
        $movetarget = '../teacher/upload/classnotes/' . $newname;
        $moveFile = move_uploaded_file($_FILES['notesFile']['tmp_name'], $movetarget);
    }
}

for($i =0 ; $i<$cnt; $i++) {
    $secName = $sectionName[$i];
    $user_sql = "INSERT INTO `class_notes` (teacher_id, class, section, subject, period, date, description, class_notes_file_path, class_notes_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id', '$className', '$secName', '$subjectName', '$period', '$date','$description', '$target', '1','$username', '$username', '$date','$date')";
    $user_exe = mysql_query($user_sql);
}

header("Location: class-notes.php?succ=1");

?>