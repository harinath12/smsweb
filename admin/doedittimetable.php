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
$normaldate = date("d-m-Y");

$examid = $_REQUEST['examid'];

$day_1_1 = $_REQUEST['day_1_1'];
$day_1_2 = $_REQUEST['day_1_2'];
$day_1_3 = $_REQUEST['day_1_3'];
$day_1_4 = $_REQUEST['day_1_4'];
$day_1_5 = $_REQUEST['day_1_5'];
$day_1_6 = $_REQUEST['day_1_6'];
$day_1_7 = $_REQUEST['day_1_7'];
$day_1_8 = $_REQUEST['day_1_8'];

$day_2_1 = $_REQUEST['day_2_1'];
$day_2_2 = $_REQUEST['day_2_2'];
$day_2_3 = $_REQUEST['day_2_3'];
$day_2_4 = $_REQUEST['day_2_4'];
$day_2_5 = $_REQUEST['day_2_5'];
$day_2_6 = $_REQUEST['day_2_6'];
$day_2_7 = $_REQUEST['day_2_7'];
$day_2_8 = $_REQUEST['day_2_8'];

$day_3_1 = $_REQUEST['day_3_1'];
$day_3_2 = $_REQUEST['day_3_2'];
$day_3_3 = $_REQUEST['day_3_3'];
$day_3_4 = $_REQUEST['day_3_4'];
$day_3_5 = $_REQUEST['day_3_5'];
$day_3_6 = $_REQUEST['day_3_6'];
$day_3_7 = $_REQUEST['day_3_7'];
$day_3_8 = $_REQUEST['day_3_8'];

$day_4_1 = $_REQUEST['day_4_1'];
$day_4_2 = $_REQUEST['day_4_2'];
$day_4_3 = $_REQUEST['day_4_3'];
$day_4_4 = $_REQUEST['day_4_4'];
$day_4_5 = $_REQUEST['day_4_5'];
$day_4_6 = $_REQUEST['day_4_6'];
$day_4_7 = $_REQUEST['day_4_7'];
$day_4_8 = $_REQUEST['day_4_8'];

$day_5_1 = $_REQUEST['day_5_1'];
$day_5_2 = $_REQUEST['day_5_2'];
$day_5_3 = $_REQUEST['day_5_3'];
$day_5_4 = $_REQUEST['day_5_4'];
$day_5_5 = $_REQUEST['day_5_5'];
$day_5_6 = $_REQUEST['day_5_6'];
$day_5_7 = $_REQUEST['day_5_7'];
$day_5_8 = $_REQUEST['day_5_8'];

$time_table_status = 1;
$admin_status = 1;
$created_by = $username;
$updated_by = $username;
$created_at = $date;
$updated_at = $date;

$exam_sql = "
UPDATE `time_table` SET 
`day_1_1`='$day_1_1', `day_1_2`='$day_1_2', `day_1_3`='$day_1_3', `day_1_4`='$day_1_4', `day_1_5`='$day_1_5', `day_1_6`='$day_1_6', `day_1_7`='$day_1_7', `day_1_8`='$day_1_8', 
`day_2_1`='$day_2_1', `day_2_2`='$day_2_2', `day_2_3`='$day_2_3', `day_2_4`='$day_2_4', `day_2_5`='$day_2_5', `day_2_6`='$day_2_6', `day_2_7`='$day_2_7', `day_2_8`='$day_2_8', 
`day_3_1`='$day_3_1', `day_3_2`='$day_3_2', `day_3_3`='$day_3_3', `day_3_4`='$day_3_4', `day_3_5`='$day_3_5', `day_3_6`='$day_3_6', `day_3_7`='$day_3_7', `day_3_8`='$day_3_8', 
`day_4_1`='$day_4_1', `day_4_2`='$day_4_2', `day_4_3`='$day_4_3', `day_4_4`='$day_4_4', `day_4_5`='$day_4_5', `day_4_6`='$day_4_6', `day_4_7`='$day_4_7', `day_4_8`='$day_4_8', 
`day_5_1`='$day_5_1', `day_5_2`='$day_5_2', `day_5_3`='$day_5_3', `day_5_4`='$day_5_4', `day_5_5`='$day_5_5', `day_5_6`='$day_5_6', `day_5_7`='$day_5_7', `day_5_8`='$day_5_8'
WHERE `id`='$examid'";

$exam_exe = mysql_query($exam_sql);
$last_id = mysql_insert_id();



header("Location: time-table.php?succ=1");

?>