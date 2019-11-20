<?php
function get_vbooks(){
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];
	$term = $_POST['term'];
	$subject = $_POST['subject'];

	$sql =mysql_query("SELECT * FROM `video_books` WHERE `class`='$className' AND `subject`='$subject' AND `term`='$term'");

	
	$data = array();

	while($row = mysql_fetch_assoc($sql)){

		$row['project1'] = $row['project1'] ? BASEURL.'admin/'.$row['project1'] : '';
		$row['project2'] = $row['project2'] ? BASEURL.'admin/'.$row['project2'] : '';
		$row['project3'] = $row['project3'] ? BASEURL.'admin/'.$row['project3'] : '';

		$data[] = $row;
		
	}

	return array('status' => 'Success', 'data' => $data);
}

function get_all_books(){
	$className = $_POST['class_name'];

	$sql =mysql_query("SELECT * FROM `video_books` WHERE `class`='$className'");

	
	$data = array();

	while($row = mysql_fetch_assoc($sql)){

		$row['project1'] = $row['project1'] ? BASEURL.'admin/'.$row['project1'] : '';
		$row['project2'] = $row['project2'] ? BASEURL.'admin/'.$row['project2'] : '';
		$row['project3'] = $row['project3'] ? BASEURL.'admin/'.$row['project3'] : '';

		$data[] = $row;
		
	}

	$sql =mysql_query("SELECT * FROM `books` WHERE `class`='$className'");

	while($row = mysql_fetch_assoc($sql)){

		$row['project1'] = $row['project1'] ? BASEURL.'admin/'.$row['project1'] : '';
		$row['project2'] = $row['project2'] ? BASEURL.'admin/'.$row['project2'] : '';
		$row['project3'] = $row['project3'] ? BASEURL.'admin/'.$row['project3'] : '';

		$data[] = $row;
		
	}

	return array('status' => 'Success', 'data' => $data);
}