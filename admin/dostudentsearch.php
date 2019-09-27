<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$studentName = $_REQUEST['studentName'];
$admissionNum = $_REQUEST['admissionNum'];
$emisNum = $_REQUEST['emisNum'];
$dob = $_REQUEST['dob'];
$doj = $_REQUEST['doj'];
$classJoining = $_REQUEST['classJoining'];
$gender = $_REQUEST['gender'];
$fatherName = $_REQUEST['fatherName'];
$motherName = $_REQUEST['motherName'];
$nationality = $_REQUEST['nationality'];
$religion = $_REQUEST['religion'];
$caste = $_REQUEST['caste'];
$community = $_REQUEST['community'];
$aadharNumber = $_REQUEST['aadharNumber'];
$visibleMark = $_REQUEST['visibleMark'];
$disability = $_REQUEST['disability'];
$vehicle_by = $_REQUEST['vehicle_by'];
$stop_from = $_REQUEST['stop_from'];

$mobile = $_REQUEST['mobile'];
$email = $_REQUEST['email'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$country = $_REQUEST['country'];
$pincode = $_REQUEST['pincode'];
$mobile2 = $_REQUEST['mobile2'];
$mobile3 = $_REQUEST['mobile3'];
$permanentAddress = $_REQUEST['permanentAddress'];
$tempAddress = $_REQUEST['tempAddress'];

$rollNo = $_REQUEST['rollNo'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$sportsDetails = $_REQUEST['sportsDetails'];
$position = $_REQUEST['position'];
$extraCurricular = $_REQUEST['extraCurricular'];
$achievements = $_REQUEST['achievements'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;
$dobtarget = null;
$addrtarget = null;
$commtarget = null;
$aadhartarget = null;

if(isset($_FILES['studPhoto'])){
    $info = pathinfo($_FILES['studPhoto']['name']);
    $base = basename($_FILES['studPhoto']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "studentphoto-" . time() . "." . $ext;
        $target = 'upload/studentphoto/' . $newname;
        $moveFile = move_uploaded_file($_FILES['studPhoto']['tmp_name'], $target);
    }
}

if(isset($_FILES['dobProof'])){
    $dobinfo = pathinfo($_FILES['dobProof']['name']);
    $dobbase = basename($_FILES['dobProof']['name']);
    if(!empty($dobbase)) {
        $dobext = $dobinfo['extension'];
        $dobname = "dob-" . time() . "." . $dobext;
        $dobtarget = 'upload/studentdob/' . $dobname;
        $movedobFile = move_uploaded_file($_FILES['dobProof']['tmp_name'], $dobtarget);
    }
}

if(isset($_FILES['communityProof'])){
    $comminfo = pathinfo($_FILES['communityProof']['name']);
    $commbase = basename($_FILES['communityProof']['name']);
    if(!empty($commbase)) {
        $commext = $comminfo['extension'];
        $commname = "community-" . time() . "." . $commext;
        $commtarget = 'upload/studentcommunity/' . $commname;
        $movecommFile = move_uploaded_file($_FILES['communityProof']['tmp_name'], $commtarget);
    }
}

if(isset($_FILES['addressProof'])){
    $addrinfo = pathinfo($_FILES['addressProof']['name']);
    $addrbase = basename($_FILES['addressProof']['name']);
    if(!empty($addrbase)) {
        $addrext = $addrinfo['extension'];
        $addrname = "address-" . time() . "." . $addrext;
        $addrtarget = 'upload/studentaddress/' . $addrname;
        $moveaddrFile = move_uploaded_file($_FILES['addressProof']['tmp_name'], $addrtarget);
    }
}

if(isset($_FILES['aadharProof'])){
    $aadharinfo = pathinfo($_FILES['aadharProof']['name']);
    $aadharbase = basename($_FILES['aadharProof']['name']);
    if(!empty($aadharbase)) {
        $aadharext = $aadharinfo['extension'];
        $aadharname = "aadhar-" . time() . "." . $aadharext;
        $aadhartarget = 'upload/studentaadhar/' . $aadharname;
        $moveaadharFile = move_uploaded_file($_FILES['aadharProof']['tmp_name'], $aadhartarget);
    }
}

$pwdtime = time();
$pwd = md5('123456');

$user_sql = "INSERT INTO `users` (name, email, password, confirmed, delete_status, created_at, updated_at) VALUES ('$studentName','$email','$pwd','0','1','$date','$date')";
$user_exe = mysql_query($user_sql);
$last_id = mysql_insert_id();

$role_sql = "INSERT INTO `role_user` (user_id, role_id) values ('$last_id', 2)";
$role_exe = mysql_query($role_sql);

$insert_stud_sq1 = "INSERT INTO `student_general` (user_id, student_name, admission_number, emis_number, dob, dob_proof, doj, class_joining, gender, photo, visible_mark, father_name,
mother_name, religion, nationality, caste, community, community_proof, aadhar_number, aadhar_proof, permanent_address, temporary_address, city, state, country, pincode, mobile, email, address_proof,
disability, mobile2, mobile3, vehicle_by, stop_from, created_by, updated_by, created_at, updated_at)
VALUES ('$last_id', '$studentName','$admissionNum', '$emisNum', '$dob', '$dobtarget', '$doj', '$classJoining', '$gender', '$target', '$visibleMark', '$fatherName',
'$motherName', '$religion', '$nationality', '$caste', '$community', '$commtarget', '$aadharNumber', '$aadhartarget', '$permanentAddress', '$tempAddress', '$city', '$state', '$country', '$pincode',
'$mobile', '$email', '$addrtarget', '$disability', '$mobile2', '$mobile3', '$vehicle_by', '$stop_from', '$username','$username','$date','$date')";
$insert_stud_exe = mysql_query($insert_stud_sq1);

$insert_academic_sq1 = "INSERT INTO `student_academic` (user_id, admission_number, roll_number, class, section_name, position, sports, extra_curricular, achievements,
created_by, updated_by, created_at, updated_at)
VALUES ('$last_id','$admissionNum','$rollNo', '$className', '$sectionName', '$position', '$sportsDetails', '$extraCurricular', '$achievements', '$username','$username','$date','$date')";
$insert_academic_exe = mysql_query($insert_academic_sq1);

header("Location: student-add.php?succ=1");

?>