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
        <th></th>
        <th colspan="3" style="text-align: center;">Roll</th>
        <th colspan="6" style="text-align: center;">Present</th>
        <th colspan="6" style="text-align: center;">Absent</th>
    </tr>
    <tr>
        <th style="border-right: 1px solid black;">Class</th>
        <th>Boys</th>
        <th>Girls</th>
        <th style="border-right: 1px solid black;">Total</th>
        <th colspan="2" style="text-align: center;">Boys</th>
        <th colspan="2" style="text-align: center;">Girls</th>
        <th colspan="2" style="border-right: 1px solid black; text-align: center;">Total</th>
        <th colspan="2" style="text-align: center;">Boys</th>
        <th colspan="2" style="text-align: center;">Girls</th>
        <th colspan="2" style="text-align: center;">Total</th>
    </tr>
    <tr>
        <th style="border-right: 1px solid black;"></th>
        <th></th>
        <th></th>
        <th style="border-right: 1px solid black;"></th>
        <th>FN</th>
        <th>AN</th>
        <th>FN</th>
        <th>AN</th>
        <th>FN</th>
        <th style="border-right: 1px solid black;">AN</th>
        <th>FN</th>
        <th>AN</th>
        <th>FN</th>
        <th>AN</th>
        <th>FN</th>
        <th>AN</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($class_master_results as $key => $value){
        $className = $value['class_name'];
        $classId = $value['id'];

        $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
        $section_exe=mysql_query($section_sql);
        $section_results = array();
        while($row = mysql_fetch_assoc($section_exe)) {
            array_push($section_results, $row);
        }

        foreach ($section_results as $sec_key => $sec_value) {
            $sectionName = $sec_value['section_name'];
            $sectionId = $sec_value['id'];

            $fnattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and fn_entry_status=1"));
            $anattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and an_entry_status=1"));
            $hr = date('H');
            if ($hr < 12) {
                if($fnattendance_cnt > 0)
                {
                    $attendance_row="red";
                    $att_bold ="bold";
                }
                else{
                    $attendance_row="black";
                    $att_bold ="none";
                }
            }
            elseif ($hr > 12 && $hr < 24){
                if($anattendance_cnt > 0)
                {
                    $attendance_row="red";
                    $att_bold ="bold";
                }
                else{
                    $attendance_row="black";
                    $att_bold ="none";
                }
            }
            ?>
            <tr>
                <td style="border-right: 1px solid black;">
                    <a href="students-absent-list.php?classId=<?php echo $classId;?>&sectionName=<?php echo $sectionName;?>" style="color:<?php echo $attendance_row; ?>; font-weight: <?php echo $att_bold; ?>" ><?php echo $className . " " . $sectionName; ?></a>
                </td>
                <td>
                    <?php
                    $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1'"));
                    echo $fet1['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1'"));
                    echo $fet2['student_count'];
                    ?>
                </td>
                <td style="border-right: 1px solid black;">
                    <?php
                    $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1'"));
                    echo $fet3['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                    echo $fet1['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                    echo $fet1['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                    echo $fet2['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                    echo $fet2['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
                    echo $fet3['student_count'];
                    ?>
                </td>
                <td style="border-right: 1px solid black;">
                    <?php
                    $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
                    echo $fet3['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $boys_absent_fn_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                    echo $boys_absent_fn_fet['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $boys_absent_an_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                    echo $boys_absent_an_fet['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $girls_absent_fn_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                    echo $girls_absent_fn_fet['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $girls_absent_an_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                    echo $girls_absent_an_fet['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $fn_absent_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
                    echo $fn_absent_fet['student_count'];
                    ?>
                </td>
                <td>
                    <?php
                    $an_absent_fet = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
                    echo $an_absent_fet['student_count'];
                    ?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    <tr>
        <th style="border-right: 1px solid black;">Grand Total</th>
        <td>
            <?php
            $grand_boy_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Male'"));
            echo $grand_boy_fet['boys_count'];
            ?>
        </td>
        <td>
            <?php
            $grand_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Female'"));
            echo $grand_girls_fet['girls_count'];
            ?>
        </td>
        <td style="border-right: 1px solid black;">
            <?php
            $grand_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1'"));
            echo $grand_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $present_boys_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date' and gen.gender='Male'"));
            echo $present_boys_fet['boys_count'];
            ?>
        </td>
        <td>
            <?php
            $present_boys_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date' and gen.gender='Male'"));
            echo $present_boys_fet['boys_count'];
            ?>
        </td>
        <td>
            <?php
            $present_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date' and gen.gender='Female'"));
            echo $present_girls_fet['girls_count'];
            ?>
        </td>
        <td>
            <?php
            $present_girls_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date' and gen.gender='Female'"));
            echo $present_girls_fet['girls_count'];
            ?>
        </td>
        <td>
            <?php
            $present_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='on' and att.attendance_date='$date'"));
            echo $present_fet['student_count'];
            ?>
        </td>
        <td style="border-right: 1px solid black;">
            <?php
            $present_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='on' and att.attendance_date='$date'"));
            echo $present_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $boys_fn_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and gen.gender='Male' and att.attendance_date='$date'"));
            echo $boys_fn_absent_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $boys_an_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and gen.gender='Male' and att.attendance_date='$date'"));
            echo $boys_an_absent_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $girls_fn_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and gen.gender='Female' and att.attendance_date='$date'"));
            echo $girls_fn_absent_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $girls_an_absent_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and gen.gender='Female' and att.attendance_date='$date'"));
            echo $girls_an_absent_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $absent_fn_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.forenoon='off' and att.attendance_date='$date'"));
            echo $absent_fn_fet['student_count'];
            ?>
        </td>
        <td>
            <?php
            $absent_an_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN attendance as att on att.user_id = gen.user_id LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and att.afternoon='off' and att.attendance_date='$date'"));
            echo $absent_an_fet['student_count'];
            ?>
        </td>
    </tr>
    </tbody>

</table>
