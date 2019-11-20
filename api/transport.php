<?php 

function get_transport(){
	$user_id = $_REQUEST['user_id'];
	
	$date = date("Y-m-d");
	$dat= date("d-m-Y");

	$studtrip_sql = mysql_query("SELECT r.*, rou.route_no, gen.user_id, t.id as tripid FROM route_stop AS r
	LEFT JOIN student_general AS gen ON gen.stop_from =r.stop_name
	left join routes as rou on rou.id = r.route_id
	left join trip as t on t.route_no = rou.route_no
	WHERE gen.user_id='$user_id' and t.trip_status='1' and t.trip_date='$dat' ORDER BY t.id DESC");
	$stutrip_fet = mysql_fetch_array($studtrip_sql);
	$routeno = $stutrip_fet['route_no'];
	$trip_id = $stutrip_fet['tripid'];

	$trip_sql="SELECT * FROM `trip` where id='$trip_id'";
	$trip_exe=mysql_query($trip_sql);
	$trip_fet = mysql_fetch_assoc($trip_exe);
	$route_no = $trip_fet['route_no'];
	$pickup_drop = $trip_fet['pickup_drop'];

	if($pickup_drop=="pickup") {
	$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id, ts.trip_time as rtrip_time, ts.trip_id FROM `routes` as r
	 LEFT JOIN route_stop as rs on rs.route_id = r.id
	 LEFT JOIN trip_stop as ts on ts.trip_stop_name = rs.stop_name and ts.trip_id = '$trip_id'
	 where route_no='$route_no' ORDER BY rs.route_order ASC";
	 } else if($pickup_drop=="drop") {
	$trip_stop_sql="SELECT r.*, rs.stop_name, rs.route_id, ts.trip_time as rtrip_time, ts.trip_id FROM `routes` as r
	 LEFT JOIN route_stop as rs on rs.route_id = r.id
	 LEFT JOIN trip_stop as ts on ts.trip_stop_name = rs.stop_name and ts.trip_id = '$trip_id'
	 where route_no='$route_no' ORDER BY rs.route_order DESC";
		 
	 }	 

	$trip_stop_exe=mysql_query($trip_stop_sql);
	$tripstop = array();
	$s=0;
	while ($trip_stop_fet = mysql_fetch_assoc($trip_stop_exe)) {
		

		$stop_name = $trip_stop_fet['stop_name'];

		$stud_sql = "select gen.*, ts.trip_student_status, ts.trip_id from student_general as gen
		LEFT JOIN users as usr on usr.id = gen.user_id
		LEFT JOIN trip_student as ts on gen.user_id = ts.student_id AND trip_id= '$trip_id'
		where usr.delete_status='1' and gen.stop_from = '$stop_name' and gen.user_id = $user_id";
		$stud_exe = mysql_query($stud_sql);
		$trip_stop_fet['student_details']=array();
		while ($stud_fet = mysql_fetch_assoc($stud_exe)) {
			$trip_stop_fet['student_details'][]= $stud_fet;
		}

		if($trip_stop_fet['rtrip_time'] == null && $s==0){
			$trip_stop_fet['show_on_the_way'] = true;
			$s = 1;
		}

		$tripstop[] = $trip_stop_fet;
	}
	

	$transport = array('trip' => $trip_fet, 'student_trip' =>$stutrip_fet, 'trip_stop'=> $tripstop);



	 return array('status' => 'Success', 'data' => $transport);

	$page = $_SERVER['PHP_SELF'];
	$sec = "10";

}