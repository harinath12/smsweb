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

$classId = $_REQUEST['classId'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];
$otherType = $_REQUEST['otherType'];

$ques_sql = "INSERT INTO `question_bank` (class_id, subject_name, term, chapter, question_type, other_type, question_bank_status, created_by, updated_by, created_at, updated_at) VALUES
('$classId', '$subjectName', '$term', '$chapter', '$questionType', '$otherType','1','$username', '$username', '$date','$date')";
$ques_exe = mysql_query($ques_sql);
$questionBankId = mysql_insert_id();


if(isset($_REQUEST["questionId"])){
    $cnt = count($_REQUEST["questionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['question'.$i];
        $answer = $_REQUEST['answer'.$i];

        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

else if(isset($_REQUEST["quesansId"])){
    $cnt = count($_REQUEST["quesansId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['quesword'.$i];
        $answer = $_REQUEST['answord'.$i];

        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

else if(isset($_REQUEST["chooseId"])){
    $cnt = count($_REQUEST["chooseId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $ques = $_REQUEST['chooseques'.$i];
        $choosea = $_REQUEST['optiona'.$i];
        $chooseb = $_REQUEST['optionb'.$i];
        $choosec = $_REQUEST['optionc'.$i];
        $choosed = $_REQUEST['optiond'.$i];
        //$question = $ques . " A) " . $choosea . " B) " . $chooseb . " C) " . $choosec . " D) " . $choosed;
        $answer = $_REQUEST['chooseans'.$i];

        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, optiona, optionb, optionc, optiond, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$ques', '$choosea', '$chooseb', '$choosec', '$choosed', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

header("Location: question-bank.php");

?>