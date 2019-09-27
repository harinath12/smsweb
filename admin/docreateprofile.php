<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$schoolName = $_REQUEST['schoolName'];
$personName = $_REQUEST['personName'];
$address = $_REQUEST['address'];
$cityId = $_REQUEST['cityId'];
$state = $_REQUEST['state'];
$countryId = $_REQUEST['countryId'];
$pincode = $_REQUEST['pincode'];
$telephone = $_REQUEST['telephone'];
$mobile = $_REQUEST['mobile'];
$email = $_REQUEST['email'];
$website = $_REQUEST['website'];
$schoolcode = $_REQUEST['schoolcode'];
$pwd = md5($_REQUEST['password']);
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

if(isset($_FILES['staffPhoto'])){
    $info = pathinfo($_FILES['staffPhoto']['name']);
    $base = basename($_FILES['staffPhoto']['name']);
    //echo $_FILES['staffPhoto']['tmp_name']; exit;
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "schoolphoto-" . time() . "." . $ext;
        $target = 'image/' . $newname;
        $moveFile = move_uploaded_file($_FILES['staffPhoto']['tmp_name'], $target);
    }
}

//$pwdtime = time();
//$pwd = md5($pwdtime);

$sql = "INSERT INTO `users` (name, email, password, confirmed, delete_status, created_at, updated_at) VALUES ('$schoolName','$email','$pwd','1','1','$date','$date')";
$exe = mysql_query($sql);
$last_id = mysql_insert_id();

$role_sql = "INSERT INTO `role_user` (user_id, role_id) values ('$last_id', 3)";
$role_exe = mysql_query($role_sql);

$school_sq1 = "INSERT INTO `school_info` (user_id, name_school, name_person, address, city, state, country, pincode, telephone, mobile, school_photo, email, website, school_code, created_by, updated_by, created_at, updated_at)
VALUES ('$last_id','$schoolName','$personName','$address','$cityId','$state','$countryId','$pincode','$telephone','$mobile','$target', '$email','$website','$schoolcode','$username','$username','$date','$date')";
$school_exe = mysql_query($school_sq1);

header("Location: profile-list.php?suc=1");

?>