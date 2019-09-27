<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

//define('BASEURL', 'http://localhost/sms2019/');
define('BASEURL', 'http://dev.srivinayagaschoolpennagaram.com/');

$_POST = json_decode(file_get_contents('php://input'), TRUE);

$files = array('db', 'homework', 'attendance', 'calendar', 'gallery', 'test','selftest', 'classnotes', 'timetable', 'projects', 
    'examtimetable', 'results', 'profile', 'books', 'videobooks', 'neetjeetest', 'fairnote', 'transport');
foreach ($files as $key => $value) {
    include $value.'.php';
}

function student_login(){
	$userName=$_POST['username'];
    $password=$_POST['password'];
    $password_md5=md5($password);
    $sql="SELECT users.*, gen.admission_number FROM `student_general` as gen
LEFT JOIN `users` ON users.id = gen.user_id
LEFT JOIN `role_user` ON users.id = role_user.user_id
WHERE gen.`admission_number`='$userName' AND users.`password`='$password_md5' and users.`delete_status`='1' and role_id=2";
    $exe=mysql_query($sql);
    $num=@mysql_num_rows($exe);

    if($num>0)
    {
        $fet=@mysql_fetch_assoc($exe);
        $user_id=$fet['id'];

        $role_sql="SELECT * FROM `role_user` WHERE `user_id`='$user_id'";
        $role_exe=mysql_query($role_sql);
        $role_fet=@mysql_fetch_assoc($role_exe);
        $fet['role_id']=$role_fet['role_id'];

        $sql="SELECT sg.*,sa.class, sa.section_name, cl.class_name FROM `student_general` AS sg 
        INNER JOIN `student_academic` AS sa on sg.user_id = sa.user_id
        INNER JOIN `classes` AS cl on sa.class = cl.id
        WHERE 
        sg.user_id = $user_id";

        $exe=mysql_query($sql);
        $cnt=@mysql_num_rows($exe);
        $fet['academic']=mysql_fetch_assoc($exe);

        $fet['academic']['photo'] = BASEURL.'admin/'. $fet['academic']['photo'];


        $class_section_value = $fet['academic']['class_name']." ".$fet['academic']['section_name'];

        $teacher_info_sql="SELECT tg.teacher_name, tg.emp_no, ta.class_teacher FROM `teacher_general` AS tg 
        INNER JOIN `teacher_academic` AS ta on tg.user_id = ta.user_id
        WHERE 
        ta.class_teacher = '$class_section_value'";

        $teacher_info_exe=mysql_query($teacher_info_sql);
        $teacher_info_cnt=@mysql_num_rows($teacher_info_exe);
        $fet['teacher'] = mysql_fetch_assoc($teacher_info_exe);

        $data = array('status' => 'Success', 'data' => $fet);
    }
    else
    {
        $data = array('status' => 'Error', 'msg' => 'Invalid Credentials');
    }
    return $data;
}

if(isset($_GET['action'])){
    $res = $_GET['action']();
    if(isset($_GET['debug'])){
        echo '<pre>';print_r($res);
    } else {
        echo json_encode($res);
    }
}