<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$staffId = $_REQUEST['staffId'];
$target = null;
$user_id=$_SESSION['adminuserid'];
$firstName = $_REQUEST['firstName'];
$lastName = $_REQUEST['lastName'];
$staffName = $firstName . " " . $lastName;
$jobType = $_REQUEST['jobType'];
$jobPosition = $_REQUEST['jobPosition'];
$dob = $_REQUEST['dob'];
$gender = $_REQUEST['gender'];

if(isset($_FILES['staffPhoto'])){
    $info = pathinfo($_FILES['staffPhoto']['name']);
    $base = basename($_FILES['staffPhoto']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "staffphoto-" . time() . "." . $ext;
        $target = 'image/' . $newname;
        $moveFile = move_uploaded_file($_FILES['staffPhoto']['tmp_name'], $target);

        $photo_sq1 = "UPDATE `staff_info` set photo = '$target', updated_by = '$username', updated_at='$date'
where user_id = '$staffId'";
        $photo_exe = mysql_query($photo_sq1);
    }
}

$address = $_REQUEST['address'];
$cityId = $_REQUEST['cityId'];
$mobile = $_REQUEST['mobile'];
$email = $_REQUEST['email'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$insert_user_sq1 = "UPDATE `users` set name = '$staffName', updated_at='$date' where id = '$staffId'";
$insert_user_exe = mysql_query($insert_user_sq1);

$insert_staff_sq1 = "UPDATE `staff_info` set firstname_person = '$firstName', lastname_person = '$lastName',job_type = '$jobType',
job_position = '$jobType',dob = '$dob', gender = '$gender', address='$address', city = '$cityId', mobile = '$mobile', updated_by = '$username', updated_at='$date'
where user_id = '$staffId'";
$insert_staff_exe = mysql_query($insert_staff_sq1);

header("Location: staff.php?succ=1");

?>