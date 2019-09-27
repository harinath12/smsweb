<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['test_id']))
{
$test_id = $_REQUEST['test_id'];
}
else
{
	header("Location: daily-test.php?error=1");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");


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


$select_test_question_sql="SELECT * FROM `daily_test_question` WHERE daily_test_id='$test_id'";
$select_test_question_exe=mysql_query($select_test_question_sql);
while($select_test_question_fet=mysql_fetch_array($select_test_question_exe))
{

		$question_id = $select_test_question_fet['question_id'];
		$query_question = "INSERT INTO `daily_test_question` (`daily_test_id`, `question_id`, `daily_test_question_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES ('$dailyTestId', '$question_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
}

$testNames = $dailyTestId;

$select_sql="select q.*, c.class_name,cs.section_name from daily_test as q
left join classes as c on c.id = q.class_id
left join class_section as cs on cs.id = q.section_id
where daily_test_status='1' and q.id='$test_id' order by id desc";
$select_exe=mysql_query($select_sql);
$select_fet=mysql_fetch_array($select_exe);



$className = $select_fet['class_name'];
$sectionName = $select_fet['section_name'];
$subjectName = $select_fet['subject_name'];
$period = "I";
$description = $select_fet['daily_test_name'];
//$testNames = $select_fet['id'];

$username = $_SESSION['adminusername']; 
$date = date("Y-m-d");

$target = null;




$user_sql = "INSERT INTO `home_work` (teacher_id, class, section, subject, period, date, description, home_work_file_path, home_work_test_names, home_work_status, admin_status, created_by, modified_by, created_at, updated_at) VALUES
('$user_id','$className', '$sectionName', '$subjectName', '$period', '$date', '$description', '$target', '$testNames', '1', '1', '$username', '$username', '$date','$date')";
//echo $user_sql; exit;
$user_exe = mysql_query($user_sql);

header("Location: daily-test.php?succ=3");

?>