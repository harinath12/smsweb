<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$classNotesId = $_REQUEST['classnotesId'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];
$period = $_REQUEST['period'];
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
        $moveFile = move_uploaded_file($_FILES['notesFile']['tmp_name'], $target);

        $hw_attachment_sql = "UPDATE class_notes set class_notes_file_path='$target', modified_by='$username', updated_at='$date' where id='$classNotesId'";
        $hw_attachment_exe = mysql_query($hw_attachment_sql);
    }
}

$home_work_sql = "UPDATE class_notes set subject='$subjectName', period='$period', description='$description', modified_by='$username', updated_at='$date' where id='$classNotesId'";
$home_work_exe = mysql_query($home_work_sql);

header("Location: class-notes.php?succ=2");

?>