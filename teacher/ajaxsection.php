<?php
include "config.php";

if (isset($_GET['cid'])) {
    $class = $_GET['cid'];
	
	$class_sql = "SELECT * FROM `classes` WHERE `class_name`='$class'";
	$class_exe = mysql_query($class_sql);
	$class_fet = mysql_fetch_assoc($class_exe);
	$cid = $class_fet['id'];
	
    $section_sql = "SELECT * FROM class_section WHERE class_id = '$cid'";
    $section_exe = mysql_query($section_sql);
    $section_results = array();
    while($row = mysql_fetch_assoc($section_exe)) {
        $section_results[] = array(
            'section_name' => $row['section_name']
        );
    }
    echo json_encode($section_results);


}
?>
