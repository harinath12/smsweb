<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['examid'])){
    $examid = $_GET['examid'];
    if (isset($_GET['cid'])){
        $classId = $_GET['cid'];
        if (isset($_GET['sec'])){
            $sectionName = $_GET['sec'];
        }
        else{
            exit;
        }
    }
    else{
        exit;
    }
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");

$subject = null;
$sub_sql = "SELECT distinct subject_name FROM exam_date_subject WHERE exam_id = '$examid' and (class_id = '$classId' or class_id='100')";
$sub_exe = mysql_query($sub_sql);
while($sub_fet = mysql_fetch_assoc($sub_exe)){
    $subject[] = $sub_fet['subject_name'];
}
$sub_count = count($subject);

?>

<div class="panel-body" style="overflow-x: scroll;">
    <table class="table table-bordered datatable">
        <tr>
            <th>S.No.</th>
            <th>Student Name</th>
            <th>Admission Number</th>
            <?php if($sub_count > 0){
                ?>
                <?php for($i =0; $i< $sub_count; $i++){ ?>
                    <th><?php echo $subject[$i]; ?></th>
                <?php }?>
                <th>Total</th>
                <th>Grade</th>
                <th>Remarks</th>
            <?php } ?>
        </tr>
        <?php
        $sno =1;
        while($student_fet = mysql_fetch_assoc($student_exe)){
            $stud_id = $student_fet['user_id'];
            ?>
            <tr>
                <td><?php echo $sno; ?></td>
                <td><a href="student-result.php?id=<?php echo $student_fet['user_id']; ?>&examid=<?php echo $examid; ?>" style="color: black;"><?php echo $student_fet['student_name']; ?></a></td>
                <td><?php echo $student_fet['admission_number']; ?></td>
                <?php if($sub_count > 0){
                    ?>
                    <?php
                    $total = 0;
                    for($i =0; $i< $sub_count; $i++){
                        $sub = $subject[$i];
                        ?>
                        <td>
                            <?php
                            $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
                            echo $mark_sql['mark'];
                            $mark = $mark_sql['mark'];
                            $total = $total + $mark;
                            ?>
                        </td>
                    <?php }?>
                    <td><?php echo $total;?></td>
                    <td>
                        <b>
                            <?php
                            $avg = $total / $sub_count;
                            if($avg >= '90'){
                                echo "A+";
                            }
                            else if($avg >= '80'){
                                echo "A";
                            }
                            else if($avg >= '70'){
                                echo "B";
                            }
                            else if($avg >= '60'){
                                echo "C";
                            }
                            else if($avg >= '50'){
                                echo "D";
                            }
                            else if($avg >= '40'){
                                echo "E";
                            }
                            else{
                                echo "F";
                            }
                            ?>
                        </b>
                    </td>
                    <td>
                        <?php
                        $remark_sql = mysql_query("select remarks, subject_name from student_mark where exam_id='$examid' and student_id='$stud_id'");
                        while($remark_fet = mysql_fetch_array($remark_sql)){
                            if(!empty($remark_fet['remarks'])){
                                echo "<b>" . $remark_fet['subject_name'] . ":</b>" . $remark_fet['remarks'] . "\n";
                            }
                        }
                        ?>
                    </td>
                <?php } ?>
            </tr>
            <?php
            $sno++;
        }
        ?>
    </table>
</div>

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({

            });
        });
    });
</script>