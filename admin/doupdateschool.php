<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

if(isset($_REQUEST['school_id'])) {
    $school_id = $_REQUEST['school_id'];
    $userId = $_REQUEST['userId'];
    $schoolName = $_REQUEST['schoolName'];
    $personName = $_REQUEST['personName'];
    $address = $_REQUEST['address'];
    $cityId = $_REQUEST['cityId'];
    $state = $_REQUEST['state'];
    $countryId = $_REQUEST['countryId'];
    $pincode = $_REQUEST['pincode'];
    $telephone = $_REQUEST['telephone'];
    $mobile = $_REQUEST['mobile'];
    $email = $_REQUEST['email'];
    $website = $_REQUEST['website'];
    $schoolcode = $_REQUEST['schoolcode'];
    $username = $_SESSION['adminusername'];
    $date = date("Y-m-d");

    $sql = "UPDATE `school_info` SET `name_school` = '$schoolName', `name_person` = '$personName', `user_id` = '$userId',
`address` = '$address', `city` = '$cityId', `state` = '$state',`country` = '$countryId',`mobile` = '$mobile', `email` = '$email',
 `pincode` = '$pincode', `telephone` = '$telephone',`website` = '$website', `school_code` = '$schoolcode',
            `updated_by` = '$username', `updated_at` = '$date'
            WHERE `school_info`.`id` = '$school_id'";
    $exe = mysql_query($sql);
    header("Location: profile-list.php?suc=1");
}
else{
    header("Location: profile-list.php?err=1");
}

?>