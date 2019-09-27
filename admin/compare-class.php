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

$examid = $_REQUEST['examName'];
$comparecls = $_REQUEST['comparecls'];
$cnt = count($comparecls);
//echo $comparecls[0];

for($i =0;$i<$cnt; $i++){
    $comp = $comparecls[$i];
    $classsectionsql = mysql_query("select cs.*, c.class_name from class_section as cs
    left join classes as c on c.id = cs.class_id
    where class_section_status=1 and cs.id='$comp'");
    $classsectionfet = mysql_fetch_assoc($classsectionsql);
    $class_name[$i] = $classsectionfet['class_name'];
    $class_id[$i] = $classsectionfet['class_id'];
    $section_name[$i] = $classsectionfet['section_name'];
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
                <li><a href="result.php"> Result</a></li>
                <li><a href="compare-class-result.php"> Compare Class</a></li>
                <li class="active">Compare Class Result</li>
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

                            </form>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<?php
$subject = null;
$sub_sql = "SELECT distinct subject_name FROM exam_date_subject WHERE exam_id = '$examid' and (class_id = '$class_id[0]' or class_id='100' or class_id='$class_id[1]')";
$sub_exe = mysql_query($sub_sql);
while($sub_fet = mysql_fetch_assoc($sub_exe)){
    $subject[] = $sub_fet['subject_name'];
}
$sub_count = count($subject);

$data[0][0] = "Subject";
$data[0][1] = $class_name[0] . " " . $section_name[0];
$data[0][2] = $class_name[1] . " " . $section_name[1];

for($i =0; $i< $sub_count; $i++){
    $data[$i+1][0] = $subject[$i];

    $sub = $subject[$i];

    $topmark_sql1 = mysql_fetch_assoc(mysql_query("select max(mark) as top_mark from student_mark where exam_id='$examid' and subject_name='$sub' and classid='$class_id[0]' and section_name='$section_name[0]'"));
    $topmark_sql2 = mysql_fetch_assoc(mysql_query("select max(mark) as top_mark from student_mark where exam_id='$examid' and subject_name='$sub' and classid='$class_id[1]' and section_name='$section_name[1]'"));
    $data[$i+1][1] = $topmark_sql1['top_mark'];
    $data[$i+1][2] = $topmark_sql2['top_mark'];
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
                title: 'Subject Toppers'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('subject_graph'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<?php
$total_data[0][0] = "Total";
$total_data[0][1] = $class_name[0] . " " . $section_name[0];
$total_data[0][2] = $class_name[1] . " " . $section_name[1];

$stud_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$class_id[0]' and aca.section_name='$section_name[0]' and delete_status='1'");
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

$stud_exe1 = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$class_id[1]' and aca.section_name='$section_name[1]' and delete_status='1'");
while($stud_fet1 = mysql_fetch_assoc($stud_exe1)) {
    $stud_id = $stud_fet1['user_id'];
    $total = 0;
    for($i =0; $i< $sub_count; $i++){
        $sub = $subject[$i];
        $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
        $mark = $mark_sql['mark'];
        $total = $total + $mark;
    }
    $tot[] = $total;
}
$max_tot1 = max($tot);

$total_data[1][0] = "Total";
$total_data[1][1] = $max_tot;
$total_data[1][2] = $max_tot1;
?>

<script type="text/javascript" src="../teacher/js/chartloader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($total_data, JSON_NUMERIC_CHECK); ?>);
        var options = {
            chart: {
                title: 'Class Toppers'
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

$grade_dat[0][0] = "Grade";
$grade_dat[0][1] = $class_name[0] . " " . $section_name[0];
$grade_dat[0][2] = $class_name[1] . " " . $section_name[1];

$entered_sub_cnt = 0;
$entered_sub_exe = mysql_query("select distinct subject_name from student_mark where exam_id='$examid' and (classid = '$class_id[0]' or classid='100') and section_name='$section_name[0]'");
if($entered_sub_exe){
    $entered_sub_cnt = mysql_num_rows($entered_sub_exe);
}
$stud_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$class_id[0]' and aca.section_name='$section_name[0]' and delete_status='1'");
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

$entered_sub_cnt = 0;
$entered_sub_exe = mysql_query("select distinct subject_name from student_mark where exam_id='$examid' and (classid = '$class_id[1]' or classid='100') and section_name='$section_name[1]'");
if($entered_sub_exe){
    $entered_sub_cnt = mysql_num_rows($entered_sub_exe);
}
$stud_exe1 = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$class_id[1]' and aca.section_name='$section_name[1]' and delete_status='1'");
while($stud_fet1 = mysql_fetch_assoc($stud_exe1)) {
    $stud_id = $stud_fet1['user_id'];
    $total = 0;
    for($i =0; $i< $sub_count; $i++){
        $sub = $subject[$i];
        $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$stud_id' and subject_name='$sub'"));
        $mark = $mark_sql['mark'];
        $total = $total + $mark;
    }
    $avg = $total / $entered_sub_cnt;
    $avrg1[] = $avg;
}

$a1_grade1 = avg_count($avrg1,90,100);
$a2_grade1 = avg_count($avrg1,80,90);
$b1_grade1 = avg_count($avrg1,70,80);
$b2_grade1 = avg_count($avrg1,60,70);
$c1_grade1 = avg_count($avrg1,50,60);
$c2_grade1 = avg_count($avrg1,40,50);
$d_grade1 = avg_count($avrg1,30,40);
$e1_grade1 = avg_count($avrg1,20,30);
$e2_grade1 = avg_count($avrg1,0,20);

$grade_dat[1][0] = "A1";
$grade_dat[1][1] = $a1_grade;
$grade_dat[1][2] = $a1_grade1;

$grade_dat[2][0] = "A2";
$grade_dat[2][1] = $a2_grade;
$grade_dat[2][2] = $a2_grade1;

$grade_dat[3][0] = "B1";
$grade_dat[3][1] = $b1_grade;
$grade_dat[3][2] = $b1_grade1;

$grade_dat[4][0] = "B2";
$grade_dat[4][1] = $b2_grade;
$grade_dat[4][2] = $b2_grade1;

$grade_dat[5][0] = "C1";
$grade_dat[5][1] = $c1_grade;
$grade_dat[5][2] = $c1_grade1;

$grade_dat[6][0] = "C2";
$grade_dat[6][1] = $c2_grade;
$grade_dat[6][2] = $c2_grade1;

$grade_dat[7][0] = "D";
$grade_dat[7][1] = $d_grade;
$grade_dat[7][2] = $d_grade1;

$grade_dat[8][0] = "E1";
$grade_dat[8][1] = $e1_grade;
$grade_dat[8][2] = $e1_grade1;

$grade_dat[9][0] = "E2";
$grade_dat[9][1] = $e2_grade;
$grade_dat[9][2] = $e2_grade1;
?>

<script type="text/javascript" src="../teacher/js/chartloader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($grade_dat, JSON_NUMERIC_CHECK); ?>);
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
