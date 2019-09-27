<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$studentId = $_REQUEST['studentId'];
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
$mobile2 = $_REQUEST['mobile2'];
$mobile3 = $_REQUEST['mobile3'];
//$email = $_REQUEST['email'];
$city = $_REQUEST['city'];
$state = $_REQUEST['state'];
$country = $_REQUEST['country'];
$pincode = $_REQUEST['pincode'];
$permanentAddress = $_REQUEST['permanentAddress'];
$tempAddress = $_REQUEST['tempAddress'];

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
    $photo_sql = "UPDATE `student_general` set photo = '$target' where user_id = '$studentId'";
    $photo_exe = mysql_query($photo_sql);
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
    $dob_sql = "UPDATE `student_general` set dob_proof = '$dobtarget' where user_id = '$studentId'";
    $dob_exe = mysql_query($dob_sql);
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
    $comm_sql = "UPDATE `student_general` set community_proof = '$commtarget' where user_id = '$studentId'";
    $comm_exe = mysql_query($comm_sql);
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
    $addr_sql = "UPDATE `student_general` set address_proof = '$addrtarget' where user_id = '$studentId'";
    $addr_exe = mysql_query($addr_sql);
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
    $aadhar_sql = "UPDATE `student_general` set aadhar_proof = '$aadhartarget' where user_id = '$studentId'";
    $aadhar_exe = mysql_query($aadhar_sql);
}

$user_sql = "UPDATE `users` set name = '$studentName' where id = '$studentId'";
$user_exe = mysql_query($user_sql);

$student_sql = "UPDATE `student_general` set student_name = '$studentName', dob = '$dob', doj = '$doj', emis_number = '$emisNum', class_joining = '$classJoining',
gender = '$gender', visible_mark = '$visibleMark', father_name = '$fatherName', mother_name = '$motherName', religion = '$religion',
 nationality = '$nationality', caste = '$caste', community = '$community', aadhar_number = '$aadharNumber', permanent_address = '$permanentAddress', temporary_address = '$tempAddress',
 city = '$city', state = '$state', country = '$country', pincode = '$pincode', mobile = '$mobile',mobile2 = '$mobile2', mobile3 = '$mobile3', disability = '$disability',
 vehicle_by = '$vehicle_by', stop_from = '$stop_from', updated_at = '$date', updated_by = '$username' where user_id = '$studentId'";
$student_exe = mysql_query($student_sql);

header("Location: student-view.php?student_id=$studentId");

?>