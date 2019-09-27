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

if(isset($_REQUEST['id']))
{
    $studId = $_REQUEST['id'];
    if(isset($_REQUEST['examid']))
    {
        $examid = $_REQUEST['examid'];
    }
    else
    {
        header("Location: result.php?err=1");
    }
}
else
{
    header("Location: result.php?err=1");
}

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$studId'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

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

$student_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where gen.user_id='$studId'");
$student_fet = mysql_fetch_assoc($student_exe);

$exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 AND (class_id='$classId' OR class_id='100') GROUP BY exam_name";
$exam_exe=mysql_query($exam_sql);
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
                <li><a href="student-mark-list.php?classid=<?php echo $classId;?>&sectionname=<?php echo $sectionName;?>&examid=<?php echo $examid;?>">Student Mark List</a></li>
                <li>Student Result</li>
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
                            <table class="table table-bordered datatable">
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

                                <tr>
                                    <td>1</td>
                                    <td><a href="student-result.php?id=<?php echo $student_fet['user_id']; ?>&examid=<?php echo $examid; ?>" style="color: black;"><?php echo $student_fet['student_name']; ?></a></td>
                                    <td><?php echo $student_fet['admission_number']; ?></td>
                                    <?php
                                    $total = 0;
                                    for($i =0; $i< $sub_count; $i++){
                                        $sub = $subject[$i];
                                        ?>
                                        <td>
                                            <?php
                                            $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$studId' and subject_name='$sub'"));
                                            echo $mark_sql['mark'];
                                            $mark = $mark_sql['mark'];
                                            $total = $total + $mark;
                                            ?>
                                        </td>
                                    <?php }?>
                                    <td><?php if($entered_sub_cnt>0){  echo $total; }?></td>
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
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        $remark_sql = mysql_query("select remarks, subject_name from student_mark where exam_id='$examid' and student_id='$studId'");
                                        while($remark_fet = mysql_fetch_array($remark_sql)){
                                            if(!empty($remark_fet['remarks'])){
                                                echo "<b>" . $remark_fet['subject_name'] . ":</b>" . $remark_fet['remarks'] . "\n";
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            </br>

                            <div id="columnchart_material" style="margin-left: 30px; height: 370px; width: 90%;"></div>
                            </br>

                            <div class="row" style="padding-left: 20px;">
                                <?php
                                while($exam_fet = mysql_fetch_array($exam_exe)){
                                    ?>
                                    <div class="col-md-2">
                                        <?php if($exam_fet['id'] == $examid){
                                        ?>
                                        <a href="student-result.php?id=<?php echo $studId; ?>&examid=<?php echo $examid; ?>" style="color: black;">
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <a href="student-exam-result.php?id=<?php echo $studId; ?>&examid=<?php echo $examid; ?>&compexamid=<?php echo $exam_fet['id'];?>" style="color: black;">
                                                <?php
                                                }
                                                ?>
                                                <input type="button" class="btn btn-info form-control examBtn" exam="<?php echo $examid;?>" rel="<?php echo $exam_fet['id']; ?>" value="<?php echo $exam_fet['exam_name']; ?>"/>
                                            </a>
                                            <input type="hidden" class="studId" value="<?php echo $studId; ?>"/>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
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
<?php
$data[0][0] = "Subject";
$data[0][1] = "Mark";
$data[0][2] = "Top Mark";
$data[0][3] = "Average Mark";
for($i =0; $i< $sub_count; $i++){
    $data[$i+1][0] = $subject[$i];

    $sub = $subject[$i];
    $mark_sql = mysql_fetch_assoc(mysql_query("select mark from student_mark where exam_id='$examid' and student_id='$studId' and subject_name='$sub'"));
    $data[$i+1][1] = $mark_sql['mark'];

    $topmark_sql = mysql_fetch_assoc(mysql_query("select max(mark) as top_mark, min(mark) as low_mark, FLOOR(AVG(mark)) as avg_mark from student_mark where exam_id='$examid' and subject_name='$sub' and classid='$classId' and section_name='$sectionName'"));
    $data[$i+1][2] = $topmark_sql['top_mark'];
    $data[$i+1][3] = $topmark_sql['avg_mark'];
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
                title: 'Mark Result'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>


</body>
</html>
