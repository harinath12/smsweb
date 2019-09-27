<?php
include "config.php";
$school_status = array();
$schoolcode=$_REQUEST['schoolcode'];
$school_sql="SELECT * FROM `school_info` WHERE `school_code`='$schoolcode'";
$school_exe=mysql_query($school_sql);
$school_cnt=mysql_num_rows($school_exe);
if($school_cnt==0)
{
    $school_status['status']="1";
    $school_status['ieccode']=$schoolcode;
}
else
{
    $school_status['status']="2";
    $school_status['ieccode']=$schoolcode;
}
echo html_entity_decode(json_encode($school_status));
?>

