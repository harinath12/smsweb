<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$circularTitle = $_REQUEST['circularTitle'];
$circularTo = $_REQUEST['circularTo'];
$message = $_REQUEST['message'];
$circularId = $_REQUEST['circularId'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

if(isset($_FILES['circularFile'])){
    if(file_exists($_FILES['circularFile'])){
        $info = pathinfo($_FILES['circularFile']['name']);
        $base = basename($_FILES['circularFile']['name']);
        if(!empty($base)) {
            $ext = $info['extension'];
            $newname = "circular-" . time() . "." . $ext;
            $target = 'upload/circular/' . $newname;
            $moveFile = move_uploaded_file($_FILES['circularFile']['tmp_name'], $target);
        }

        $circular_file_sql = "UPDATE `circular` set circular_file_path = '$target', updated_by = '$username', updated_at= '$date' where id='$circularId'";
        $circular_file_exe = mysql_query($circular_file_sql);
    }
}

$circular_sql = "UPDATE `circular` set circular_title = '$circularTitle', circular_to = '$circularTo', circular_message = '$message', updated_by = '$username', updated_at= '$date' where id='$circularId'";
$circular_exe = mysql_query($circular_sql);

header("Location: circular-view.php?succ=1&circular_id=" . $circularId);

?>