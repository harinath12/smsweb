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

	$data = array();
	
	$cnt = array('video_books' => 0, 'books' => 0, 'gallery' => 0);

	$sql =mysql_query("SELECT * FROM `books` WHERE `class`='$className'");

	while($row = mysql_fetch_assoc($sql)){

		if($row['project1']){
			$data[] = BASEURL.'admin/'.$row['project1'];
		}
		if($row['project2']){
			$data[] = BASEURL.'admin/'.$row['project2'];
		}
		if($row['project3']){
			$data[] = BASEURL.'admin/'.$row['project3'];
		}
		$cnt['books']++;
	}

	$circu_sql="SELECT gal.*, c.class_name FROM `gallery` as gal
	LEFT JOIN classes as c on c.id = gal.class
	where gallery_status=1 and admin_status=1 and (gal.class = '".$_POST['class']."' or gal.class='100') GROUP BY gal.gallery_title order by gallery_date DESC";
	$circu_exe=mysql_query($circu_sql);
	$circu_cnt=@mysql_num_rows($circu_exe);

	while($row = mysql_fetch_assoc($circu_exe)){
		$data[] = BASEURL.'admin/'.$row['gallery_file_path'];
		$cnt['gallery']++;
	}

	$sql =mysql_query("SELECT * FROM `video_books` WHERE `class`='$className'");
	while($row = mysql_fetch_assoc($sql)){
		if($row['project1']){
			$data[] = BASEURL.'admin/'.$row['project1'];
		}
		if($row['project2']){
			$data[] = BASEURL.'admin/'.$row['project2'];
		}
		if($row['project3']){
			$data[] = BASEURL.'admin/'.$row['project3'];
		}
		$cnt['video_books']++;
	}

	return array('status' => 'Success', 'data' => $data, 'cnt' => $cnt);
}