<?php session_start();
ob_start();

include "config.php";

if (isset($_GET['dat'])){
    $date = $_GET['dat'];
}
else{
    $date = date("Y-m-d");
}

$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}
?>

<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th>Class</th>
        <th>Attendance Details</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($class_master_results as $key => $value){
        $className = $value['class_name'];
        $classId = $value['id'];

        $section_sql="SELECT s.* FROM `class_section` as cs LEFT JOIN section as s on s.id = cs.section_id where s.section_status=1 and cs.class_id='$classId'";
        $section_exe=mysql_query($section_sql);
        $section_results = array();
        while($row = mysql_fetch_assoc($section_exe)) {
            array_push($section_results, $row);
        }

        foreach ($section_results as $sec_key => $sec_value) {
            $sectionName = $sec_value['section_name'];
            $sectionId = $sec_value['id'];
            ?>
            <tr>
                <td><?php echo $className . " " . $sectionName; ?></td>
                <td>
                    <?php
                    $attendance_sql = "SELECT att.*, usr.`name` FROM attendance AS att
LEFT JOIN users AS usr ON usr.id = att.`user_id`
WHERE usr.`delete_status` = 1 and class_id='$classId' and section_id='$sectionId' and att.attendance_date='$date'";
                    $attendance_exe = mysql_query($attendance_sql);
                    $attendance_cnt = mysql_num_rows($attendance_exe);
                    if($attendance_cnt > 0) {
                        ?>
                        <table class="table">
                            <tr>
                                <th>Student Name</th>
                                <th>Forenoon</th>
                                <th>Afternoon</th>
                                <th>Remarks</th>
                            </tr>
                            <?php
                            while ($fet1 = mysql_fetch_assoc($attendance_exe)) {
                                ?>
                                <tr>
                                    <td><?php echo $fet1['name'];?></td>
                                    <td><?php if ($fet1['forenoon'] == 'on') {
                                            echo 'Present';
                                        } else {
                                            echo 'Absent';
                                        }?></td>
                                    <td><?php if ($fet1['afternoon'] == 'on') {
                                            echo 'Present';
                                        } else {
                                            echo 'Absent';
                                        }?></td>
                                    <td><?php echo $fet1['remarks'];?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>

</table>
