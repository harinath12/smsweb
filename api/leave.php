<?php
function apply_leave(){
	$user_id=$_POST['user_id'];
	$date = date("Y-m-d");
	$normaldate = date("d-m-Y");

	$duration = $_POST['duration'];
	$fromdate = $_POST['fromDate'];
	$todate = $_POST['toDate'];
	$title = $_POST['title'];
	$leaveType = $_POST['leaveType'];
	$description = $_POST['description'];
	$username = $_POST['username']; 
	$date = date("Y-m-d");

	$target = null;

	if(isset($_POST['LeaveApplyFile'])){
	    $ext = $_POST['LeaveApplyFile']['ext'];
        $newname = "leaveppply-" . $user_id.$normaldate.$fromdate.$todate. "." . $ext;
        $target = '../parent/upload/leaveppply/' . $newname;
        $moveFile = file_put_contents($target, base64_decode($_POST['LeaveApplyFile']['data']));
	}

	if(isset($_POST['descriptionfile'])){
	    $ext = $_POST['descriptionfile']['ext'];
        $newname = "leavedescription-" . $user_id.$normaldate.$fromdate.$todate. "." . $ext;
        $description = '../parent/upload/leaveppply/' . $newname;
        $moveFile = file_put_contents($description, base64_decode($_POST['descriptionfile']['data']));
	}


	if($duration == 'morethanoneday'){
	    $user_sql = "INSERT INTO `student_leave` (student_id, title, leave_type, leave_details, leave_filepath, leave_from_date, leave_to_date, leave_status, admin_status, created_by, updated_by, created_at, updated_at) VALUES
	('$user_id', '$title', '$leaveType', '$description', '$target', '$fromdate', '$todate', '0', '0', '$username', '$username', '$date','$date')";
	}
	else{
	    $user_sql = "INSERT INTO `student_leave` (student_id, title, leave_type, leave_details, leave_filepath, leave_from_date, leave_to_date, leave_status, admin_status, created_by, updated_by, created_at, updated_at) VALUES
	('$user_id', '$title', '$leaveType', '$description', '$target', '$fromdate', '$fromdate', '0', '0', '$username', '$username', '$date','$date')";
	}

	$user_exe = mysql_query($user_sql);

	return array('status' => 'Success');
}

function get_leave(){
	$user_id=$_POST['user_id'];
	$remark_sql = "SELECT * FROM `student_leave` WHERE student_id = '$user_id' order by id desc";
	$remark_exe = mysql_query($remark_sql);
	$data = array();
	while($remark_fet=mysql_fetch_assoc($remark_exe)){
		$remark_fet['leave_filepath'] = BASEURL.$remark_fet['leave_filepath'];
		$data[] = $remark_fet;
	}

	return array('status' => 'Success', 'data' => $data);
}