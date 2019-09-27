<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['test_id']))
{
    $test_id = $_REQUEST['test_id'];
}
else
{
    header("Location: report-self-test.php?error=1");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from self_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");

$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);



$daily_test_question_sql = "SELECT * FROM `self_test_question` WHERE `daily_test_id`='$test_id'";

$daily_test_question_exe = mysql_query($daily_test_question_sql);


while($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe))
{
    $questionbank_id_array[] = $daily_test_question_fetch['question_id'];
}

$questionbank_id=implode(",",$questionbank_id_array);



$ques_sql = "select * from self_test_answer where daily_test_id='$test_id' group by student_id order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
                <li><a href="report-self-test.php">Self Test Report</a></li>
                <li class="active">Self Test Report View</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- basic datatable -->
                <div class="panel panel-flat">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4">Class</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">Subject</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4">Test Name</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $ques_bank_fet['daily_test_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4">Remarks</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $ques_bank_fet['daily_test_remark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <!-- basic datatable -->
                            <div class="panel panel-flat">
                                </br>
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>STUDENT NAME</th>
                                        <th>TEST NAME</th>
                                        <th>MARK"S</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if($ques_cnt>0)
                                    {
                                        ?>
                                        <tbody>
                                        <?php
                                        $i =1;
                                        while($ques_fet=mysql_fetch_array($ques_exe))
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <?php
                                                    $student_id=$ques_fet['student_id'];
                                                    $student_query="SELECT name FROM `users` WHERE `id`='$student_id'";
                                                    $student_query_exe=mysql_query($student_query);
                                                    $student_query_fet=mysql_fetch_assoc($student_query_exe);

                                                    echo $student_query_fet['name'];
                                                    ?>
                                                </td>
                                                <td><?php echo $ques_fet['daily_test_name'] ?></td>
                                                <td>
                                                    <?php
                                                    $std_ques_sql = "select * from self_test_answer where daily_test_id='$test_id' AND `student_id`='$student_id' order by id asc";
                                                    $std_ques_exe = mysql_query($std_ques_sql);

                                                    /*
                                                    while($std_ques_fet=mysql_fetch_array($std_ques_exe))
                                                        {
                                                            $std_ques_id[]=$std_ques_fet['id'];
                                                        }
                                                    $daily_test_answer_id=implode(',',$std_ques_id);
                                                    echo $mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id` IN($daily_test_answer_id) AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
                                                    */

                                                    while($std_ques_fet=mysql_fetch_array($std_ques_exe))
                                                    {
                                                        $daily_test_answer_id=$std_ques_fet['id'];

                                                        $mark_query="SELECT SUM(daily_test_mark) AS mark FROM `self_test_question_answer` WHERE `daily_test_answer_id`='$daily_test_answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
                                                        $mark_query_exe=mysql_query($mark_query);
                                                        $mark_query_fet=mysql_fetch_assoc($mark_query_exe)
                                                        ?>
                                                        <a href="report-self-test-answer-view.php?test_id=<?php echo $test_id; ?>&answer_id=<?php echo $daily_test_answer_id; ?>" title="<?php echo $std_ques_fet['created_at']; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><?php echo $mark_query_fet['mark']; ?> </button>
                                                        </a>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td class="text-center">
                                                    <ul class="icons-list">
                                                        <li><a href="overall-report-self-test-answer-view.php?test_id=<?php echo $test_id; ?>&student_id=<?php echo $student_id; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View Overall Report</button></a></li>&nbsp;&nbsp;
                                                    </ul>

                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /basic datatable -->

                        </div>
                    </div>
                </div>
                <!-- /basic datatable -->

            </div>
        </div>
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

</body>
</html>
