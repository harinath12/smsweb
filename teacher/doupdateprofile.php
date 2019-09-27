<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$target = null;
$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];

$schoolName = $_REQUEST['userName'];
$date = date("Y-m-d");

if(isset($_FILES['profilePhoto'])) {
    $info = pathinfo($_FILES['profilePhoto']['name']);
    $base = basename($_FILES['profilePhoto']['name']);
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    if (!empty($base)) {
        $ext = $info['extension'];
        if ((($_FILES["profilePhoto"]["type"] == "image/gif") || ($_FILES["profilePhoto"]["type"] == "image/jpeg") || ($_FILES["profilePhoto"]["type"] == "image/jpg") || ($_FILES["profilePhoto"]["type"] == "image/png")) && in_array($ext, $allowedExts))
        {
            $newname = "schoolphoto-" . time() . "." . $ext;
            $target = 'image/' . $newname;
            $moveFile = move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $target);

            $photo_sq1 = "UPDATE `school_info` set school_photo = '$target', updated_by = '$username', updated_at='$date'
where user_id = '$user_id'";
            $photo_exe = mysql_query($photo_sq1);

            $insert_staff_sq1 = "UPDATE `school_info` set name_school = '$schoolName', updated_by = '$username', updated_at='$date'
where user_id = '$user_id'";
            $insert_staff_exe = mysql_query($insert_staff_sq1);

            $insert_user_sq1 = "UPDATE `users` set name = '$schoolName', updated_at='$date'
where id = '$user_id'";
            $insert_user_exe = mysql_query($insert_user_sq1);

            header("Location: user-profile.php?succ=1");
        }
        else{
            header("Location: edit-profile.php?err=1");
        }
    }
}

?>