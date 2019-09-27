<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['student_id']))
{
    $student_id = $_REQUEST['student_id'];
}
else
{
    header("Location: report-self-test.php?error=1");
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
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="report-self-test.php"> Test Report</a></li>
                <li><a href="report-self-test-answer.php?test_id=<?php echo $test_id; ?>">Test Report View</a></li>
                <li class="active">Report Test Answer View</li>
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
                        </div>


                    </div>


                    <!-- START -->

                    <style>
                        table td.test-cols span { width:10px; }
						div.dataTables_wrapper { width:90%; }
                    </style>
                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id)");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0)
                    {
                        $m = 1;
                        ?>
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>TYPE</th>
                                <th>QUESTION & ANSWER</th>
                                <th class="test-cols">
								<p>YOUR ANSWERS</p>
								<p>
									<?php
                                    $t=0;
                                    $ans_query= "SELECT * FROM `self_test_answer` WHERE `daily_test_id`='$test_id' AND `student_id`='$student_id' ORDER BY `id` ASC";
                                    $ans_query_exe=mysql_query($ans_query);
                                    while($ans_query_fet=mysql_fetch_assoc($ans_query_exe))
                                    {
                                        $t++;
                                        ?>
                                        <span style="width:20px;">
										<?php echo "T".$t; ?>
										</span>
                                    <?php
                                    }
                                    ?>
								</p>
								</th>
                                <th class="test-cols">
									<span style="color:green;">
										<?php echo "CA"; ?>&nbsp;&nbsp;
									</span>
								</th>
								<th class="test-cols">
									<span style="color:red;">
										<?php echo "WA"; ?>&nbsp;&nbsp;
									</span>
								</th> 
                            </tr>
                            </thead>
                            <tbody>
 
                            <?php
                            $i =1;
                            while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <?php echo $choose_fet['question_type']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $mean_ques = $choose_fet['question'];
                                        if($choose_fet['question_type']=="Choose")
                                        {
                                            $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                            echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                        }
                                        else if($choose_fet['question_type']=="Dictation")
                                        {
                                            ?>
                                            <audio controls style="width: 80%;">
                                                <source src="<?php echo '../teacher/' . $choose_fet['question'];?>">
                                                Your browser does not support the audio element.
                                            </audio>
                                        <?php
                                        }
                                        else
                                        {
                                            echo $m . ') ' . $mean_ques . '<br>';
                                        }
                                        ?>
                                        <b>Answer:</b><?php echo $choose_fet['answer']; ?>
                                        <br/><br/>
                                    </td>
                                    <td>
                                        <?php
                                        $qid=$choose_fet['id'];
                                        /*
                                        $ans_query= "SELECT * FROM `self_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                        */
                                        $correct=0;
                                        $wrong=0;
                                        $none=0;
                                        $ans_query= "SELECT * FROM `self_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' ORDER BY `daily_test_answer_id` ASC";
                                        $ans_query_exe=mysql_query($ans_query);
                                        while($ans_query_fet=mysql_fetch_assoc($ans_query_exe))
                                        {
                                            ?>
											<?php 
											if($ans_query_fet['daily_test_mark']==1) { 
											$correct++;
											?>
											<span style="color:green;">
											<i class="fa fa-check"></i>
											</span>
											<?php	
											} else {  
											$wrong++; ?>
											<span style="color:red;">
											<i class="fa fa-times"></i>
											</span>
											<?php
											} 
											?> 
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
										<span style="color:green;">
										<?php echo $correct; ?>
										</span>
                                    </td>
									<td>
										<span style="color:red;">
										<?php echo $wrong; ?>
										</span>
                                    </td>
									 
                                </tr>
                                <?php
                                $m++;
                            }
                            ?>
                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                    <!-- END -->

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

    $(function() {
        $('.datatable').DataTable({
			displayLength: 10000
        });
    });

</script>

</body>
</html>
