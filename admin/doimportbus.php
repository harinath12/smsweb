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

    for ($i = 2; $i <= $arrayCount; $i++) {
        $admissionNum = trim($allDataInSheet[$i]["A"]);
        $community = trim($allDataInSheet[$i]["B"]);
        $stop = trim($allDataInSheet[$i]["C"]);
        $username = $_SESSION['adminusername'];
        $user_id=$_SESSION['adminuserid'];
        $date = date("Y-m-d");

        if (!empty($admissionNum)) {
            $update_sql = "UPDATE student_general set stop_from='$stop', community='$community' where admission_number='$admissionNum'";
            $insert_stud_exe = mysql_query($update_sql);
        }
    }

    header("Location: student-list.php?import=1");
    exit;
}
else
{
    header("Location: import-student.php?error=1");
    exit;
}
?>