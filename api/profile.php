<?php

function get_profile(){
	$user_id = $_POST['user_id'];
	

	$sql="SELECT stu.*, aca.roll_number, aca.position, aca.sports, aca.extra_curricular, aca.achievements, c.class_name, s.section_name FROM `student_general` as stu
		left join student_academic as aca on aca.admission_number = stu.admission_number
		left join classes as c on c.id = aca.class
		left join section as s on s.id = aca.section
		where stu.user_id = '$user_id'";

    $exe=mysql_query($sql);

    $data = mysql_fetch_assoc($exe);

    $data['photo']= BASEURL.'admin/'.$data['photo'];
    
	return array('status' => 'Success', 'data' => $data);
}