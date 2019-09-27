<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";


$uploadedStatus = 0;

 
if ( isset($_POST["submit"]) ) {
    if ( isset($_FILES["file"])) {
//if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }
        else {
            if (file_exists($_FILES["file"]["name"])) {
                unlink($_FILES["file"]["name"]);
            }
            $storagename = 'import/'.time()."_bulk.xlsx";
            move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
            $uploadedStatus = 1;
        }
    } else {
        echo "No file selected <br />";
    }
}

if($uploadedStatus==1) {

    /************************ YOUR DATABASE CONNECTION END HERE  ****************************/


    set_include_path(get_include_path() . PATH_SEPARATOR . 'import/Classes/');
    include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
    $inputFileName = $storagename;

    try {
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }


    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

    $classId = $_REQUEST['classId'];
    $subjectName = $_REQUEST['subjectName'];
    $term = $_REQUEST['term'];
    $chapter = $_REQUEST['chapter'];

    $username = $_SESSION['adminusername'];
    $user_id=$_SESSION['adminuserid'];
    $date = date("Y-m-d");

    if($arrayCount > 0){
        $bank_sql = mysql_query("select * from aptitude_question_bank where class_id='$classId' and subject_name='$subjectName' and term='$term' and chapter='$chapter'");
        $bank_fet = mysql_fetch_array($bank_sql);
        $bank_cnt = mysql_num_rows($bank_sql);
        if($bank_cnt > 0){
            $questionBankId = $bank_fet['id'];
        }
       else{
           $ques_bank_sql = "INSERT INTO `aptitude_question_bank` (class_id, subject_name, term, chapter, question_bank_status, created_by, updated_by, created_at, updated_at) VALUES
('$classId', '$subjectName', '$term', '$chapter', '1','$username', '$username', '$date','$date')";
           $ques_bank_exe = mysql_query($ques_bank_sql);
           $questionBankId = mysql_insert_id();
       }
        //echo $questionBankId; exit;

        for ($i = 2; $i <= $arrayCount; $i++) {
            $SlNo = trim($allDataInSheet[$i]["A"]);
            $questiontype = strtolower(trim($allDataInSheet[$i]["B"]));
            $question = trim($allDataInSheet[$i]["C"]);
            $answer = trim($allDataInSheet[$i]["D"]);
            $optiona = trim($allDataInSheet[$i]["E"]);
            $optionb = trim($allDataInSheet[$i]["F"]);
            $optionc = trim($allDataInSheet[$i]["G"]);
            $optiond = trim($allDataInSheet[$i]["H"]);
			$optione = trim($allDataInSheet[$i]["I"]);
            $othertype = trim($allDataInSheet[$i]["J"]);

            if (!empty($SlNo)) {
                if($questiontype == 'choose'){
                    $ques_sql = "INSERT INTO `aptitude_question_answer` (question_bank_id, question_type, question, optiona, optionb, optionc, optiond, optione, answer, question_answer_status, created_by, created_at) VALUES
('$questionBankId', 'Choose', '$question', '$optiona', '$optionb', '$optionc', '$optiond', '$optione', '$answer','1','$username', '$date')";
                    $ques_exe = mysql_query($ques_sql);
                }
            }
        }

    }

    header("Location: aptitude-question-bank.php?succ=2");
    exit;
}
else
{
    header("Location: aptitude-question-bank.php?error=1");
    exit;
}
?>