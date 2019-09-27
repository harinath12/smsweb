<?php
function get_exam_time_table(){
	$classId = $_POST['class'];

	$data = array();

	$exe1 = mysql_query("SELECT ett.* FROM `exam_time_table` as ett
left join exam_date_subject as eds on eds.exam_id = ett.id
where exam_status=1 and (eds.class_id=$classId or eds.class_id=100) GROUP BY ett.`id`");
	while($row = mysql_fetch_assoc($exe1)){
		$exam_sql = "select * from exam_date_subject where exam_id='".$row['id']."' and (class_id='$classId' or class_id=100)";
		$exam_exe = mysql_query($exam_sql);
		$row['exams'] = array();
		while($sub_fet = mysql_fetch_assoc($exam_exe)) {
			$row['exams'][] = $sub_fet;
		}

		$data[] = $row;
	}

	return array('status' => 'Success', 'data' => $data);
}