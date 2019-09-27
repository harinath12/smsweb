<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

if (isset($_GET['examid'])){
    $examid = $_GET['examid'];
    if (isset($_GET['classid'])){
        $classId = $_GET['classid'];
        if (isset($_GET['sectionname'])){
            $sectionName = $_GET['sectionname'];
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

$entered_sub_cnt = 0;
$entered_sub_exe = mysql_query("select distinct subject_name from student_mark where exam_id='$examid' and (classid = '$classId' or classid='100') and section_name='$sectionName'");
if($entered_sub_exe){
    $entered_sub_cnt = mysql_num_rows($entered_sub_exe);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
    <style>
        .req{
            color: red;
        }
    </style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Result
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="result.php">Result</a></li>
                <li class="active">Student Mark List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">

                        <div class="box-body" id="predate">
                            <h4>
                                <b>
                                    <?php
                                    $ex_fet = mysql_fetch_array(mysql_query("Select * from exam_time_table where id='$examid'"));
                                    echo $ex_fet['exam_name'];
                                    ?>
                                </b>
                            </h4>

                            <form action="#" method="post">
                                <div id="subject_graph" style="margin-left: 30px; height: 370px; width: 90%;"></div>
                                </br>

                                <div id="total_graph" style="margin-left: 30px; height: 370px; width: 50%;"></div>
                                </br>

                                <div id="grade_graph" style="margin-left: 30px; height: 370px; width: 90%;"></div>
                                </br>

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
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $sno++;
                                    }
                                    ?>
                                </table>
                            </form>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<!-- page script -->

<?php
$data[0][0] = "Subject";
$data[0][1] = "Top Mark";
$data[0][2] = "Average Mark";
$data[0][3] = "Low Mark";
for($i =0; $i< $sub_count; $i++){
    $data[$i+1][0] = $subject[$i];

    $sub = $subject[$i];

    $topmark_sql = mysql_fetch_assoc(mysql_query("select max(mark) as top_mark, min(mark) as low_mark, FLOOR(AVG(mark)) as avg_mark from student_mark where exam_id='$examid' and subject_name='$sub' and classid='$classId' and section_name='$sectionName'"));
    $data[$i+1][1] = $topmark_sql['top_mark'];
    $data[$i+1][2] = $topmark_sql['avg_mark'];
    $data[$i+1][3] = $topmark_sql['low_mark'];
}
?>

<script type="text/javascript" src="../teacher/js/chartloader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>);
        var options = {
            chart: {
                title: 'Subject Graph'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('subject_graph'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<?php
function minval($array){
    $min = 100;//max value you expect
    for($i=0; $i<sizeof($array); $i++){
        if($array[$i] < $min && $array[$i] != null)
            $min = $array[$i];
    }
    return $min;
}

function avgval($array){
    $avg = 0;//max value you expect
    for($i=0; $i<sizeof($array); $i++){
        if($array[$i] != 0)
            $avg++;
    }
    return $avg;
}

$dat[0][0] = "Total";
$dat[0][1] = "Top Total";
$dat[0][2] = "Average Total";
$dat[0][3] = "Low Total";

$stud_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");
while($stud_fet = mysql_fetch_assoc($stud_exe)) {
    $stud_id = $stud_fet['user_id'];
    $total = 0;
    for($i =0; $i< $sub_count; $i++){
        $sub = $subject[$i];
        $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
        $mark = $mark_sql['mark'];
        $total = $total + $mark;
    }
    $tot[] = $total;
}

$max_tot = max($tot);
$min_tot = minval($tot);
$avg_tot = ceil(array_sum($tot)/avgval($tot));

$dat[1][0] = "Total";
$dat[1][1] = $max_tot;
$dat[1][2] = $avg_tot;
$dat[1][3] = $min_tot;
?>

<script type="text/javascript" src="../teacher/js/chartloader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dat, JSON_NUMERIC_CHECK); ?>);
        var options = {
            chart: {
                title: 'Overall Graph'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('total_graph'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<?php
function avg_count($array, $minnum, $maxnum){
    $a = 0;//max value you expect
    for($i=0; $i<sizeof($array); $i++){
        if($array[$i] > $minnum && $array[$i] <= $maxnum)
            $a++;
    }
    return $a;
}

$dat[0][0] = "Grade";
$dat[0][1] = "A1";
$dat[0][2] = "A2";
$dat[0][3] = "B1";
$dat[0][4] = "B2";
$dat[0][5] = "C1";
$dat[0][6] = "C2";
$dat[0][7] = "D";
$dat[0][8] = "E1";
$dat[0][9] = "E2";

$stud_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");
while($stud_fet = mysql_fetch_assoc($stud_exe)) {
    $stud_id = $stud_fet['user_id'];
    $total = 0;
    for($i =0; $i< $sub_count; $i++){
        $sub = $subject[$i];
        $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
        $mark = $mark_sql['mark'];
        $total = $total + $mark;
    }
    $avg = $total / $entered_sub_cnt;
    $avrg[] = $avg;
}

$a1_grade = avg_count($avrg,90,100);
$a2_grade = avg_count($avrg,80,90);
$b1_grade = avg_count($avrg,70,80);
$b2_grade = avg_count($avrg,60,70);
$c1_grade = avg_count($avrg,50,60);
$c2_grade = avg_count($avrg,40,50);
$d_grade = avg_count($avrg,30,40);
$e1_grade = avg_count($avrg,20,30);
$e2_grade = avg_count($avrg,0,20);

$dat[1][0] = "Grades";
$dat[1][1] = $a1_grade;
$dat[1][2] = $a2_grade;
$dat[1][3] = $b1_grade;
$dat[1][4] = $b2_grade;
$dat[1][5] = $c1_grade;
$dat[1][6] = $c2_grade;
$dat[1][7] = $d_grade;
$dat[1][8] = $e1_grade;
$dat[1][9] = $e2_grade;
?>

<script type="text/javascript" src="../teacher/js/chartloader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($dat, JSON_NUMERIC_CHECK); ?>);
        var options = {
            chart: {
                title: 'GradeWise Graph'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('grade_graph'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>


</body>
</html>
