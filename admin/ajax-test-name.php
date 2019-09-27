<?php
include "config.php";

if (isset($_GET['cid'])) {
    $classId = $_GET['cid'];
	$subjectId = $_GET['subid'];
    $test_sql = mysql_query("select q.*, c.class_name from daily_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' and subject_name='$subjectId' and class_id IN ($classId) order by id desc");
    
	$test_results = array();
    while($row = mysql_fetch_assoc($test_sql)) {
        $test_results[] = array(
            'testid' => $row['id'],
            'testname' => $row['daily_test_name']
        );
    }
    //echo $test_results;
    echo json_encode($test_results);
}
?>
