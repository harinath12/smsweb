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
$chapter = addslashes($_REQUEST['chapter']);
//$questionType = $_REQUEST['questionType'];
//$otherType = $_REQUEST['otherType'];

$bank_sql = mysql_query("select * from aptitude_question_bank where class_id='$classId' and subject_name='$subjectName' and term='$term' and chapter='$chapter'");
$bank_fet = mysql_fetch_array($bank_sql);
$bank_cnt = mysql_num_rows($bank_sql);
if($bank_cnt > 0){
    $questionBankId = $bank_fet['id'];
}
else {
    $ques_sql = "INSERT INTO `aptitude_question_bank` (class_id, subject_name, term, chapter, question_bank_status, created_by, updated_by, created_at, updated_at) VALUES
('$classId', '$subjectName', '$term', '$chapter', '1','$username', '$username', '$date','$date')";
    $ques_exe = mysql_query($ques_sql);
    $questionBankId = mysql_insert_id();
}
  

if(isset($_REQUEST["chooseId"])){
    $cnt = count($_REQUEST["chooseId"]);
    for ($i = 0; $i < $cnt; $i++) {
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