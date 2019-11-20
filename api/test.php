<?php
function get_daily_test_questions(){
	$student_id = $_REQUEST['user_id'];
	$test_id = $_REQUEST['test_id'];

	if($student_id && $test_id){
		$data = array('questions' => array());
		$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from daily_test as qb
		left join classes as c on c.id = qb.class_id
		where qb.id=$test_id");

		$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

		$data['info'] = $ques_bank_fet;

		$mark_query="SELECT COUNT(id) AS mark FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";
		$mark_query_exe=mysql_query($mark_query);
		$mark_query_fet=mysql_fetch_assoc($mark_query_exe);

		$data['info']['mark'] = $mark_query_fet['mark'];

		$ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN (SELECT question_id FROM `daily_test_question` WHERE `daily_test_id`='$test_id')");
        $ques_cnt = mysql_num_rows($ques_sql);
        if($ques_cnt> 0)
		{
			while($choose_fet = mysql_fetch_assoc($ques_sql)){
				$tmp = $choose_fet;
				if($choose_fet['question_type'] == 'Other'){
					$choose_fet['question_type'] = $choose_fet['other_type'];
				}

				if(!isset($data['questions'][$choose_fet['question_type']])){
					$data['questions'][$choose_fet['question_type']] = array();
				}

				if($choose_fet['question_type'] == 'Fill Up' || $choose_fet['question_type'] == 'Other' || $choose_fet['question_type'] == 'One or Two Words' || $choose_fet['question_type'] == 'True or False'){
					$choose_fet['ttype'] = 1;
				} else if($choose_fet['question_type'] == 'Opposites'){
					$choose_fet['ttype'] = 2;
				} elseif($choose_fet['question_type'] == 'Meanings' || $choose_fet['question_type'] == 'Match' || $choose_fet['question_type'] == 'Rhyming words'){
					$choose_fet['ttype'] = 3;
				} elseif ($choose_fet['question_type'] == 'Missing Letters' || $choose_fet['question_type'] == 'Jumbled Letters' || $choose_fet['question_type'] == 'Jumbled Words') {
					$choose_fet['ttype'] = 4;
				}
				elseif ($choose_fet['question_type'] == 'Choose' ) {
					$choose_fet['ttype'] = 5;
				}

				$data['questions'][$choose_fet['question_type']][] = $choose_fet;
			}
		}
		return array('status' => 'Success', 'data' => $data);
	} else {
		return array('status' => 'Error', 'msg' => 'Invalid Input');
	}
}

function get_daily_test_review(){
	$student_id = $_REQUEST['user_id'];
	$test_id = $_REQUEST['test_id'];
	$answer_id = $_REQUEST['answer_id'];

	if($student_id && $test_id && $answer_id){
		$data = array('questions' => array());
		$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from daily_test as qb
		left join classes as c on c.id = qb.class_id
		where qb.id=$test_id");

		$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

		$data['info'] = $ques_bank_fet;

		$mark_query="SELECT COUNT(id) AS mark FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";
		$mark_query_exe=mysql_query($mark_query);
		$mark_query_fet=mysql_fetch_assoc($mark_query_exe);

		$data['info']['mark'] = $mark_query_fet['mark'];

		$ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN (SELECT question_id FROM `daily_test_question` WHERE `daily_test_id`='$test_id')");
        $ques_cnt = mysql_num_rows($ques_sql);
        if($ques_cnt> 0)
		{
			while($choose_fet = mysql_fetch_assoc($ques_sql)){
				$qid=$choose_fet['id'];
				if(!isset($data['questions'][$choose_fet['question_type']])){
					$data['questions'][$choose_fet['question_type']] = array();
				}

				$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' and `daily_test_answer_id`= '$answer_id'";
				$choose_fet['results'] = array();
				$ans_query_exe=mysql_query($ans_query);
				$choose_fet['urans'] = mysql_fetch_assoc($ans_query_exe);
				if($choose_fet['urans']['created_at']){
					$data['info']['updated_at'] = $choose_fet['urans']['created_at'];
				}

				$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
				$mark_query_exe=mysql_query($mark_query);
				$mark_query_fet=mysql_fetch_assoc($mark_query_exe);
				$std_ques_fet['mark'] = $mark_query_fet['mark'];

				$data['info']['mark_scored'] = $std_ques_fet['mark'];
				
				$data['questions'][$choose_fet['question_type']][] = $choose_fet;

			}
		}
		return array('status' => 'Success', 'data' => $data);
	} else {
		return array('status' => 'Error', 'msg' => 'Invalid Input');
	}
}

function get_daily_tests(){
	$user_id = $_REQUEST['user_id'];
	$data = array();

	$student_sql = "select c.class_name, aca.section_name from student_academic as aca
	left join classes as c on c.id = aca.class
	where user_id='$user_id'";
	$student_exe = mysql_query($student_sql);
	$student_cnt = @mysql_num_rows($student_exe);
	$student_fet = mysql_fetch_assoc($student_exe);

	$className = $student_fet['class_name'];
	$sectionName = $student_fet['section_name'];

	$cls_sql="SELECT * FROM `classes` where class_name='$className'";
	$cls_exe=mysql_query($cls_sql);
	$cls_fet = mysql_fetch_assoc($cls_exe);
	$classId = $cls_fet['id'];

	$ques_sql = "select q.*, c.class_name from daily_test as q
	left join classes as c on c.id = q.class_id
	where daily_test_status='1' and q.class_id='$classId' order by id desc";
	$ques_exe = mysql_query($ques_sql);
	$ques_cnt = @mysql_num_rows($ques_exe);

	while($ques_fet=mysql_fetch_assoc($ques_exe)){
		$test_id=$ques_fet['id'];
		$test_date=date("Y-m-d");
		$check_test_sql = "select COUNT(id) AS test_count from daily_test_answer where daily_test_id='$test_id' AND `student_id`='$user_id' AND `created_at` LIKE '$test_date%' order by id asc";
		$check_test_count = mysql_fetch_array(mysql_query($check_test_sql));
		$test_count=$check_test_count['test_count'];

		$mark_question_query="SELECT COUNT(id) AS mark FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";
		$mark_question_query_exe=mysql_query($mark_question_query);
		$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
		$ques_fet['mark'] = $mark_question_query_fet['mark'];

		$std_ques_sql = "select * from daily_test_answer where daily_test_id='$test_id' AND `student_id`='$user_id' order by id asc";
		$std_ques_exe = mysql_query($std_ques_sql);
		$ques_fet['tests'] = array();
		while($std_ques_fet=mysql_fetch_assoc($std_ques_exe)){
			$daily_test_answer_id=$std_ques_fet['id'];
												
			$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$daily_test_answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
			$mark_query_exe=mysql_query($mark_query);
			$mark_query_fet=mysql_fetch_assoc($mark_query_exe);
			$std_ques_fet['mark'] = $mark_query_fet['mark'];

			$ques_fet['tests'][] = $std_ques_fet;
		}

		$data[] = $ques_fet;
	}

	return array('status' => 'Success', 'data' => $data);
}

function get_daily_test_report(){
	$student_id = $_REQUEST['user_id'];
	$test_id = $_REQUEST['test_id'];

	if($student_id && $test_id){
		$data = array('questions' => array());
		$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from daily_test as qb
		left join classes as c on c.id = qb.class_id
		where qb.id=$test_id");

		$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

		$data['info'] = $ques_bank_fet;

		$mark_query="SELECT COUNT(id) AS mark FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";
		$mark_query_exe=mysql_query($mark_query);
		$mark_query_fet=mysql_fetch_assoc($mark_query_exe);

		$data['info']['mark'] = $mark_query_fet['mark'];

		$ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN (SELECT question_id FROM `daily_test_question` WHERE `daily_test_id`='$test_id')");
        $ques_cnt = mysql_num_rows($ques_sql);
        if($ques_cnt> 0)
		{
			while($choose_fet = mysql_fetch_assoc($ques_sql)){
				$qid=$choose_fet['id'];
				$correct=0;
				$wrong=0;
				$none=0;
				$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' ORDER BY `daily_test_answer_id` ASC";
				$choose_fet['results'] = array();
				$ans_query_exe=mysql_query($ans_query);
				while($ans_query_fet=mysql_fetch_assoc($ans_query_exe))
				{
					$choose_fet['results'][] = $ans_query_fet;
					if($ans_query_fet['daily_test_mark']==1) {
						$correct++;
					} else {
						$wrong++;
					}
				}
				$choose_fet['correct'] = $correct;
				$choose_fet['wrong'] = $wrong;
				
				if(!isset($data['questions'][$choose_fet['question_type']])){
					$data['questions'][$choose_fet['question_type']] = array();
				}

				$data['questions'][$choose_fet['question_type']][] = $choose_fet;

			}
		}
		return array('status' => 'Success', 'data' => $data);
	} else {
		return array('status' => 'Error', 'msg' => 'Invalid Input');
	}
}

function write_daily_test(){
	$user_id=$_REQUEST['user_id'];
	$date = date("Y-m-d");

	$daily_test_id = $_POST['test_id'];
	$daily_test_name = $_POST['test_name'];
	$daily_test_mark = "";
	$daily_test_status = "1";
	$question_answer_value = "";

	$query = "INSERT INTO `daily_test_answer` 
			(`student_id`, `daily_test_id`, `daily_test_name`, `daily_test_mark`, `daily_test_status`, `created_at`) 
			VALUES 
			('$user_id', '$daily_test_id', '$daily_test_name', '$daily_test_mark', '1', CURRENT_TIMESTAMP)";
			   
	$query_exe = mysql_query($query);

	$dailyTestAnswerId = mysql_insert_id();

	$questions = $_POST['questions'];
	$question_answer = $_POST['question_answers'];
	$i = 1;
    foreach ($questions as $question_id => $answer) {
		$order_id = $i;
		$i++;
		$answer = strtolower(trim($answer));
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

	return array('status' => 'Success', 'id' => $dailyTestAnswerId);
}