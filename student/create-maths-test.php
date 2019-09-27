<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/* CREATE TEST # START */

$student_sql = "select aca.class as classID, aca.section_name from student_academic as aca
left join class_section as cs on cs.class_id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$classID = $student_fet['classID'];
//$sectionID = $student_fet['sectionID'];
$sectionID = 1;

$create_maths_test = "INSERT INTO `maths_test` 
			   (`student_id`, `class_id`, `subject_name`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
			   VALUES 
			   ('$user_id', '$classID', 'Maths', '1', 'Maths Test', 'None', '', '1', 'Student', 'Student', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $create_maths_test;

$create_maths_test_exe = mysql_query($create_maths_test);

$maths_test_id = mysql_insert_id();
			   

#TYPE-1
$number_array = array(0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine'); 
$randIndex = array_rand($number_array);

$maths_test_type = 1;
$maths_test_question = "Wrire the Number Name : ".$randIndex." = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


#TYPE-2
$number_array = array(0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine'); 
$randIndex = array_rand($number_array);

$maths_test_type = 2;
$maths_test_question = "Wrire in Numerals: ".$number_array[$randIndex]." = ";
$maths_test_answer = $randIndex;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-3
$number_array = array(2=>'10',3=>'100',4=>'1000',5=>'10000'); 
$randIndex = array_rand($number_array);

$maths_test_type = 3;
$maths_test_question = "Smallest ".$randIndex." digit no = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-4
$number_array = array(1=>'9',2=>'99',3=>'999',4=>'9999',5=>'99999'); 
$randIndex = array_rand($number_array);

$maths_test_type = 4;
$maths_test_question = "Largest ".$randIndex." digit no = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-5

$randValue = rand(10,100);
$randValuebefore = $randValue-1;

$maths_test_type = 5;
$maths_test_question = "What comes before : ".$randValue." = ";
$maths_test_answer = $randValuebefore;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


#TYPE-6

$randValue = rand(10,100);
$randValuebefore = $randValue+1;

$maths_test_type = 6;
$maths_test_question = "What comes after : ".$randValue." = ";
$maths_test_answer = $randValuebefore;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


			   
			   
//echo $create_test;			   
//exit;
/* CREATE TEST # END */

header("Location: write-maths-test.php?test_id=$maths_test_id")
?>