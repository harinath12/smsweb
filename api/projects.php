<?php
function get_projects(){
	$date = $_POST['date'] ? $_POST['date'] : date("Y-m-d");
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];

	$prev_date = date('Y-m-d', strtotime($date .' -1 day'));
	$next_date = date('Y-m-d', strtotime($date .' +1 day'));

	$data = array('data' => [], 'current' => $date, 'prev' => $prev_date, 'next' => $next_date, 'is_today' => date('Y-m-d') == $date);
	$exe1 = mysql_query("select * from project where class='$className' and section='$sectionName' and date='$date' and admin_status='1'");
	$data['data'] = array();

	while ($row = mysql_fetch_assoc($exe1)) {
		$row['project1'] = $row['project1'] ? BASEURL.'teacher/'.$row['project1'] : '';
		$row['project2'] = $row['project2'] ? BASEURL.'teacher/'.$row['project2'] : '';
		$row['project3'] = $row['project3'] ? BASEURL.'teacher/'.$row['project3'] : '';
		$data['data'][] = $row;
	}
	

	return array('status' => 'Success', 'data' => $data);
}