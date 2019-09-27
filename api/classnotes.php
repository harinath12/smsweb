<?php
function get_class_notes(){
	$date = $_POST['date'] ? $_POST['date'] : date("Y-m-d");
	$className = $_POST['class_name'];
	$sectionName = $_POST['section_name'];

	$prev_date = date('Y-m-d', strtotime($date .' -1 day'));
	$next_date = date('Y-m-d', strtotime($date .' +1 day'));

	$periods = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII');

	$data = array('data' => [], 'current' => $date, 'prev' => $prev_date, 'next' => $next_date, 'is_today' => date('Y-m-d') == $date);

	foreach ($periods as $key => $value) {
		$exe1 = mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='$value' and date='$date' and admin_status='1'");
		$data['data'][$value] = array();
		while($row = mysql_fetch_assoc($exe1)){
			$row['class_notes_file_path'] = $row['class_notes_file_path'] ? BASEURL.'teacher/'.$row['class_notes_file_path'] : '';
			$ext = array_pop(explode('.', $row['class_notes_file_path']));
			$row['type'] = $ext;
			$data['data'][$value] = $row;
		}
	}
	

	return array('status' => 'Success', 'data' => $data);
}