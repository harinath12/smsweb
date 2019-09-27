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
        $SlNo = trim($allDataInSheet[$i]["A"]);
        $studentName = trim($allDataInSheet[$i]["B"]);
        $admissionNumber = trim($allDataInSheet[$i]["C"]);
        $dob = trim($allDataInSheet[$i]["D"]);
        $doj = trim($allDataInSheet[$i]["E"]);
        $classJoining = trim($allDataInSheet[$i]["F"]);
        $gender = trim($allDataInSheet[$i]["G"]);
        $fatherName = trim($allDataInSheet[$i]["H"]);
        $motherName = trim($allDataInSheet[$i]["I"]);
        $nationality = trim($allDataInSheet[$i]["J"]);
        $religion = trim($allDataInSheet[$i]["K"]);
        $caste = trim($allDataInSheet[$i]["L"]);
        $aadharNumber = trim($allDataInSheet[$i]["M"]);
        $visibleMark = trim($allDataInSheet[$i]["N"]);
        $disability = trim($allDataInSheet[$i]["O"]);
        $mobile = trim($allDataInSheet[$i]["P"]);
        $mobile2 = trim($allDataInSheet[$i]["Q"]);
        $mobile3 = trim($allDataInSheet[$i]["R"]);
        $email = trim($allDataInSheet[$i]["S"]);
        $city = trim($allDataInSheet[$i]["T"]);
        $state = trim($allDataInSheet[$i]["U"]);
        $country = trim($allDataInSheet[$i]["V"]);
        $pincode = trim($allDataInSheet[$i]["W"]);
        $permanentAddress = trim($allDataInSheet[$i]["X"]);
        $temporaryAddress = trim($allDataInSheet[$i]["Y"]);
        $rollNumber = trim($allDataInSheet[$i]["Z"]);
        $sports = trim($allDataInSheet[$i]["AA"]);
        $position = trim($allDataInSheet[$i]["AB"]);
        $extracuricular = trim($allDataInSheet[$i]["AC"]);
        $achievements = trim($allDataInSheet[$i]["AD"]);
        $emisNum = trim($allDataInSheet[$i]["AE"]);
        $community = trim($allDataInSheet[$i]["AF"]);

        $className = $_REQUEST['className'];
        $sectionName = $_REQUEST['section'];


        $pwd = md5('123456');
        $username = $_SESSION['adminusername'];
        $user_id=$_SESSION['adminuserid'];
        $date = date("Y-m-d");

        if (!empty($SlNo)) {
            $user_sql = "INSERT INTO `users` (name, email, password, confirmed, delete_status, created_at, updated_at) VALUES ('$studentName','$email','$pwd','0','1','$date','$date')";
            $user_exe = mysql_query($user_sql);
            $last_id = mysql_insert_id();

            $role_sql = "INSERT INTO `role_user` (user_id, role_id) values ('$last_id', 2)";
            $role_exe = mysql_query($role_sql);

            $insert_stud_sq1 = "INSERT INTO `student_general` (user_id, student_name, admission_number, emis_number, dob, doj, class_joining, gender, visible_mark, father_name,
mother_name, religion, nationality, community, caste, aadhar_number, permanent_address, temporary_address, city, state, country, pincode, mobile, email,
disability, mobile2, mobile3, created_by, updated_by, created_at, updated_at)
VALUES ('$last_id', '$studentName','$admissionNumber', '$emisNum', '$dob', '$doj', '$classJoining', '$gender', '$visibleMark', '$fatherName',
'$motherName', '$religion', '$nationality', '$community', '$caste', '$aadharNumber', '$permanentAddress', '$temporaryAddress', '$city', '$state', '$country', '$pincode',
'$mobile', '$email', '$disability', '$mobile2', '$mobile3', '$username','$username','$date','$date')";
            $insert_stud_exe = mysql_query($insert_stud_sq1);

            $insert_academic_sq1 = "INSERT INTO `student_academic` (user_id, admission_number, roll_number, class, section_name, position, sports, extra_curricular, achievements,
created_by, updated_by, created_at, updated_at)
VALUES ('$last_id','$admissionNumber','$rollNumber', '$className', '$sectionName', '$position', '$sports', '$extracuricular', '$achievements', '$username','$username','$date','$date')";
            $insert_academic_exe = mysql_query($insert_academic_sq1);
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