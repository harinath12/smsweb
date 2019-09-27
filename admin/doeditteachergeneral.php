<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$teacherId = $_REQUEST['teacherId'];
$teacherName = $_REQUEST['teacherName'];
$empNo = $_REQUEST['empNo'];
$dob = $_REQUEST['dob'];
$doj = $_REQUEST['doj'];
$classJoining = $_REQUEST['classJoining'];
$gender = $_REQUEST['gender'];
$fatherName = $_REQUEST['fatherName'];
$motherName = $_REQUEST['motherName'];
$qualification = $_REQUEST['qualification'];
$experience = $_REQUEST['experience'];
$nationality = $_REQUEST['nationality'];
$religion = $_REQUEST['religion'];
$caste = $_REQUEST['caste'];
$aadharNumber = $_REQUEST['aadharNumber'];
$visibleMark = $_REQUEST['visibleMark'];
$disability = $_REQUEST['disability'];

$mobile = $_REQUEST['mobile'];
$mobile2 = $_REQUEST['mobile2'];
$mobile3 = $_REQUEST['mobile3'];
$permanentAddress = $_REQUEST['permanentAddress'];
$tempAddress = $_REQUEST['tempAddress'];

$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;
$dobtarget = null;
$addrtarget = null;
$commtarget = null;
$aadhartarget = null;

if(isset($_FILES['teacherPhoto'])){
    $info = pathinfo($_FILES['teacherPhoto']['name']);
    $base = basename($_FILES['teacherPhoto']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "teacherphoto-" . time() . "." . $ext;
        $target = 'upload/teacherphoto/' . $newname;
        $moveFile = move_uploaded_file($_FILES['teacherPhoto']['tmp_name'], $target);
    }
    $photo_sql = "UPDATE `teacher_general` set photo = '$target' where user_id = '$teacherId'";
    $photo_exe = mysql_query($photo_sql);
}

if(isset($_FILES['dobProof'])){
    $dobinfo = pathinfo($_FILES['dobProof']['name']);
    $dobbase = basename($_FILES['dobProof']['name']);
    if(!empty($dobbase)) {
        $dobext = $dobinfo['extension'];
        $dobname = "dob-" . time() . "." . $dobext;
        $dobtarget = 'upload/teacherdob/' . $dobname;
        $movedobFile = move_uploaded_file($_FILES['dobProof']['tmp_name'], $dobtarget);
    }
    $dob_sql = "UPDATE `teacher_general` set dob_proof = '$dobtarget' where user_id = '$teacherId'";
    $dob_exe = mysql_query($dob_sql);
}

if(isset($_FILES['communityProof'])){
    $comminfo = pathinfo($_FILES['communityProof']['name']);
    $commbase = basename($_FILES['communityProof']['name']);
    if(!empty($commbase)) {
        $commext = $comminfo['extension'];
        $commname = "community-" . time() . "." . $commext;
        $commtarget = 'upload/teachercommunity/' . $commname;
        $movecommFile = move_uploaded_file($_FILES['communityProof']['tmp_name'], $commtarget);
    }
    $comm_sql = "UPDATE `teacher_general` set community_proof = '$commtarget' where user_id = '$teacherId'";
    $comm_exe = mysql_query($comm_sql);
}

if(isset($_FILES['addressProof'])){
    $addrinfo = pathinfo($_FILES['addressProof']['name']);
    $addrbase = basename($_FILES['addressProof']['name']);
    if(!empty($addrbase)) {
        $addrext = $addrinfo['extension'];
        $addrname = "address-" . time() . "." . $addrext;
        $addrtarget = 'upload/teacheraddress/' . $addrname;
        $moveaddrFile = move_uploaded_file($_FILES['addressProof']['tmp_name'], $addrtarget);
    }
    $addr_sql = "UPDATE `teacher_general` set address_proof = '$addrtarget' where user_id = '$teacherId'";
    $addr_exe = mysql_query($addr_sql);
}

if(isset($_FILES['aadharProof'])) {
    $aadharinfo = pathinfo($_FILES['aadharProof']['name']);
    $aadharbase = basename($_FILES['aadharProof']['name']);
    if (!empty($aadharbase)) {
        $aadharext = $aadharinfo['extension'];
        $aadharname = "aadhar-" . time() . "." . $aadharext;
        $aadhartarget = 'upload/teacheraadhar/' . $aadharname;
        $moveaadharFile = move_uploaded_file($_FILES['aadharProof']['tmp_name'], $aadhartarget);
    }
    $aadhar_sql = "UPDATE `teacher_general` set aadhar_proof = '$aadhartarget' where user_id = '$teacherId'";
    $aadhar_exe = mysql_query($aadhar_sql);
}
$user_sql = "UPDATE `users` set name = '$teacherName' where id = '$teacherId'";
$user_exe = mysql_query($user_sql);

$student_sql = "UPDATE `teacher_general` set teacher_name = '$teacherName', dob = '$dob', doj = '$doj', class_joining = '$classJoining',
gender = '$gender', visible_mark = '$visibleMark', father_name = '$fatherName', mother_name = '$motherName', religion = '$religion',
 nationality = '$nationality', caste = '$caste', aadhar_number = '$aadharNumber', permanent_address = '$permanentAddress', temporary_address = '$tempAddress',
 qualification = '$qualification', experience = '$experience', mobile = '$mobile', mobile2 = '$mobile2', mobile3 = '$mobile3', disability = '$disability',
 updated_at = '$date', updated_by = '$username' where user_id = '$teacherId'";
$student_exe = mysql_query($student_sql);

header("Location: teacher-view.php?teacher_id=$teacherId");

?>