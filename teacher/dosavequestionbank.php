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

$bank_sql = mysql_query("select * from question_bank where class_id='$classId' and subject_name='$subjectName' and term='$term' and chapter='$chapter'");
$bank_fet = mysql_fetch_array($bank_sql);
$bank_cnt = mysql_num_rows($bank_sql);
if($bank_cnt > 0){
    $questionBankId = $bank_fet['id'];
}
else {
    $ques_sql = "INSERT INTO `question_bank` (class_id, subject_name, term, chapter, question_bank_status, created_by, updated_by, created_at, updated_at) VALUES
('$classId', '$subjectName', '$term', '$chapter', '1','$username', '$username', '$date','$date')";
    $ques_exe = mysql_query($ques_sql);
    $questionBankId = mysql_insert_id();
}

if(isset($_REQUEST["meanquestionId"])){
    $cnt = count($_REQUEST["meanquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['meanquestion'.$i];
        $answer = $_REQUEST['meananswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Meanings', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["oppoquestionId"])){
    $cnt = count($_REQUEST["oppoquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['oppoquestion'.$i];
        $answer = $_REQUEST['oppoanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Opposites', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["fillquestionId"])){
    $cnt = count($_REQUEST["fillquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['fillquestion'.$i];
        $answer = $_REQUEST['fillanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Fill Up', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["chooseId"])){
    $cnt = count($_REQUEST["chooseId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $ques = $_REQUEST['chooseques'.$i];
        $choosea = $_REQUEST['optiona'.$i];
        $chooseb = $_REQUEST['optionb'.$i];
        $choosec = $_REQUEST['optionc'.$i];
        $choosed = $_REQUEST['optiond'.$i];
        $answer = $_REQUEST['chooseans'.$i];
        if(!empty($ques)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, optiona, optionb, optionc, optiond, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Choose', '$ques', '$choosea', '$chooseb', '$choosec', '$choosed', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["truequestionId"])){
    $cnt = count($_REQUEST["truequestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['truequestion'.$i];
        $answer = $_REQUEST['trueanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'True or False', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["matchquestionId"])){
    $cnt = count($_REQUEST["matchquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['matchquestion'.$i];
        $answer = $_REQUEST['matchanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Match', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["quesansId"])){
    $cnt = count($_REQUEST["quesansId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = trim($_REQUEST['quesword'.$i]);
        $answer = trim($_REQUEST['answord'.$i]);
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'One or Two Words', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["missingquestionId"])){
    $cnt = count($_REQUEST["missingquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['missingquestion'.$i];
        $answer = $_REQUEST['missinganswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Missing Letters', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["jumblequestionId"])){
    $cnt = count($_REQUEST["jumblequestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['jumblequestion'.$i];
        $answer = $_REQUEST['jumbleanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Jumbled Words', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["jumbleletterquestionId"])){
    $cnt = count($_REQUEST["jumbleletterquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $question = $_REQUEST['jumbleletterquestion'.$i];
        $answer = $_REQUEST['jumbleletteranswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Jumbled Letters', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

if(isset($_REQUEST["dicquestionId"])){
    $cnt = count($_REQUEST["dicquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        if (isset($_FILES['dicquestion'.$i])) {
            $info = pathinfo($_FILES['dicquestion' . $i]['name']);
            $base = basename($_FILES['dicquestion' . $i]['name']);
            if (!empty($base)) {
                $ext = $info['extension'];
                $newname = "dictation-" . round(microtime(true) * 1000) . "." . $ext;
                $question = 'upload/dictation/' . $newname;
                $moveFile = move_uploaded_file($_FILES['dicquestion' . $i]['tmp_name'], $question);
            }
        }
        $answer = $_REQUEST['dicanswer'.$i];
        if(!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Dictation', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

    if(isset($_REQUEST["otherquestionId"])){
    $cnt = count($_REQUEST["otherquestionId"]);
    for ($i = 0; $i < $cnt; $i++) {
        $othertype = $_REQUEST['othertype' . $i];
        $question = trim($_REQUEST['otherquestion' . $i]);
        $answer = trim($_REQUEST['otheranswer' . $i]);
        if (!empty($question)) {
            $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, other_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Other', '$othertype', '$question', '$answer','1','$username', '$date')";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

header("Location: question-bank.php");

?>