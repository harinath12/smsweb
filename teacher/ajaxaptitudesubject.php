<?php
include "config.php";

if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
	 
	
    $section_sql = "SELECT DISTINCT `subject_name` FROM `aptitude_question_bank` WHERE `class_id` = '$cid'";
    $section_exe = mysql_query($section_sql);
    $section_results = array();
    while($row = mysql_fetch_assoc($section_exe)) {
        $section_results[] = array(
            'subject_name' => $row['subject_name']
        );
    }
    echo json_encode($section_results);


}
?>
