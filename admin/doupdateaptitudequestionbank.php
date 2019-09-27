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

$questionBankId = $_REQUEST['questionbankid'];

print_r($_REQUEST);

//Choose
if(isset($_REQUEST['choosequestionid'])){
    $choosequestionid = $_REQUEST['choosequestionid'];
    $ques = $_REQUEST['oldchooseques'];
    $choosea = $_REQUEST['oldoptiona'];
    $chooseb = $_REQUEST['oldoptionb'];
    $choosec = $_REQUEST['oldoptionc'];
    $choosed = $_REQUEST['oldoptiond'];
	$choosee = $_REQUEST['oldoptione'];
    $ans = $_REQUEST['oldchooseans'];
    $quescnt = count($choosequestionid);
    for ($i = 0; $i < $quescnt; $i++) {
        if(!empty($choosequestionid[$i])) {
            $questionid = $choosequestionid[$i];
            $question = $ques[$i];
            $optiona = $choosea[$i];
            $optionb = $chooseb[$i];
            $optionc = $choosec[$i];
            $optiond = $choosed[$i];
			$optione = $choosee[$i];
            $answer = $ans[$i];
            $ques_sql = "UPDATE aptitude_question_answer set question='$question', optiona='$optiona',optionb='$optionb',optionc='$optionc',optiond='$optiond',optione='$optione', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

/*
$ques = $_REQUEST['chooseques'];
$choosea = $_REQUEST['optiona'];
$chooseb = $_REQUEST['optionb'];
$choosec = $_REQUEST['optionc'];
$choosed = $_REQUEST['optiond'];
$ans = $_REQUEST['chooseans'];
$quescnt = count($ques);
for ($i = 0; $i < $quescnt; $i++) {
    if(!empty($ques[$i])) {
        $question = $ques[$i];
        $optiona = $choosea[$i];
        $optionb = $chooseb[$i];
        $optionc = $choosec[$i];
        $optiond = $choosed[$i];
        $answer = $ans[$i];
        echo $ques_sql = "INSERT INTO `aptitude_question_answer` (question_bank_id, question_type, question, optiona, optionb, optionc, optiond, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Choose', '$question', '$optiona', '$optionb', '$optionc', '$optiond', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}
*/


if(isset($_REQUEST["chooseId"])){
    $cnt = count($_REQUEST["chooseId"]);
    for ($i = 0; $i <= $cnt; $i++) {
        $ques = $_REQUEST['chooseques'.$i];
        $choosea = $_REQUEST['optiona'.$i];
        $chooseb = $_REQUEST['optionb'.$i];
        $choosec = $_REQUEST['optionc'.$i];
        $choosed = $_REQUEST['optiond'.$i];
		$choosee = $_REQUEST['optione'.$i];
        $answer = $_REQUEST['chooseans'.$i];
        if(!empty($ques)) {
            $ques_sql = "INSERT INTO `aptitude_question_answer` (question_bank_id, question_type, question, optiona, optionb, optionc, optiond, optione, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Choose', '$ques', '$choosea', '$chooseb', '$choosec', '$choosed', '$choosee', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}


header("Location: aptitude-question-bank.php");

?>