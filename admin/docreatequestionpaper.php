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

$class_id = $_REQUEST['class_id'];
$class_name= $_REQUEST['class_name'];
$term= $_REQUEST['term'];
$subject_name = $_REQUEST['subject_name'];
$daily_test_name = $_REQUEST['daily_test_name'];
$daily_test_remark = $_REQUEST['daily_test_remark'];
$daily_test_mark = $_REQUEST['daily_test_mark'];
$daily_test_chapters = $_REQUEST['daily_test_chapters'];
$questionbank_id = $_REQUEST['questionbank_id'];
$daily_test_status = "1";
$section_id= "";

$daily_test_question_count = $_REQUEST['daily_test_question_count'];
$noofquestion = $_REQUEST['noofquestion'];
$noofquestionfiltered = array_filter($noofquestion);
$markperquestion = $_REQUEST['markperquestion'];
$totalmark = $_REQUEST['totalmark'];

if(isset($_REQUEST['questions']))
{
$questions_array = $_REQUEST['questions'];
$questionbank_id = implode(",", $questions_array);
}

//$daily_test_chapters="";

$query = "INSERT INTO `term_test` (`class_id`, `subject_name`, `term`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_mark`, `daily_test_question_count`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
           VALUES ('$class_id', '$subject_name', '$term', '$section_id', '$daily_test_name', '$daily_test_remark', '$daily_test_chapters', '$daily_test_mark', '$daily_test_question_count', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
$query_exe = mysql_query($query);

$dailyTestId = mysql_insert_id();
echo "<pCOUNT::".$daily_test_question_count."</p>";

for($qc=1;$qc<=$daily_test_question_count;$qc++)
{
$order_id = $qc;

foreach($noofquestionfiltered as $key=>$value)
{
	
  $keyvalue = str_replace("'","",$key);
  $limitvalue = $value;
  $markvalue = $markperquestion[$key];
  
  if($keyvalue=="Choose" || $keyvalue=="Match" ||  $keyvalue=="Meanings" ||  $keyvalue=="Opposites" || $keyvalue=="Fill Up" || $keyvalue=="True or False" || $keyvalue=="One or Two Words" || $keyvalue=="Missing Letters" || $keyvalue=="Jumbled Words" || $keyvalue=="Jumbled Letters")
  {
  $array_ques_sql="SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='$keyvalue' ORDER BY RAND() LIMIT $limitvalue";
  }
  else
  {
  $array_ques_sql="SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other' and other_type='$keyvalue' ORDER BY RAND() LIMIT $limitvalue";
  }
  
  $array_ques_exe= mysql_query($array_ques_sql);
  $array_ques_cnt = mysql_num_rows($array_ques_exe);
  
	if($array_ques_cnt>0) {
		
		while($array_ques_fet = mysql_fetch_assoc($array_ques_exe)){  
		$question_id=$array_ques_fet['id'];
		$query_question = "INSERT INTO `term_test_question` (`daily_test_id`, `question_id`, `question_mark`, `order_id`, `daily_test_question_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
		VALUES ('$dailyTestId', '$question_id', '$markvalue', '$order_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
		
		//echo "<p>".$query_question."</p>";
		
		}
	}
  
  
}

}


/*
exit;


$query = "INSERT INTO `term_test` (`class_id`, `subject_name`, `term`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_mark`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
           VALUES ('$class_id', '$subject_name', '$term', '$section_id', '$daily_test_name', '$daily_test_remark', '$questionbank_id', '$daily_test_mark', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		   
$query_exe = mysql_query($query);

$dailyTestId = mysql_insert_id();


$questions = $_REQUEST['questions'];

$questions_cnt = count($_REQUEST["questions"]);

    for ($i = 0; $i < $questions_cnt; $i++) {
		$question_id = $questions[$i];
		$order_id = $i+1;
		$query_question = "INSERT INTO `term_test_question` (`daily_test_id`, `question_id`, `order_id`, `daily_test_question_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES ('$dailyTestId', '$question_id', '$order_id', '1', '$user_name', '$user_name', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";
		$query_question_exe = mysql_query($query_question);
	}

*/

	
	
header("Location: question-paper.php?succ=1");


//header("Location: write-self-test.php?test_id=$dailyTestId");


?>