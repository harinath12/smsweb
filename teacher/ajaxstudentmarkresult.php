<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['examid'])){
    $examid = $_GET['examid'];
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$student_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");

$sub_sql = "SELECT distinct subject_name FROM exam_date_subject WHERE exam_id = '$examid' and (class_id = '$classId' or class_id='100')";
$sub_exe = mysql_query($sub_sql);
while($sub_fet = mysql_fetch_assoc($sub_exe)){
    $subject[] = $sub_fet['subject_name'];
}
$sub_count = count($subject);

$entered_sub_cnt = 0;
$entered_sub_exe = mysql_query("select distinct subject_name from student_mark where exam_id='$examid' and (classid = '$classId' or classid='100') and section_name='$sectionName'");
if($entered_sub_exe){
    $entered_sub_cnt = mysql_num_rows($entered_sub_exe);
}

?>

<div class="panel-body" style="overflow-x: scroll; margin: 0px 10px;">
    <h4 style="font-weight: bold; text-align: center;">Student List</h4>
    <table class="table table-bordered datatable1">
        <tr>
            <th>S.No.</th>
            <th>Student Name</th>
            <th>Admission Number</th>
            <?php for($i =0; $i< $sub_count; $i++){ ?>
                <th><?php echo $subject[$i]; ?></th>
            <?php }?>
            <th>Total</th>
            <th>Grade</th>
            <th>Remarks</th>
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
                <td><?php if($entered_sub_cnt>0){ echo $total; }?></td>
                <td>
                    <?php if($entered_sub_cnt>0){
                        ?>
                        <b>
                            <?php
                            $avg = $total / $entered_sub_cnt;
                            if($avg > '90'){
                                echo "A1";
                            }
                            else if($avg > '80'){
                                echo "A2";
                            }
                            else if($avg > '70'){
                                echo "B1";
                            }
                            else if($avg > '60'){
                                echo "B2";
                            }
                            else if($avg > '50'){
                                echo "C1";
                            }
                            else if($avg > '40'){
                                echo "C2";
                            }
                            else if($avg > '30'){
                                echo "D";
                            }
                            else if($avg > '20'){
                                echo "E1";
                            }
                            else{
                                echo "E2";
                            }
                            ?>
                        </b>
                    <?php
                    }
                    ?>
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
            </tr>
            <?php
            $sno++;
        }
        ?>
    </table>
</div>