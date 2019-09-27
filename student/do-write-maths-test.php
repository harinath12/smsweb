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

$questions = $_REQUEST['questions'];
$answers = $_REQUEST['answers'];
$question_answer = $_REQUEST['question_answer'];
$questions_cnt = count($_REQUEST["questions"]);

    for ($i = 0; $i < $questions_cnt; $i++) {
		$question_id = $questions[$i];
		$order_id = $i+1;
		$student_answer_value = strtolower(trim($answers[$question_id]));
		$question_answer_value= strtolower(trim($question_answer[$question_id]));
		
		if(!empty($student_answer_value))
		{
			$maths_test_student_answer=$student_answer_value;
			
			if($question_answer_value==$student_answer_value)
			{
			$maths_test_mark=1;
			}
			else
			{
			$maths_test_mark=0;
			}
		}
		else
		{
			$maths_test_student_answer="N-A";
			$maths_test_mark=0;
		}
			
		$query_question = "UPDATE `maths_test_answer` SET `maths_test_student_answer` = '$maths_test_student_answer', `maths_test_mark` = '$maths_test_mark' WHERE `id` = '$question_id'";
		$query_question_exe = mysql_query($query_question);
	}


header("Location: maths-test.php?succ=1");
	
?>