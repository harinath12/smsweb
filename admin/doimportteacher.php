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
        $teacherName = trim($allDataInSheet[$i]["B"]);
        $empNo = trim($allDataInSheet[$i]["C"]);
        $dob = trim($allDataInSheet[$i]["D"]);
        $doj = trim($allDataInSheet[$i]["E"]);
        $classJoining = trim($allDataInSheet[$i]["F"]);
        $gender = trim($allDataInSheet[$i]["G"]);
        $qualification = trim($allDataInSheet[$i]["H"]);
        $experience = trim($allDataInSheet[$i]["I"]);
        $visibleMark = trim($allDataInSheet[$i]["J"]);
        $fatherName = trim($allDataInSheet[$i]["K"]);
        $motherName = trim($allDataInSheet[$i]["L"]);
        $nationality = trim($allDataInSheet[$i]["M"]);
        $religion = trim($allDataInSheet[$i]["N"]);
        $caste = trim($allDataInSheet[$i]["O"]);
        $aadharNumber = trim($allDataInSheet[$i]["P"]);
        $permanentAddress = trim($allDataInSheet[$i]["Q"]);
        $temporaryAddress = trim($allDataInSheet[$i]["R"]);
        $mobile = trim($allDataInSheet[$i]["S"]);
        $mobile2 = trim($allDataInSheet[$i]["T"]);
        $mobile3 = trim($allDataInSheet[$i]["U"]);
        $email = trim($allDataInSheet[$i]["V"]);
        $disability = trim($allDataInSheet[$i]["W"]);
        $postDetails = trim($allDataInSheet[$i]["X"]);
        $classTeacher = trim($allDataInSheet[$i]["Y"]);
        $subject = trim($allDataInSheet[$i]["Z"]);
        $classHandling = trim($allDataInSheet[$i]["AA"]);
        $position = trim($allDataInSheet[$i]["AB"]);
        $department = trim($allDataInSheet[$i]["AC"]);

        $pwd = md5('123456');
        $username = $_SESSION['adminusername'];
        $user_id=$_SESSION['adminuserid'];
        $date = date("Y-m-d");

        if (!empty($SlNo)) {
            $user_sql = "INSERT INTO `users` (name, email, password, confirmed, delete_status, created_at, updated_at) VALUES ('$teacherName','$email','$pwd','0','1','$date','$date')";
            $user_exe = mysql_query($user_sql);
            $last_id = mysql_insert_id();

            $role_sql = "INSERT INTO `role_user` (user_id, role_id) values ('$last_id', 3)";
            $role_exe = mysql_query($role_sql);

            $insert_stud_sq1 = "INSERT INTO `teacher_general` (user_id, teacher_name, emp_no, dob, doj, class_joining, gender, visible_mark, father_name,
mother_name, qualification, experience, religion, nationality, caste, aadhar_number, permanent_address, temporary_address, mobile, mobile2, mobile3, email,
disability, created_by, updated_by, created_at, updated_at)
VALUES ('$last_id', '$teacherName','$empNo','$dob', '$doj', '$classJoining', '$gender', '$visibleMark', '$fatherName',
'$motherName', '$qualification', '$experience', '$religion', '$nationality', '$caste', '$aadharNumber', '$permanentAddress', '$temporaryAddress',
'$mobile', '$mobile2', '$mobile3', '$email', '$disability', '$username','$username','$date','$date')";
            $insert_stud_exe = mysql_query($insert_stud_sq1);

            $insert_academic_sq1 = "INSERT INTO `teacher_academic` (user_id, emp_no, post_details, class_teacher, subject, class_handling, position, department,
created_by, updated_by, created_at, updated_at)
VALUES ('$last_id','$empNo','$postDetails', '$classTeacher', '$subject', '$classHandling', '$position', '$department', '$username','$username','$date','$date')";
            $insert_academic_exe = mysql_query($insert_academic_sq1);
        }
    }

    header("Location: teacher-list.php?import=1");
    exit;
}
else
{
    header("Location: import-student.php?error=1");
    exit;
}
?>