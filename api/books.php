<?php
function get_books(){
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];
	$term = $_POST['term'];
	$subject = $_POST['subject'];

	$sql =mysql_query("SELECT * FROM `books` WHERE `class`='$className' AND `subject`='$subject' AND `term`='$term' ");
	
	$data = array();

	while($row = mysql_fetch_assoc($sql)){

		$row['project1'] = $row['project1'] ? BASEURL.'admin/'.$row['project1'] : '';
		$row['project2'] = $row['project2'] ? BASEURL.'admin/'.$row['project2'] : '';
		$row['project3'] = $row['project3'] ? BASEURL.'admin/'.$row['project3'] : '';

		$data[] = $row;
		
	}

	return array('status' => 'Success', 'data' => $data);
}

function get_subject(){
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];

	$cls_sql="SELECT * FROM `classes` where class_name='$className'";
	$cls_exe=mysql_query($cls_sql);
	$cls_fet = mysql_fetch_assoc($cls_exe);
	$classId = $cls_fet['id'];

	$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
	$sub_exe = mysql_query($sub_sql);
	$sub_results = array();
	while($row = mysql_fetch_assoc($sub_exe)) {
	    array_push($sub_results, $row);
	}

	return array('status' => 'Success', 'data' => $sub_results);

}