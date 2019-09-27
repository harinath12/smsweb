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
$cir_count = count($circularTo);
$cir = null;
for($i =0; $i < $cir_count; $i++){
    if($i == 0){
        $cir = $circularTo[$i];
    }
    else{
        $cir = $cir . "," . $circularTo[$i];
    }
}
$message = $_REQUEST['message'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
$target = null;

if(isset($_FILES['circularFile'])){
    $info = pathinfo($_FILES['circularFile']['name']);
    $base = basename($_FILES['circularFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "circular-" . time() . "." . $ext;
        $target = 'upload/circular/' . $newname;
        $moveFile = move_uploaded_file($_FILES['circularFile']['tmp_name'], $target);
    }
}

$user_sql = "INSERT INTO `circular` (circular_title, circular_to, circular_message, circular_file_path, circular_date, circular_status, created_by, created_at) VALUES
('$circularTitle','$cir','$message','$target', '$date','1','$username','$date')";
$user_exe = mysql_query($user_sql);

header("Location: circular-list.php?succ=1");

?>