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

$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjectName = $_REQUEST['subjectName'];
$period = $_REQUEST['period'];
//$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
$testName = $_REQUEST['testName'];
$testNames =implode(",",$testName);

$username = $_SESSION['adminusername']; 
$date = date("Y-m-d");

$target = null;

if(isset($_FILES['homeWorkFile'])){
    $info = pathinfo($_FILES['homeWorkFile']['name']);
    $base = basename($_FILES['homeWorkFile']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "homework-" . $className.$sectionName.$subjectName. $normaldate . "." . $ext;
        $target = 'upload/homework/' . $newname;
        $moveFile = move_uploaded_file($_FILES['homeWorkFile']['tmp_name'], $target);
    }
}

$testName_Count = count($testName);
/*
echo "COUNT::".$testName_Count; exit;
*/

if($testName_Count>0)
{
$testNameNew = array();	
foreach($testName as $testNameValue)
{
	$test_id=$testNameValue;
	echo "<p>".$test_id."</p>";
	
$select_test_sql="SELECT * FROM `daily_test` WHERE id='$test_id'";
$select_test_exe=mysql_query($select_test_sql);
$select_test_fet=mysql_fetch_array($select_test_exe);

$class_id=$select_test_fet['class_id'];
$subject_name=$select_test_fet['subject_name'];
$section_id=$select_test_fet['section_id'];
$daily_test_name=$select_test_fet['daily_test_name'];
$daily_test_remark=$select_test_fet['daily_test_remark'];
$daily_test_chapters=$select_test_fet['daily_test_chapters'];
$user_name=$select_test_fet['created_by'];
$date = date("Y-m-d");

$daily_test_name_exp=explode("-",$select_test_fet['daily_test_name']);
$daily_test_name=$daily_test_name_exp[0]."-".$subject_name."-".$date;

$insert_test_query = "INSERT INTO `daily_test` (`class_id`, `subject_name`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
           VALUES ('$class_id', '$subject_name', '$section_id', '$daily_test_name', '$daily_test_remark', '$daily_test_chapters', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		   
$insert_test_query_exe = mysql_query($insert_test_query);

$dailyTestId = mysql_insert_id();

$testNameNew[] = $dailyTestId;

$select_test_question_sql="SELECT * FROM `daily_test_question` WHERE daily_test_id='$test_id'";
$select_test_question_exe=mysql_query($select_test_question_sql);
while($select_test_question_fet=mysql_fetch_array($select_test_question_exe))
{

		$question_id = $select_test_question_fet['question_id'];
		$query_question = "INSERT INTO `daily_test_question` (`daily_test_id`, `question_id`, `daily_test_question_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES ('$dailyTestId', '$question_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
}

}

$testNames =implode(",",$testNameNew);
}


$user_sql = "INSERT INTO `home_work` (teacher_id, class, section, subject, period, date, description, home_work_file_path, home_work_test_names, home_work_status, admin_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id','$className', '$sectionName', '$subjectName', '$period', '$date', '$description', '$target', '$testNames', '1', '1', '$username', '$username', '$date','$date')";
//echo $user_sql; exit;
$user_exe = mysql_query($user_sql);

header("Location: home-work.php?succ=1");

?>