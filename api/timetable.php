<?php
function get_time_table(){
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];

	$exe1 = mysql_query("SELECT * FROM `time_table` WHERE `class`='$className' AND `section`='$sectionName' AND `time_table_status`=1");
	$data = mysql_fetch_assoc($exe1);
	

	return array('status' => 'Success', 'data' => $data);
}