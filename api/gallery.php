<?php
function get_gallery(){
	$user_id = $_REQUEST['user_id'];

	$student_sql = "select * from student_academic where user_id='$user_id'";
	$student_exe = mysql_query($student_sql);
	$student_cnt = @mysql_num_rows($student_exe);
	$student_fet = mysql_fetch_assoc($student_exe);
	$classId = $student_fet['class'];

	$circu_sql="SELECT gal.*, c.class_name FROM `gallery` as gal
	LEFT JOIN classes as c on c.id = gal.class
	where gallery_status=1 and admin_status=1 and (gal.class = '$classId' or gal.class='100') GROUP BY gal.gallery_title order by gallery_date DESC";
	$circu_exe=mysql_query($circu_sql);
	$circu_cnt=@mysql_num_rows($circu_exe);

	$data = array();

	while($row = mysql_fetch_assoc($circu_exe)){
		$row['gallery_file_path'] = BASEURL.'admin/'.$row['gallery_file_path'];
		$ext = array_pop(explode('.', $row['gallery_file_path']));
		if(in_array($ext, array('mp4','wmv','flv','avi', 'webm', 'mpg', 'mpeg'))){
			$row['type'] = 'video';
		} elseif($ext == 'mp3'){
			$row['type'] = 'audio';
		} else{
			$row['type'] = 'image';
		}
		$data[] = $row;
	}

	return array('status' => 'Success', 'data' => $data);
}