<?php
include "config.php";

if (isset($_GET['cid'])) {
    $class = $_GET['cid'];
    $sub = $_GET['sub'];
    $term = $_GET['term'];
    $chapter_sql = "SELECT * FROM chapter_master WHERE class_id = '$class' and subject='$sub' and term='$term'";
    $chapter_exe = mysql_query($chapter_sql);
    $chapter_results = array();
    while($row = mysql_fetch_assoc($chapter_exe)) {
        $chapter_results[] = array(
            'chapterid' => $row['id'],
            'chaptername' => $row['chapter']
        );
    }
    echo json_encode($chapter_results);


}
?>
