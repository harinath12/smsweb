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
    header("Location: report-aptitude-test.php?error=1");
}

if(isset($_REQUEST['answer_id']))
{
    $answer_id = $_REQUEST['answer_id'];
}
else
{
    header("Location: report-aptitude-test.php?error=1");
}


include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$ques_bank_sql = mysql_query("select qb.*, c.class_name from aptitude_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");

$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);



$daily_test_question_sql = "SELECT * FROM `aptitude_test_question` WHERE `daily_test_id`='$test_id'";

$daily_test_question_exe = mysql_query($daily_test_question_sql);


while($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe))
{
    $questionbank_id_array[] = $daily_test_question_fetch['question_id'];
}

$questionbank_id=implode(",",$questionbank_id_array);
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
	<style>
	p.red-color { color:red; }
	</style>

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
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="report-aptitude-test.php"> Aptitude Test Report</a></li>
                <li><a href="report-aptitude-test-answer.php?test_id=<?php echo $test_id; ?>">Aptitude Test Report View</a></li>
                <li class="active">Aptitude Test Report Answer</li>
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



                            <div class="form-group">
                                <label class="col-md-4">Student</label>
                                <div class="col-md-8">

                                    <?php
                                    $ans_query= "SELECT * FROM `aptitude_test_answer` WHERE `daily_test_id`='$test_id' AND `id`='$answer_id'";
                                    $ans_query_exe=mysql_query($ans_query);
                                    $ans_query_fet=mysql_fetch_assoc($ans_query_exe);



                                    $student_id=$ans_query_fet['student_id'];
                                    $student_query="SELECT name FROM `users` WHERE `id`='$student_id'";
                                    $student_query_exe=mysql_query($student_query);
                                    $student_query_fet=mysql_fetch_assoc($student_query_exe);
                                    ?>

                                    <input type="text" value="<?php echo $student_query_fet['name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
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

                            <div class="form-group">
                                <label class="col-md-4">Mark</label>
                                <div class="col-md-8">

                                    <?php
									
									$mark_question_query="SELECT COUNT(daily_test_mark) AS mark FROM `aptitude_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
									$mark_question_query_exe=mysql_query($mark_question_query);
									$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
									
                                    $mark_query="SELECT SUM(daily_test_mark) AS mark FROM `aptitude_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
                                    $mark_query_exe=mysql_query($mark_query);
                                    $mark_query_fet=mysql_fetch_assoc($mark_query_exe);
                                    ?>

                                    <input type="text" value="<?php echo $mark_query_fet['mark']; ?> / <?php echo $mark_question_query_fet['mark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                </div>
                            </div>
                        </div>


                    </div>
					
 
					<!-- START -->

							<style>
							table td.test-cols span { width:10px; }
							div.dataTables_wrapper { width:90%; }
							</style>
 
							<!-- END -->

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where id IN ($questionbank_id) and question_type='Choose'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Choose</b></h6>
                        <?php
                        while($choose_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php
                                $mean_ques = $choose_fet['question'];
                                $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'] . " E) " . $choose_fet['optione'];
                                $mean_ans = $choose_fet['answer'];
                                echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                ?>
                                <b>Ans:</b><?php echo $choose_fet['answer']; ?>
                                </br>
                                <?php
                                $qid=$choose_fet['id'];
                                $ans_query= "SELECT * FROM `aptitude_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                $ans_query_exe=mysql_query($ans_query);
                                $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                ?>
                                <p class="<?php echo $style_class; ?>">
                                    <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                </p>
                                <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>
 
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
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({
			displayLength: 1000
        });
    } );
</script>
</body>
</html>
