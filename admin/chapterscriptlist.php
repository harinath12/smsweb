<?php
include "config.php";

if((isset($_GET['cid'])) && (isset($_GET['sub'])) && (isset($_GET['term'])) ) {
    $class = $_GET['cid'];
    $subject = $_GET['sub'];
    $term = $_GET['term'];

    $chap_sql = "SELECT chapter,id FROM chapter_master WHERE class_id = '$class' and subject='$subject' and term='$term'";
    $chap_exe = mysql_query($chap_sql);
    $chap_results = array();
    while($row = mysql_fetch_assoc($chap_exe)) {
        $chap_results[] = array(
            'cid' => $row['chapter'],
			'cname' => $row['chapter']
        );
    }
    //echo $sec_results;
    echo json_encode($chap_results);

}
?>
