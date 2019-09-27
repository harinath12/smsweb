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

$fee_name = $_REQUEST['fee_name'];
$fee_amount = $_REQUEST['fee_amount'];
$fee_terms = $_REQUEST['fee_terms'];

$fee_sql = "INSERT INTO `fee_info` (fee_name, fee_amount, fee_terms, fee_status, created_date) VALUES
('$fee_name','$fee_amount', '$fee_terms', '1', '$normaldate')";
$fee_exe = mysql_query($fee_sql);
$fee_id = mysql_insert_id();

if(!empty($fee_terms)){
    if(($fee_terms == 'Term 1') || ($fee_terms == 'Term 2') || ($fee_terms == 'Term 3')){
        $term1_startdate = $_REQUEST['term1_startdate'];
        $term1_enddate = $_REQUEST['term1_enddate'];

        $fee_term_sql = "INSERT INTO `fee_terms` (fee_id, fee_term, fee_term_start_date, fee_term_end_date, fee_term_status, created_date) VALUES
('$fee_id', 'Term 1','$term1_startdate', '$term1_enddate', '1', '$normaldate')";
        $fee_term_exe = mysql_query($fee_term_sql);
    }

    if(($fee_terms == 'Term 2') || ($fee_terms == 'Term 3')){
        $term2_startdate = $_REQUEST['term2_startdate'];
        $term2_enddate = $_REQUEST['term2_enddate'];

        $fee_term_sql = "INSERT INTO `fee_terms` (fee_id, fee_term, fee_term_start_date, fee_term_end_date, fee_term_status, created_date) VALUES
('$fee_id', 'Term 2','$term2_startdate', '$term2_enddate', '1', '$normaldate')";
        $fee_term_exe = mysql_query($fee_term_sql);
    }

    if($fee_terms == 'Term 3'){
        $term3_startdate = $_REQUEST['term3_startdate'];
        $term3_enddate = $_REQUEST['term3_enddate'];

        $fee_term_sql = "INSERT INTO `fee_terms` (fee_id, fee_term, fee_term_start_date, fee_term_end_date, fee_term_status, created_date) VALUES
('$fee_id', 'Term 3','$term3_startdate', '$term3_enddate', '1', '$normaldate')";
        $fee_term_exe = mysql_query($fee_term_sql);
    }

}

header("Location: fees_list.php?succ=1");

?>