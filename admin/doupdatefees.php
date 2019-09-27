<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");
$normaldate = date("d-m-Y");

$fee_id = $_REQUEST['fee_id'];
$fee_name = $_REQUEST['fee_name'];
$fee_amount = $_REQUEST['fee_amount'];
$fee_terms = $_REQUEST['fee_terms'];

$fee_sql = "UPDATE `fee_info` set fee_name = '$fee_name', fee_amount = '$fee_amount', fee_terms='$fee_terms', updated_date='$date' where id='$fee_id'";
$fee_exe = mysql_query($fee_sql);

if(!empty($fee_terms)){
    if($fee_terms == 'Term 1'){
        $term1_startdate = $_REQUEST['term1_startdate'];
        $term1_enddate = $_REQUEST['term1_enddate'];

        $fee_term_sql = "UPDATE `fee_terms` set fee_term_start_date='$term1_startdate', fee_term_end_date='$term1_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 1'";
        $fee_term_exe = mysql_query($fee_term_sql);

        $fee_term_sql = "UPDATE `fee_terms` set fee_term_status=0, updated_date='$date' where fee_id='$fee_id' and (fee_term='Term 2' or fee_term='Term 3')";
        $fee_term_exe = mysql_query($fee_term_sql);
    }

    else if($fee_terms == 'Term 2'){
        $term1_startdate = $_REQUEST['term1_startdate'];
        $term1_enddate = $_REQUEST['term1_enddate'];

        $term2_startdate = $_REQUEST['term2_startdate'];
        $term2_enddate = $_REQUEST['term2_enddate'];

        $fee_term_sql = "UPDATE `fee_terms` set fee_term_start_date='$term1_startdate', fee_term_end_date='$term1_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 1'";
        $fee_term_exe = mysql_query($fee_term_sql);

        $fee_term2_sql = "UPDATE `fee_terms` set fee_term_start_date='$term2_startdate', fee_term_end_date='$term2_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 2'";
        $fee_term2_exe = mysql_query($fee_term2_sql);

        $fee_term_sql = "UPDATE `fee_terms` set fee_term_status=0, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 3'";
        $fee_term_exe = mysql_query($fee_term_sql);
    }

    else if($fee_terms == 'Term 3'){
        $term1_startdate = $_REQUEST['term1_startdate'];
        $term1_enddate = $_REQUEST['term1_enddate'];

        $term2_startdate = $_REQUEST['term2_startdate'];
        $term2_enddate = $_REQUEST['term2_enddate'];

        $term3_startdate = $_REQUEST['term3_startdate'];
        $term3_enddate = $_REQUEST['term3_enddate'];

        $fee_term_sql = "UPDATE `fee_terms` set fee_term_start_date='$term1_startdate', fee_term_end_date='$term1_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 1'";
        $fee_term_exe = mysql_query($fee_term_sql);

        $fee_term2_sql = "UPDATE `fee_terms` set fee_term_start_date='$term2_startdate', fee_term_end_date='$term2_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 2'";
        $fee_term2_exe = mysql_query($fee_term2_sql);

        $fee_term3_sql = "UPDATE `fee_terms` set fee_term_start_date='$term3_startdate', fee_term_end_date='$term3_enddate', fee_term_status=1, updated_date='$date' where fee_id='$fee_id' and fee_term='Term 3'";
        $fee_term3_exe = mysql_query($fee_term3_sql);
    }

}

header("Location: fees_list.php?succ=1");

?>