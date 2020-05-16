<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

//define('BASEURL', 'http://localhost/sms2019/');
define('BASEURL', 'http://srivinayagaschoolpennagaram.com/');

$_POST = json_decode(file_get_contents('php://input'), TRUE);

$files = array('db', 'homework', 'attendance', 'calendar', 'gallery', 'test','selftest', 'classnotes', 'timetable', 'projects', 'leave',
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

        $teacher_info_sql="SELECT tg.teacher_name, tg.emp_no, tg.email, ta.class_teacher FROM `teacher_general` AS tg 
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

function getupdatedInfo(){
    $array  = array('daily_test' => array(), 'self_test' => array(), 'aptitude_test' => array());

    foreach($array as $k=>$v){
        $sql = mysql_query("select * from ".$k." where updated_at > '".$_POST['date']."'");

        while($res = mysql_fetch_assoc($sql)){
            $array[$k][] = $res['id'];
        }
    }

    $sql = mysql_query("select * from question_bank where class_id = ".$_POST['class']." and updated_at > '".$_POST['date']."'");

    $array['fairnote'] = [];
    while($res = mysql_fetch_assoc($sql)){
        if(!isset($array['fairnote'][$res['term']])){
            $array['fairnote'][$res['term']] = [];
        }

        if(!isset($array['fairnote'][$res['term']][$res['subject_name']])){
            $array['fairnote'][$res['term']][$res['subject_name']] = [];
        }
        $array['fairnote'][$res['term']][$res['subject_name']][] = $res['chapter'];
    }

    $sql = mysql_query("select * from books where class = '".$_POST['class']."' and updated_at > '".$_POST['date']."'");

    $array['books'] = array('term' => [], 'subject' => []);
    while($res = mysql_fetch_assoc($sql)){
        $array['books']['term'][] = $res['term'];
        $array['books']['subject'][] = $res['subject'];
    }

    $array['books']['term'] = array_unique($array['books']['term']);
    $array['books']['subject'] = array_unique($array['books']['subject']);

    $sql = mysql_query("select * from video_books where class = '".$_POST['class']."' and updated_at > '".$_POST['date']."'");

    $array['video_books'] = array('term' => [], 'subject' => []);
    while($res = mysql_fetch_assoc($sql)){
        $array['video_books']['term'][] = $res['term'];
        $array['video_books']['subject'][] = $res['subject'];
    }

    $array['video_books']['term'] = array_unique($array['video_books']['term']);
    $array['video_books']['subject'] = array_unique($array['video_books']['subject']);

    $sql = mysql_query("select * from homework where section = '".$_POST['section']."' and class = '".$_POST['class_name']."' and updated_at > '".$_POST['date']."'");

    $array['get_homework'] = [];
    while($res = mysql_fetch_assoc($sql)){
        $array['get_homework'][] = $res['date'];
    }

    $sql = mysql_query("select * from project where section = '".$_POST['section']."' and class = '".$_POST['class_name']."' and updated_at > '".$_POST['date']."'");

    $array['get_projects'] = [];
    while($res = mysql_fetch_assoc($sql)){
        $array['get_projects'][] = $res['date'];
    }

    $sql = mysql_query("select * from class_notes where section = '".$_POST['section']."' and class = '".$_POST['class_name']."' and updated_at > '".$_POST['date']."'");

    $array['get_class_notes'] = [];
    while($res = mysql_fetch_assoc($sql)){
        $array['get_class_notes'][] = $res['date'];
    }

    $sql = mysql_query("select * from attendance where user_id = '".$_POST['user_id']."' and section_name = '".$_POST['section']."' and class_id = '".$_POST['class']."' and updated_at > '".$_POST['date']."'");

    $array['attendance'] = mysql_num_rows($sql);

    $sql = mysql_query("select * from calendar where updated_at > '".$_POST['date']."'");

    $array['calendar'] = mysql_num_rows($sql);
    $array['calendar'] = $array['calendar'] ? $array['calendar'] : 0;

    $sql = mysql_query("select * from time_table where section_name = '".$_POST['section']."' and class = '".$_POST['class_name']."' and updated_at > '".$_POST['date']."'");

    $array['get_time_table'] = mysql_num_rows($sql);
    $array['get_time_table'] = $array['get_time_table'] ? $array['get_time_table'] : 0;

    $sql = mysql_query("select * from exam_time_table where class_id = '".$_POST['class_name']."' and updated_at > '".$_POST['date']."'");

    $array['get_exam_time_table'] = mysql_num_rows($sql);
    $array['get_exam_time_table'] = $array['get_exam_time_table'] ? $array['get_exam_time_table'] : 0;

    $sql = mysql_query("select * from gallery where class = '".$_POST['class']."' and updated_at > '".$_POST['date']."'");

    $array['gallery'] = mysql_num_rows($sql);
    $array['gallery'] = $array['gallery'] ? $array['gallery'] : 0;
    
    $data = array('status' => 'Success', 'data' => $array);

    return $data;
}