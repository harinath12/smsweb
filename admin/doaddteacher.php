<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$teacherName = $_REQUEST['teacherName'];
$empno = $_REQUEST['empno'];
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
$email = $_REQUEST['email'];
$permanentAddress = $_REQUEST['permanentAddress'];
$tempAddress = $_REQUEST['tempAddress'];

$postDetails = $_REQUEST['postDetails'];
$className = $_REQUEST['className'];
$sectionName = $_REQUEST['sectionName'];
$subjects = $_REQUEST['subjects'];
$classHandling = $_REQUEST['classHandling'];
$department = $_REQUEST['department'];
$position = $_REQUEST['position'];

$classSectionHandling = "";
if(count($_REQUEST['classSectionHandling'])) {
$classSectionHandling = implode(",",$_REQUEST['classSectionHandling']);
}

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
}

if(isset($_FILES['aadharProof'])){
    $aadharinfo = pathinfo($_FILES['aadharProof']['name']);
    $aadharbase = basename($_FILES['aadharProof']['name']);
    if(!empty($aadharbase)) {
        $aadharext = $aadharinfo['extension'];
        $aadharname = "aadhar-" . time() . "." . $aadharext;
        $aadhartarget = 'upload/teacheraadhar/' . $aadharname;
        $moveaadharFile = move_uploaded_file($_FILES['aadharProof']['tmp_name'], $aadhartarget);
    }
}

$pwdtime = time();
$pwd = md5('123456');

$user_sql = "INSERT INTO `users` (name, email, password, confirmed, delete_status, created_at, updated_at) VALUES ('$teacherName','$email','$pwd','0','1','$date','$date')";
$user_exe = mysql_query($user_sql);
$last_id = mysql_insert_id();

$role_sql = "INSERT INTO `role_user` (user_id, role_id) values ('$last_id', 3)";
$role_exe = mysql_query($role_sql);

$insert_stud_sq1 = "INSERT INTO `teacher_general` (user_id, teacher_name, emp_no, dob, dob_proof, doj, class_joining, gender, photo, visible_mark, father_name,
mother_name, qualification, experience, religion, nationality, caste, community_proof, aadhar_number, aadhar_proof, permanent_address, temporary_address, mobile, mobile2, mobile3, email, address_proof,
disability, created_by, updated_by, created_at, updated_at)
VALUES ('$last_id', '$teacherName','$empno','$dob', '$dobtarget', '$doj', '$classJoining', '$gender', '$target', '$visibleMark', '$fatherName',
'$motherName', '$qualification', '$experience', '$religion', '$nationality', '$caste', '$commtarget', '$aadharNumber', '$aadhartarget', '$permanentAddress', '$tempAddress',
'$mobile', '$mobile2', '$mobile3', '$email', '$addrtarget', '$disability', '$username','$username','$date','$date')";
$insert_stud_exe = mysql_query($insert_stud_sq1);

$classTeacher = $className . " " . $sectionName;
$insert_academic_sq1 = "INSERT INTO `teacher_academic` (user_id, emp_no, post_details, class_teacher, subject, class_handling, class_section_handling, position, department,
created_by, updated_by, created_at, updated_at)
VALUES ('$last_id','$empno','$postDetails', '$classTeacher', '$subjects', '$classHandling', '$classSectionHandling', '$position', '$department', '$username','$username','$date','$date')";
$insert_academic_exe = mysql_query($insert_academic_sq1);

$cnt = count($_REQUEST["certiId"]);
for ($i = 0; $i < $cnt; $i++) {
    if (isset($_FILES['certi'.$i])) {
        $certiName = $_REQUEST['certiName'.$i];
        $info = pathinfo($_FILES['certi' . $i]['name']);
        $base = basename($_FILES['certi' . $i]['name']);
        if (!empty($base)) {
            $ext = $info['extension'];
            $newname = "certificate-" . round(microtime(true) * 1000) . "." . $ext;
            $target = 'upload/teachercertificate/' . $newname;
            $moveFile = move_uploaded_file($_FILES['certi'.$i]['tmp_name'], $target);
        }

        $gallery_sql = "INSERT INTO `certificates` (user_id, certificate_name, certificate_upload, upload_date, certificate_status, created_by, created_at) VALUES
('$last_id', '$certiName', '$target', '$date','1','$username', '$date')";
        $gallery_exe = mysql_query($gallery_sql);
    }
}

header("Location: teacher-add.php?succ=1");

?>