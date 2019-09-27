<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_name=$_SESSION['adminusername'];
$date = date("Y-m-d");

$daily_test_id = $_REQUEST['test_id'];
$daily_test_name = $_REQUEST['test_name'];
$daily_test_mark = "";
$daily_test_status = "1";
$question_answer_value = "";

$query = "INSERT INTO `daily_test_answer` 
		(`student_id`, `daily_test_id`, `daily_test_name`, `daily_test_mark`, `daily_test_status`, `created_at`, `updated_at`) 
		VALUES 
		('$user_id', '$daily_test_id', '$daily_test_name', '$daily_test_mark', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		   
$query_exe = mysql_query($query);

$dailyTestAnswerId = mysql_insert_id();

$questions = $_REQUEST['questions'];
$answers = $_REQUEST['answers'];
$question_answer = $_REQUEST['question_answer'];
$questions_cnt = count($_REQUEST["questions"]);

    for ($i = 0; $i < $questions_cnt; $i++) {
		$question_id = $questions[$i];
		$order_id = $i+1;
		$answer = strtolower(trim($answers[$question_id]));
		$question_answer_value=@$question_answer[$question_id];
		
		$query_ans = "SELECT * FROM `question_answer` WHERE `id`='$question_id'";
		$query_ans_exe = mysql_query($query_ans);
		$query_ans_fet = mysql_fetch_assoc($query_ans_exe);
		
		if(!empty($answer))
		{
			$q_answer=strtolower(trim($query_ans_fet['answer']));
			
			if($q_answer==$answer)
			{
			$daily_test_mark=1;
			}
			else
			{
			$daily_test_mark=0;
			}
		}
		else
		{
			$answer="N-A";
			$daily_test_mark=0;
		}
			
		$query_question = "INSERT INTO `daily_test_question_answer` (`daily_test_id`, `daily_test_answer_id`, `question_id`, `order_id`, `question_answer`, `answer`, `daily_test_mark`, `daily_test_question_answer_status`, `created_at`, `updated_at`) 
				VALUES ('$daily_test_id', '$dailyTestAnswerId', '$question_id', '$order_id', '$question_answer_value', '$answer', '$daily_test_mark', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
	}


header("Location: daily-test.php?succ=1");
	
?>