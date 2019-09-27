<?php
include "config.php";

if (isset($_GET['cid'])) {
    $class = $_GET['cid'];

    $class_sql = "SELECT * FROM `classes` WHERE `class_name`='$class'";
    $class_exe = mysql_query($class_sql);
    $class_fet = mysql_fetch_assoc($class_exe);
    $cid = $class_fet['id'];

    $exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 AND (class_id='$cid' OR class_id='100') GROUP BY exam_name";
    $exam_exe=mysql_query($exam_sql);
    $exam_results = array();
    while($row = mysql_fetch_assoc($exam_exe)) {
        $exam_results[] = array(
            'exam_id' => $row['id'],
            'exam_name' => $row['exam_name']
        );
    }
    echo json_encode($exam_results);


}
?>
