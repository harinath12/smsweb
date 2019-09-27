<?php session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
if(isset($_GET['from'])){
    $fDate = $_GET['from'];
    if (isset($_GET['to'])){
        $tDate = $_GET['to'];
    }
    else{
        $tDate = date("Y-m-d");
    }
}
else{
    $fDate = date("Y-m-d", strtotime( '-30 days' ) );
    $tDate = date("Y-m-d");
}

$attendance_sql = "SELECT att.*, usr.`name` FROM attendance AS att
LEFT JOIN users AS usr ON usr.id = att.`user_id`
WHERE usr.`delete_status` = 1 and att.user_id='$user_id' and (att.attendance_date between '$fDate' and '$tDate')";
$attendance_exe = mysql_query($attendance_sql);
$attendance_cnt = mysql_num_rows($attendance_exe);
?>
<table class="table">
    <tr>
        <th>Date</th>
        <th>Student Name</th>
        <th>Forenoon</th>
        <th>Afternoon</th>
        <th>Remarks</th>
    </tr>
    <?php
    if($attendance_cnt>0) {
        while ($fet1 = mysql_fetch_assoc($attendance_exe)) {
            ?>
            <tr>
                <td><?php echo $fet1['attendance_date']; ?></td>
                <td><?php echo $fet1['name']; ?></td>
                <td><?php if ($fet1['forenoon'] == 'on') {
                        echo 'Present';
                    } else {
                        echo 'Absent';
                    } ?></td>
                <td><?php if ($fet1['afternoon'] == 'on') {
                        echo 'Present';
                    } else {
                        echo 'Absent';
                    } ?></td>
                <td><?php echo $fet1['remarks']; ?></td>
            </tr>
        <?php
        }
    }
    else{
        ?>
        <tr>
            <td colspan="4">No records Found.</td>
        </tr>
    <?php
    }
    ?>
</table>
