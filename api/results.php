<?php
function get_results(){
	$stud_id = $_POST['user_id'];
	$classId = $_POST['class'];
	$sectionName = $_POST['section_name'];
	$data = array();

	$exe1 = mysql_query("SELECT ett.* FROM `exam_time_table` as ett
left join exam_date_subject as eds on eds.exam_id = ett.id
where exam_status=1 and (eds.class_id=$classId or eds.class_id=100) GROUP BY ett.`id`");
	while($row = mysql_fetch_assoc($exe1)){
		$examid = $row['id'];
		$row['subject'] = array();
		$sub_sql = "SELECT distinct subject_name FROM exam_date_subject WHERE exam_id = '$examid' and (class_id = '$classId' or class_id='100')";
		$sub_exe = mysql_query($sub_sql);
		while($sub_fet = mysql_fetch_assoc($sub_exe)){
		    $row['subject'][] = $sub_fet['subject_name'];
		}
		$row['sub_cnt'] = count($row['subject']);

		$row['entered_sub_cnt'] = 0;
		$entered_sub_exe = mysql_query("select distinct subject_name from student_mark where exam_id='$examid' and (classid = '$classId' or classid='100') and section_name='$sectionName'");
		if($entered_sub_exe){
		    $row['entered_sub_cnt'] = mysql_num_rows($entered_sub_exe);
		}
		$row['marks'] = array();
		$row['total'] = 0;
        for($i =0; $i< $row['sub_cnt']; $i++){
            $sub = $row['subject'][$i];

            $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
            $row['marks'][$i] = $mark_sql['mark'];
            $row['total'] = $row['total'] + $row['marks'][$i];
        }

        $avg = $row['total'] / $row['entered_sub_cnt'];
        if($avg > '90'){
            $row['grade'] = "A1";
        }
        else if($avg > '80'){
            $row['grade'] = "A2";
        }
        else if($avg > '70'){
            $row['grade'] = "B1";
        }
        else if($avg > '60'){
            $row['grade'] = "B2";
        }
        else if($avg > '50'){
            $row['grade'] = "C1";
        }
        else if($avg > '40'){
            $row['grade'] = "C2";
        }
        else if($avg > '30'){
            $row['grade'] = "D";
        }
        else if($avg > '20'){
            $row['grade'] = "E1";
        }
        else{
            $row['grade'] = "E2";
        }

        $row['remarks'] = array();

        $remark_sql = mysql_query("select remarks, subject_name from student_mark where exam_id='$examid' and student_id='$stud_id'");
        while($remark_fet = mysql_fetch_array($remark_sql)){
            if(!empty($remark_fet['remarks'])){
                $row['remarks'][] = $remark_fet;
            }
        }

		$data[] = $row;
	}

	return array('status' => 'Success', 'data' => $data);
}