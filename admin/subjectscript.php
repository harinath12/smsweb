<?php
include "config.php";

if (isset($_GET['cid'])) {
    $class = $_GET['cid'];
    $sec_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$class'";
    $sec_exe = mysql_query($sec_sql);
    $sec_results = array();
    while($row = mysql_fetch_assoc($sec_exe)) {
        $sec_results[] = array(
            'subid' => $row['id'],
            'subname' => $row['subject_name']
        );
    }
    //echo $sec_results;
    echo json_encode($sec_results);

}
?>
