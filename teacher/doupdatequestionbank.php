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

//$del_question = mysql_query("Delete from question_answer where question_bank_id = '$questionBankId'");
//Meanings
if(isset($_REQUEST['meanquestionid'])){
    $meanquestionid = $_REQUEST['meanquestionid'];
    $oldmeanquestion = $_REQUEST['oldmeanquestion'];
    $oldmeananswer = $_REQUEST['oldmeananswer'];
    $oldmeancnt = count($meanquestionid);
    for ($i = 0; $i < $oldmeancnt; $i++) {
        if(!empty($meanquestionid[$i])) {
            $questionid = $meanquestionid[$i];
            $question = $oldmeanquestion[$i];
            $answer = $oldmeananswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

$meanquestion = $_REQUEST['meanquestion'];
$meananswer = $_REQUEST['meananswer'];
$meancnt = count($meanquestion);
for ($i = 0; $i < $meancnt; $i++) {
    if(!empty($meanquestion[$i])) {
        $question = $meanquestion[$i];
        $answer = $meananswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Meanings', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Opposites
if(isset($_REQUEST['oppoquestionid'])){
    $oppoquestionid = $_REQUEST['oppoquestionid'];
    $oldoppoquestion = $_REQUEST['oldoppoquestion'];
    $oldoppoanswer = $_REQUEST['oldoppoanswer'];
    $oldoppocnt = count($oppoquestionid);
    for ($i = 0; $i < $oldoppocnt; $i++) {
        if(!empty($oppoquestionid[$i])) {
            $questionid = $oppoquestionid[$i];
            $question = $oldoppoquestion[$i];
            $answer = $oldoppoanswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

$oppoquestion = $_REQUEST['oppoquestion'];
$oppoanswer = $_REQUEST['oppoanswer'];
$oppocnt = count($oppoquestion);
for ($i = 0; $i < $oppocnt; $i++) {
    if(!empty($oppoquestion[$i])) {
        $question = $oppoquestion[$i];
        $answer = $oppoanswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Opposites', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Fill Up
if(isset($_REQUEST['fillquestionid'])){
    $fillquestionid = $_REQUEST['fillquestionid'];
    $oldfillquestion = $_REQUEST['oldfillquestion'];
    $oldfillanswer = $_REQUEST['oldfillanswer'];
    $oldfillcnt = count($fillquestionid);
    for ($i = 0; $i < $oldfillcnt; $i++) {
        if(!empty($fillquestionid[$i])) {
            $questionid = $fillquestionid[$i];
            $question = $oldfillquestion[$i];
            $answer = $oldfillanswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

$fillquestion = $_REQUEST['fillquestion'];
$fillanswer = $_REQUEST['fillanswer'];
$fillcnt = count($fillquestion);
for ($i = 0; $i < $fillcnt; $i++) {
    if(!empty($fillquestion[$i])) {
        $question = $fillquestion[$i];
        $answer = $fillanswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Fill Up', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//True or False
if(isset($_REQUEST['truequestionid'])){
    $truequestionid = $_REQUEST['truequestionid'];
    $oldtruequestion = $_REQUEST['oldtruequestion'];
    $oldtrueanswer = $_REQUEST['oldtrueanswer'];
    $oldtruecnt = count($truequestionid);
    for ($i = 0; $i < $oldtruecnt; $i++) {
        if(!empty($truequestionid[$i])) {
            $questionid = $truequestionid[$i];
            $question = $oldtruequestion[$i];
            $answer = $oldtrueanswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

$truequestion = $_REQUEST['truequestion'];
$trueanswer = $_REQUEST['trueanswer'];
$truecnt = count($truequestion);
for ($i = 0; $i < $truecnt; $i++) {
    if(!empty($truequestion[$i])) {
        $question = $truequestion[$i];
        $answer = $trueanswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'True or False', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Choose
if(isset($_REQUEST['choosequestionid'])){
    $choosequestionid = $_REQUEST['choosequestionid'];
    $ques = $_REQUEST['oldchooseques'];
    $choosea = $_REQUEST['oldoptiona'];
    $chooseb = $_REQUEST['oldoptionb'];
    $choosec = $_REQUEST['oldoptionc'];
    $choosed = $_REQUEST['oldoptiond'];
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
            $answer = $ans[$i];
            $ques_sql = "UPDATE question_answer set question='$question', optiona='$optiona',optionb='$optionb',optionc='$optionc',optiond='$optiond', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

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
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, optiona, optionb, optionc, optiond, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Choose', '$question', '$optiona', '$optionb', '$optionc', '$optiond', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Match
if(isset($_REQUEST['matchquestionid'])){
    $matchquestionid = $_REQUEST['matchquestionid'];
    $oldmatchquestion = $_REQUEST['oldmatchquestion'];
    $oldmatchanswer = $_REQUEST['oldmatchanswer'];
    $oldmatchcnt = count($matchquestionid);
    for ($i = 0; $i < $oldmatchcnt; $i++) {
        if(!empty($matchquestionid[$i])) {
            $questionid = $matchquestionid[$i];
            $question = $oldmatchquestion[$i];
            $answer = $oldmatchanswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}
$matchquestion = $_REQUEST['matchquestion'];
$matchanswer = $_REQUEST['matchanswer'];
$matchcnt = count($matchquestion);
for ($i = 0; $i < $matchcnt; $i++) {
    if(!empty($matchquestion[$i])) {
        $question = $matchquestion[$i];
        $answer = $matchanswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Match', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//One or Two Words
if(isset($_REQUEST['quesid'])){
    $quesid = $_REQUEST['quesid'];
    $oldquesword = trim($_REQUEST['quesword']);
    $oldansword = trim($_REQUEST['answord']);
    $oldquescnt = count($quesid);
    for ($i = 0; $i < $oldquescnt; $i++) {
        if(!empty($quesid[$i])) {
            $questionid = $quesid[$i];
            $question = $oldquesword[$i];
            $answer = $oldansword[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}

$quesword = $_REQUEST['quesword'];
$answord = $_REQUEST['answord'];
$qacnt = count($quesword);
for ($i = 0; $i < $qacnt; $i++) {
    $question = trim($quesword[$i]);
    $answer = trim($answord[$i]);
    if(!empty($question)) {
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'One or Two Words', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Missing Words
if(isset($_REQUEST['missingquestionid'])){
    $missingquestionid = $_REQUEST['missingquestionid'];
    $oldmissingquestion = $_REQUEST['oldmissingquestion'];
    $oldmissinganswer = $_REQUEST['oldmissinganswer'];
    $oldmissingcnt = count($missingquestionid);
    for ($i = 0; $i < $oldmissingcnt; $i++) {
        if(!empty($missingquestionid[$i])) {
            $questionid = $missingquestionid[$i];
            $question = $oldmissingquestion[$i];
            $answer = $oldmissinganswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}
$missingquestion = $_REQUEST['missingquestion'];
$missinganswer = $_REQUEST['missinganswer'];
$missingcnt = count($missingquestion);
for ($i = 0; $i < $missingcnt; $i++) {
    if(!empty($missingquestion[$i])) {
        $question = $missingquestion[$i];
        $answer = $missinganswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Missing Letters', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Jumbled Words
if(isset($_REQUEST['jumblequestionid'])){
    $jumblequestionid = $_REQUEST['jumblequestionid'];
    $oldjumblequestion = $_REQUEST['oldjumblequestion'];
    $oldjumbleanswer = $_REQUEST['oldjumbleanswer'];
    $oldjumblecnt = count($jumblequestionid);
    for ($i = 0; $i < $oldjumblecnt; $i++) {
        if(!empty($jumblequestionid[$i])) {
            $questionid = $jumblequestionid[$i];
            $question = $oldjumblequestion[$i];
            $answer = $oldjumbleanswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}
$jumblequestion = $_REQUEST['jumblequestion'];
$jumbleanswer = $_REQUEST['jumbleanswer'];
$jumblecnt = count($jumblequestion);
for ($i = 0; $i < $jumblecnt; $i++) {
    if(!empty($jumblequestion[$i])) {
        $question = $jumblequestion[$i];
        $answer = $jumbleanswer[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Jumbled Words', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Jumbled Letters
if(isset($_REQUEST['jumbleletterquestionid'])){
    $jumbleletterquestionid = $_REQUEST['jumbleletterquestionid'];
    $oldjumbleletterquestion = $_REQUEST['oldjumbleletterquestion'];
    $oldjumbleletteranswer = $_REQUEST['oldjumbleletteranswer'];
    $oldjumblelettercnt = count($jumbleletterquestionid);
    for ($i = 0; $i < $oldjumblelettercnt; $i++) {
        if(!empty($jumbleletterquestionid[$i])) {
            $questionid = $jumbleletterquestionid[$i];
            $question = $oldjumbleletterquestion[$i];
            $answer = $oldjumbleletteranswer[$i];
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}
$jumbleletterquestion = $_REQUEST['jumbleletterquestion'];
$jumbleletteranswer = $_REQUEST['jumbleletteranswer'];
$jumblelettercnt = count($jumbleletterquestion);
for ($i = 0; $i < $jumblelettercnt; $i++) {
    $question = $jumbleletterquestion[$i];
    $answer = $jumbleletteranswer[$i];
    if(!empty($question)) {
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Jumbled Letters', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Dictation
if(isset($_REQUEST['dicquestionid'])){
    $dicquestionid = $_REQUEST['dicquestionid'];
    //$olddicquestion = $_REQUEST['olddicquestion'];
    $olddicanswer = $_REQUEST['olddicanswer'];
    $olddiccnt = count($dicquestionid);
    for ($i = 0; $i < $olddiccnt; $i++) {
        if(!empty($dicquestionid[$i])) {
            $questionid = $dicquestionid[$i];
            if (!empty($_FILES['olddicquestion']['name'][$i])) {
                $info = pathinfo($_FILES['olddicquestion']['name'][$i]);
                $base = basename($_FILES['olddicquestion']['name'][$i]);
                if (!empty($base)) {
                    $ext = $info['extension'];
                    $newname = "dictation-" . round(microtime(true) * 1000) . "." . $ext;
                    $question = 'upload/dictation/' . $newname;
                    $moveFile = move_uploaded_file($_FILES['olddicquestion']['tmp_name'][$i], $question);
                }

                $answer = $olddicanswer[$i];
                $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', updated_at='$date', updated_by='$username' where id='$questionid'";
                $ques_exe = mysql_query($ques_sql);
            }
        }
    }
}

$newdicquestionid = $_REQUEST['newdicquestionId'];
$dicanswer = $_REQUEST['dicanswer'];
$diccnt = count($newdicquestionid);
for ($i = 0; $i < $diccnt; $i++) {
    $answer = $dicanswer[$i];
    if (!empty($_FILES['dicquestion']['name'][$i])) {
        $info = pathinfo($_FILES['dicquestion']['name'][$i]);
        $base = basename($_FILES['dicquestion']['name'][$i]);
        if (!empty($base)) {
            $ext = $info['extension'];
            $newname = "dictation-" . round(microtime(true) * 1000) . "." . $ext;
            $question = 'upload/dictation/' . $newname;
            $moveFile = move_uploaded_file($_FILES['dicquestion']['tmp_name'][$i], $question);
        }

        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Dictation', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

//Others
if(isset($_REQUEST['otherquestionid'])){
    $otherquestionid = $_REQUEST['otherquestionid'];
    $oldothertype = $_REQUEST['oldothertype'];
    $oldotherquestion = $_REQUEST['oldotherquestion'];
    $oldotheranswer = $_REQUEST['oldotheranswer'];
    $oldotherquescnt = count($otherquestionid);
    for ($i = 0; $i < $oldotherquescnt; $i++) {
        if(!empty($otherquestionid[$i])) {
            $questionid = $otherquestionid[$i];
            $othertype = $oldothertype[$i];
            $question = trim($oldotherquestion[$i]);
            $answer = trim($oldotheranswer[$i]);
            $ques_sql = "UPDATE question_answer set question='$question', answer='$answer', other_type='$othertype', updated_at='$date', updated_by='$username' where id='$questionid'";
            $ques_exe = mysql_query($ques_sql);
        }
    }
}
$otherquestion = $_REQUEST['otherquestion'];
$otheranswer = $_REQUEST['otheranswer'];
$otype = $_REQUEST["othertype"];
$othercnt = count($otherquestion);
for ($i = 0; $i < $othercnt; $i++) {
    if (!empty($otherquestion[$i])) {
        $question = trim($otherquestion[$i]);
        $answer = trim($otheranswer[$i]);
        $otrtype = $otype[$i];
        $ques_sql = "INSERT INTO `question_answer` (question_bank_id, question_type, other_type, question, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Other', '$otrtype', '$question', '$answer','1','$username', '$date')";
        $ques_exe = mysql_query($ques_sql);
    }
}

header("Location: question-bank.php");

?>