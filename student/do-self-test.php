<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

//print_r($_SESSION);

/*
Array ( [class_name] => X [subject_name] => Social Science [daily_test_name] => X-Social Science-2018-12-20 [daily_test_remark] => TESTING 
[questions] => Array ( [0] => [1] => [2] => [3] => [4] => [5] => [6] => [7] => [8] => [9] => [10] => [11] => [12] => [13] => [14] => [15] => [16] => [17] => 166 [18] => 167 [19] => 168 [20] => 169 [21] => 170 [22] => 171 [23] => 172 [24] => 173 [25] => 174 [26] => 175 [27] => 176 [28] => 177 [29] => 178 [30] => 179 [31] => 180 [32] => 181 [33] => 182 [34] => 183 [35] => 184 [36] => 185 [37] => 186 [38] => 187 [39] => 188 [40] => 189 [41] => 190 [42] => 191 [43] => 192 ) 
[questionbank_id] => 57,53 [submit] => )

*/

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_name=$_SESSION['adminusername'];
$date = date("Y-m-d");

$class_id = $_REQUEST['class_id'];
$section_id = $_REQUEST['section_id'];
$subject_name = $_REQUEST['subject_name'];
$daily_test_name = $_REQUEST['daily_test_name'];
$daily_test_remark = $_REQUEST['daily_test_remark'];
$questionbank_id = $_REQUEST['questionbank_id'];
$daily_test_status = "1";

$query = "INSERT INTO `self_test` (`student_id`, `class_id`, `subject_name`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
           VALUES ('$user_id','$class_id', '$subject_name', '$section_id', '$daily_test_name', '$daily_test_remark', '$questionbank_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		   
$query_exe = mysql_query($query);

$dailyTestId = mysql_insert_id();

$questions = $_REQUEST['questions'];

$questions_cnt = count($_REQUEST["questions"]);

    for ($i = 0; $i < $questions_cnt; $i++) {
		$question_id = $questions[$i];
		$order_id = $i+1;
		$query_question = "INSERT INTO `self_test_question` (`daily_test_id`, `question_id`, `order_id`, `daily_test_question_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES ('$dailyTestId', '$question_id', '$order_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
	}
	
/*	
header("Location: self-test.php?succ=1");
*/

header("Location: write-self-test.php?test_id=$dailyTestId");


?>