<?php
include "config.php";

if(isset($_GET['studid']) ) {
    $studid = $_GET['studid'];
    $cnt = count($studid);
    $name = NULL;

    for($i =0 ; $i<$cnt; $i++){
        $id = $studid[$i];
        if($id != 'all'){
            $stud_sql = mysql_query("SELECT student_name from student_general where user_id='$id'");
            $stud_fet = mysql_fetch_array($stud_sql);
            if($i == 0){
                $name = $stud_fet['student_name'];
            }
            else{
                $name = $name . ", " .  $stud_fet['student_name'];
            }
        }
        else{
            if($i == 0){
                $name = 'All';
            }
            else{
                $name = $name . ", " .  $stud_fet['student_name'];
            }
        }
    }

    echo $name;
}
?>
