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

<?php
$present_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as present_count FROM teacher_general AS si
RIGHT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date' and att.forenoon='on' and att.afternoon='on'
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));

$absent_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as absent_count FROM teacher_general AS si
RIGHT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date' and att.forenoon='off' and att.afternoon='off'
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));

$grand_fet = mysql_fetch_assoc(mysql_query("SELECT count(*) as grand_count FROM teacher_general AS si
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'"));
?>

<div class="row">
    <div class="col-md-3"><b>Num of Present:</b></div>
    <div class="col-md-3"><?php echo $present_fet['present_count']; ?></div>
</div>
<div class="row">
    <div class="col-md-3"><b>Num of Absent:</b></div>
    <div class="col-md-3"><?php echo $absent_fet['absent_count']; ?></div>
</div>
<div class="row">
    <div class="col-md-3"><b>Grand Total:</b></div>
    <div class="col-md-3"><?php echo $grand_fet['grand_count']; ?></div>
</div>
</br>
<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th>Teacher Name</th>
        <th>Class</th>
        <th>Forenoon</th>
        <th>Afternoon</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $attendance_sql = "SELECT users.name, att.*, aca.class_teacher  FROM teacher_general AS si
LEFT JOIN `teacher_attendance` AS att ON att.user_id = si.user_id AND att.attendance_date='$date'
LEFT JOIN teacher_academic AS aca ON aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
WHERE users.delete_status='1'";
    $attendance_exe = mysql_query($attendance_sql);
    $attendance_cnt = mysql_num_rows($attendance_exe);
    if($attendance_cnt > 0) {
        while ($fet1 = mysql_fetch_assoc($attendance_exe)) {
            ?>
            <tr>
                <td><?php echo $fet1['name'];?></td>
                <td><?php echo $fet1['class_teacher'];?></td>
                <td><?php if ($fet1['forenoon'] == 'on') {
                        echo 'Present';
                    } else if ($fet1['forenoon'] == 'off'){
                        echo 'Absent';
                    }?></td>
                <td><?php if ($fet1['afternoon'] == 'on') {
                        echo 'Present';
                    } else if ($fet1['afternoon'] == 'off') {
                        echo 'Absent';
                    }?></td>
                <td><?php echo $fet1['remarks'];?></td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>

</table>


