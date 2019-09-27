<?php
include "config.php";

if (isset($_GET['cid'])) {
    $classId = $_GET['cid'];
    $class_sql = mysql_query("SELECT * FROM classes WHERE id = '$classId'");
    $class_fet = mysql_fetch_assoc($class_sql);

    echo $class_fet['class_name'];
}
?>
