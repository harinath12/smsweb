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

$questionBankId = $_REQUEST['question_bank_id'];

$del_quesbank_sql = "Delete from question_answer where question_bank_id = '$questionBankId'";
$del_quesbank_exe = mysql_query($del_quesbank_sql);

if(isset($_REQUEST["question"])){
    $cnt = count($_REQUEST["question"]);

    $ques = $_REQUEST['question'];
    $ans = $_REQUEST['answer'];
    for ($i = 0; $i < $cnt; $i++) {
        $question = $ques[$i];
        $answer = $ans[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

else if(isset($_REQUEST["quesword"])){
    $cnt = count($_REQUEST["quesword"]);
    $ques = $_REQUEST['quesword'];
    $ans = $_REQUEST['answord'];
    for ($i = 0; $i < $cnt; $i++) {
        $question = $ques[$i];
        $answer = $ans[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

else if(isset($_REQUEST["chooseques"])){
    $cnt = count($_REQUEST["chooseques"]);
    $ques = $_REQUEST['chooseques'];
    $choosea = $_REQUEST['optiona'];
    $chooseb = $_REQUEST['optionb'];
    $choosec = $_REQUEST['optionc'];
    $choosed = $_REQUEST['optiond'];
    $answer = $_REQUEST['chooseans'];

    for ($i = 0; $i < $cnt; $i++) {
        $question = $ques[$i];
        $optiona = $choosea[$i];
        $optionb = $chooseb[$i];
        $optionc = $choosec[$i];
        $optiond = $choosed[$i];
        $ans = $answer[$i];

        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question, optiona, optionb, optionc, optiond, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', '$question', '$optiona', '$optionb', '$optionc', '$optiond', '$ans','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

header("Location: question-bank.php");
?>