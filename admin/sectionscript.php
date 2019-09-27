<?php
include "config.php";

if (isset($_GET['region'])) {
    $region = $_GET['region'];
    $sec_sql = "SELECT cs.* FROM class_section as cs WHERE class_id = $region order by cs.section_name ASC";
    $sec_exe = mysql_query($sec_sql);
    $sec_results = array();
    while($row = mysql_fetch_assoc($sec_exe)) {
        $sec_results[] = array(
            'secid' => $row['id'],
            'secname' => $row['section_name']
        );
    }
    //echo $sec_results;
    echo json_encode($sec_results);

}

else if (isset($_GET['cls'])) {
    $className = $_GET['cls'];
    $sec_sql = "SELECT cs.* FROM class_section as cs
LEFT JOIN classes as c on c.id = cs.class_id
WHERE c.class_name = '$className' order by cs.id ASC";
    $sec_exe = mysql_query($sec_sql);
    $sec_results = array();
    while($row = mysql_fetch_assoc($sec_exe)) {
        $sec_results[] = array(
            'secid' => $row['id'],
            'secname' => $row['section_name']
        );
    }
    echo json_encode($sec_results);

}
?>
