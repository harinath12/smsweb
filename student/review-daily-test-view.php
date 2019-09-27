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
	header("Location: daily-test.php?error=1");
}

if(isset($_REQUEST['answer_id']))
{
$answer_id = $_REQUEST['answer_id'];
}
else
{
	header("Location: daily-test.php?error=1");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");


$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from daily_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");

$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);



$daily_test_question_sql = "SELECT * FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";

$daily_test_question_exe = mysql_query($daily_test_question_sql);


while($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe))
{
	$questionbank_id_array[] = $daily_test_question_fetch['question_id'];
}

$questionbank_id=implode(",",$questionbank_id_array);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>
	<style>
	p.red-color { color:red; }
	</style>
</head>
<body>
<!-- Main navbar -->
<?php
include 'header.php';
?>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container" style="min-height:700px">

    <!-- Page content -->
    <div class="page-content"><!-- Main sidebar -->
        <div class="sidebar sidebar-main hidden-xs">
            <?php include "sidebar.php"; ?>
        </div>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="daily-test.php">Test</a></li>
                        <!--
						<li><a href="review-daily-test.php?test_id=<?php //echo $test_id; ?>">Test Review</a></li>
						-->
                        <li class="active">Test View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                        <input type="text" value="Subject : <?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
                                        <input type="text" value="Test Name : <?php echo $ques_bank_fet['daily_test_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                        <div class="col-md-3">
										<?php 
										$mark_question_query="SELECT COUNT(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
										$mark_question_query_exe=mysql_query($mark_question_query);
										$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
										
										$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
										$mark_query_exe=mysql_query($mark_query);
										$mark_query_fet=mysql_fetch_assoc($mark_query_exe);
										?>
										
                                        <input type="text" value="Mark : <?php echo $mark_query_fet['mark']; ?> / <?php echo $mark_question_query_fet['mark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
                                        <input type="text" value="Remark : <?php echo $ques_bank_fet['daily_test_remark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                    </div>
								</div> 
								
								
                            </div>
							
							<?php /* ?>
							
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class</label>
                                        <div class="col-md-8">
										 <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?> <?php echo $ques_bank_fet['section_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject</label>
                                        <div class="col-md-8">
                                        <input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-md-4">Mark</label>
                                        <div class="col-md-8">
										
										<?php 
										$mark_question_query="SELECT COUNT(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
										$mark_question_query_exe=mysql_query($mark_question_query);
										$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
										
										$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
										$mark_query_exe=mysql_query($mark_query);
										$mark_query_fet=mysql_fetch_assoc($mark_query_exe);
										?>
										
                                        <input type="text" value="<?php echo $mark_query_fet['mark']; ?> / <?php echo $mark_question_query_fet['mark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
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
							<?php */ ?>
							
							<?php /* ?>

							<?php
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Meanings' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
							$ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Meanings</b></h6>
								                            
                                <?php
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <div class="row" style="margin-left: 20px;">
									<?php echo $m . ') ' . $ques_fet['question']; ?> 
									<br/>
									<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
									&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
									<?php
									$qid=$ques_fet['id'];
									$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
									$ans_query_exe=mysql_query($ans_query);
									$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
									?>
									<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
									<span style="color:<?php echo $ans_class; ?>">
									<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
									</span>
                                    &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                    <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
									<br/><br/>
								</div>
                            <?php
                                $m++;
                            }
                            }
                            ?>

                            <?php
							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Opposites' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
							$ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Opposites</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										<br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Fill Up' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Fill Up</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										<br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Choose' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
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
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                        ?>
										<br/>
										<b>Correct Ans: </b><?php echo $choose_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$choose_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										<br/>
										<br/>
                                	</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='True or False' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>True or False</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										<br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
							function kshuffle(&$array) {
								if(!is_array($array) || empty($array)) {
									return false;
								}
								$tmp = array();
								foreach($array as $key => $value) {
									$tmp[] = array('k' => $key, 'v' => $value);
								}
								shuffle($tmp);
								$array = array();
								foreach($tmp as $entry) {
									$array[$entry['k']] = $entry['v'];
								}
								return true;
							}

							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Match' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_ans_sql=mysql_query($ques_query);
                            $ques_ans_cnt = mysql_num_rows($ques_ans_sql);
                            if($ques_ans_cnt> 0){
							
								$$ques_ans_array = "";
								while($ques_ans_fet = mysql_fetch_assoc($ques_ans_sql)){
									$ques_ans_array[] = $ques_ans_fet['answer'];
								}
								
								//print_r($ques_ans_array);
								$question_answers = shuffle($ques_ans_array);
								//print_r($ques_ans_array);
							}

							$ques_sql=mysql_query($ques_query);
							$ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                

								<h6><b>Match</b> </h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										<div class="col-lg-2 col-md-2">

										<?php echo $m . ') ' . $ques_fet['question']; ?>
										
										</div>
										<div class="col-lg-3 col-md-3">
										&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo  $ques_ans_array[$m-1]; ?>
										</div>
										<div class="col-lg-4 col-md-4">
										<?php
										$qid=$ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
                                            &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                            <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										</div>
										<div class="col-lg-4 col-md-4">
										
										</div>
										<br/><br/>
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
							
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='One or Two Words' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>One or Two Words</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										
										<b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										<br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Missing Letters' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
                            $ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Missing Letters</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                        $ans_query_exe=mysql_query($ans_query);
                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                        ?>
                                        <?php //echo $m . ') ' . $ques_fet['question']; ?>
										<?php echo $m . ') ' . $ans_query_fet['question_answer']; ?>
                                        <br/>
                                        <b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                        <span style="color:<?php echo $ans_class; ?>">
									<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
									</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        <br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Jumbled Words' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
                            $ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Jumbled Words</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                        $ans_query_exe=mysql_query($ans_query);
                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                        ?>
                                        <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                        <?php echo $m . ') ' . $ans_query_fet['question_answer']; ?>
                                        <br/>
                                        <b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                        <span style="color:<?php echo $ans_class; ?>">
									<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
									</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        <br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Jumbled Letters' AND daily_test_answer_id = '$answer_id' order by test.order_id ASC";
                            $ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Jumbled Letters</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                        $ans_query_exe=mysql_query($ans_query);
                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                        ?>
                                        <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                        <?php echo $m . ') ' . $ans_query_fet['question_answer']; ?>
                                        <br/>
                                        <b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                        <span style="color:<?php echo $ans_class; ?>">
									<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
									</span>
                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                        <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        <br/><br/>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>


							<?php
                            
							$ques_query = "SELECT test.`order_id`, qa.* FROM `question_answer` AS qa
											LEFT JOIN daily_test_question_answer AS test ON test.`question_id` = qa.id
											LEFT JOIN daily_test_answer AS test_ans ON test_ans.`id` = test.daily_test_answer_id
											WHERE qa.id IN ($questionbank_id) and question_type='Other' AND daily_test_answer_id = '$answer_id' group by other_type order by test.order_id ASC";
							$ques_sql=mysql_query($ques_query);
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                ?>
                                <h6><b>Other</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    $otype = $ques_fet['other_type'];
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <h6><b><?php echo $otype; ?></b></h6>
                                        <?php
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                    <?php
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
										<?php echo $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer']; ?>
										<br/>
										<b>Correct Ans: </b><?php echo $other_ques_fet['answer']; ?>
										&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
										<?php
										$qid=$other_ques_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										?>
										<?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
										<span style="color:<?php echo $ans_class; ?>">
										<b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</span>
                                            &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                            <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
										</div>
                                        <?php
                                        $m++;
                                    }
                                    ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>	
							<?php */ ?>

							
							<!-- START -->

							<style>
							table td.test-cols span { width:10px; }
							div.dataTables_wrapper { width:90%; }
							</style>
							<?php
                            /*
							$ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) ");
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
									<th>CORRECT ANSWERS</th>
									<th>YOUR ANSWERS</th>
									<th>MARK</th>
								</tr>
                                </thead>
								<tbody>
								
                                <?php
								$i =1;
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                   <tr>
										<td><?php echo $i; ?></td>
										<td>
										<?php echo $choose_fet['question_type']; ?>
										</td>
										<td>
										<?php
                                        $mean_ques = $choose_fet['question'];
                                        if($choose_fet['question_type']=="Choose") 
										{
											$mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                            echo $mean_ques . '<br>' . $mean_opt . '<br>';
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
                                            echo $mean_ques . '<br>';
										}
										?>
										</td>
										<td>
										<b>Ans: </b><?php echo $choose_fet['answer']; ?>
										</td>
										<td>
										<?php
										$qid=$choose_fet['id'];
										$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);
										if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
										?>
										<p class="<?php echo $style_class; ?>">
										<b>Ans: </b><?php echo $ans_query_fet['answer']; ?>
										</p>
                                        </td>
										<td>
										<?php echo $ans_query_fet['daily_test_mark']; ?>
										</td>
										
                                	</tr>
                                    <?php
                                    $i++;
                                    $m++;
                                }
								?>
								</tbody>
                            <?php 
							}
                            */
                            ?>
							<!-- END -->

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Meanings'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Meanings</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>

                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Opposites'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Opposites</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
                                            &nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;<?php echo $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>

                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Fill Up'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Fill Up</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        <br/>
                                        <b>Ans:</b><?php echo $ques_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
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

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Choose'");
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
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                        ?>
                                        <b>Ans:</b><?php echo $choose_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$choose_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
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

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='True or False'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>True or False</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        <br/>
                                        <b>Ans:</b><?php echo $ques_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
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

                            <?php
                            function kshuffle(&$array) {
                                if(!is_array($array) || empty($array)) {
                                    return false;
                                }
                                $tmp = array();
                                foreach($array as $key => $value) {
                                    $tmp[] = array('k' => $key, 'v' => $value);
                                }
                                shuffle($tmp);
                                $array = array();
                                foreach($tmp as $entry) {
                                    $array[$entry['k']] = $entry['v'];
                                }
                                return true;
                            }

                            $ques_ans_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Match'");
                            $ques_ans_cnt = mysql_num_rows($ques_ans_sql);
                            if($ques_ans_cnt> 0){

                                $ques_ans_array = "";
                                while($ques_ans_fet = mysql_fetch_assoc($ques_ans_sql)){
                                    $ques_ans_array[] = $ques_ans_fet['answer'];
                                }

                                //print_r($ques_ans_array);
                                $question_answers = shuffle($ques_ans_array);
                                //print_r($ques_ans_array);
                            }
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Match'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>


                                <h6><b>Match</b> </h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <?php /* ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
										<br/>
										<b>Ans:</b><?php echo $ques_fet['answer']; ?>
									</div>
									<?php */ ?>

                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                            <?php
                                            /*
                                            ?><?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                            <br/>
                                            <?php */ ?>
                                            <?php echo $m . ') ' . $ques_fet['question']; ?>

                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php //echo  $ques_ans_array[$m-1]; ?><?php echo $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='One or Two Words'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>One or Two Words</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        <br/>
                                        <b>Ans:</b><?php echo $ques_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
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

                            <?php
                            $rand=rand(1, 3);
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Missing Letters'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Missing Letters</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <?php

                                    $str = $ques_fet['question'];
                                    $strlen = strlen($str);
                                    $char="_";
                                    $pos=0;
                                    if($rand==1) {
                                        if($strlen>10)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                            $str = substr_replace($str,$char,5,1);
                                            $str = @substr_replace($str,$char,9,1);
                                        }
                                        else if($strlen>8)
                                        {
                                            $str = substr_replace($str,$char,3,1);
                                            $str = substr_replace($str,$char,6,1);
                                            $str = @substr_replace($str,$char,8,1);
                                        }
                                        else if($strlen>6)
                                        {
                                            $str = substr_replace($str,$char,1,1);
                                            $str = substr_replace($str,$char,3,1);
                                            $str = @substr_replace($str,$char,5,1);
                                        }
                                        else if($strlen>4)
                                        {
                                            $str = substr_replace($str,$char,0,1);
                                            $str = @substr_replace($str,$char,3,1);
                                        }
                                        else if($strlen>2)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                        }
                                    }
                                    if($rand==2) {
                                        if($strlen>10)
                                        {
                                            $str = substr_replace($str,$char,1,1);
                                            $str = substr_replace($str,$char,4,1);
                                            $str = @substr_replace($str,$char,8,1);
                                        }
                                        else if($strlen>8)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                            $str = substr_replace($str,$char,5,1);
                                            $str = @substr_replace($str,$char,7,1);
                                        }
                                        else if($strlen>6)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                            $str = substr_replace($str,$char,4,1);
                                            $str = @substr_replace($str,$char,6,1);
                                        }
                                        else if($strlen>4)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                            $str = @substr_replace($str,$char,4,1);
                                        }
                                        else if($strlen>2)
                                        {
                                            $str = substr_replace($str,$char,1,1);
                                        }
                                    }
                                    if($rand==3) {
                                        if($strlen>10)
                                        {
                                            $str = substr_replace($str,$char,3,1);
                                            $str = substr_replace($str,$char,5,1);
                                            $str = @substr_replace($str,$char,7,1);
                                        }
                                        else if($strlen>8)
                                        {
                                            $str = substr_replace($str,$char,1,1);
                                            $str = substr_replace($str,$char,3,1);
                                            $str = @substr_replace($str,$char,6,1);
                                        }
                                        else if($strlen>6)
                                        {
                                            $str = substr_replace($str,$char,0,1);
                                            $str = substr_replace($str,$char,2,1);
                                            $str = @substr_replace($str,$char,5,1);
                                        }
                                        else if($strlen>4)
                                        {
                                            $str = substr_replace($str,$char,2,1);
                                            $str = @substr_replace($str,$char,4,1);
                                        }
                                        else if($strlen>2)
                                        {
                                            $str = substr_replace($str,$char,0,1);
                                        }
                                    }

                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5">
                                            <?php echo $m . ') ' . $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>

                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Jumbled Words'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Jumbled Words</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <?php
                                    $translatedWords = explode(' ',$ques_fet['question']);
                                    shuffle($translatedWords);
                                    $translatedWords = implode(' ',$translatedWords);
                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <?php echo $m . ') ' . $ques_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$ques_fet['id'];
                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                        $ans_query_exe=mysql_query($ans_query);
                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                        if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                        ?>
                                        <p class="<?php echo $style_class; ?>">
                                            <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                        </p>
                                        <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>

                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Jumbled Letters'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Jumbled Letters</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <?php
                                    $translatedWords = str_shuffle($ques_fet['question']);
                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5">
                                            <?php echo $m . ') ' . $ques_fet['question']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Dictation'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Dictation</b></h6>

                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">

                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php echo $m . ') '; ?>
                                            <audio controls style="width: 80%;">
                                                <source src="<?php echo '../teacher/' . $ques_fet['question'];?>">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-2 col-xs-2">
                                            &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <?php
                                            $qid=$ques_fet['id'];
                                            $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                            $ans_query_exe=mysql_query($ans_query);
                                            $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                            if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                            ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-2 col-xs-2">
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other' group by other_type");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                ?>
                                <h6 class="hidden"><b>Other</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    $otype = $ques_fet['other_type'];
                                    ?>
                                    <div class="row" style="margin-left: 0px;">
                                        <h6><b><?php echo $otype; ?></b></h6>
                                        <?php
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                        <?php
                                        $m = 1;
                                        while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                            ?>
                                            <div class="row" style="margin-left: 20px;">

                                                <?php if($otype=="rhyming words" || $otype=="Rhyming Words" || $otype=="Rhyming Words :" || $otype=="rhyming word" || $otype=="Rhyming Word") { ?>

                                                    <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <?php echo $m . ') ' . $other_ques_fet['question']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
                                                        &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $other_ques_fet['answer']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                                        <?php
                                                        $qid=$other_ques_fet['id'];
                                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                                        $ans_query_exe=mysql_query($ans_query);
                                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                                        if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                                        ?>
                                                        <p class="<?php echo $style_class; ?>">
                                                            <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                                    </div>

                                                <?php } else if($otype=="plural" || $otype=="Plural" || $otype=="PLURAL" || $otype=="plural:" || $otype=="PLURAL:") { ?>

                                                    <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <?php echo $m . ') ' . $other_ques_fet['question']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
                                                        &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $other_ques_fet['answer']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                                        <?php
                                                        $qid=$other_ques_fet['id'];
                                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                                        $ans_query_exe=mysql_query($ans_query);
                                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                                        if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                                        ?>
                                                        <p class="<?php echo $style_class; ?>">
                                                            <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                                    </div>

                                                <?php } else { ?>
                                                    <?php /* ?>
													
													<?php echo $m . ') ' . $other_ques_fet['question']; ?>
                                                    <br/>
                                                    <b>Ans:</b><?php echo $other_ques_fet['answer']; ?>
                                                    </br>
                                                     <?php
                                                    $qid=$other_ques_fet['id'];
                                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                                    $ans_query_exe=mysql_query($ans_query);
                                                    $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                                    if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                                    ?>
                                            <p class="<?php echo $style_class; ?>">
                                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                            </p>
                                            <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                                    <br/>
													<?php */ ?>
													<div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <?php echo $m . ') ' . $other_ques_fet['question']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
                                                        &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $other_ques_fet['answer']; ?>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                                        <?php
                                                        $qid=$other_ques_fet['id'];
                                                        $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
                                                        $ans_query_exe=mysql_query($ans_query);
                                                        $ans_query_fet=mysql_fetch_assoc($ans_query_exe);
                                                        if($ans_query_fet['daily_test_mark']==0) { $style_class="red-color"; } else { $style_class=""; }
                                                        ?>
                                                        <p class="<?php echo $style_class; ?>">
                                                            <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
                                                        <b>Mark: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                            <?php
                                            $m++;
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <?php include "footer.php"; ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
</body>
<script language="JavaScript">
function toggle(source,classname) {
  checkboxes = document.getElementsByClassName(classname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script type='text/javascript'>

    $(document).ready(function() {
        $(function() {
            $('.styled').uniform();
        });
        $(function() {

            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs: [
                    {
                        width: '5%',
                        targets: 0
                    },
					{
                        width: '10%',
                        targets: 1
                    },
                    {
                        width: '40%',
                        targets: 2
                    },
                    {
                        width: '20%',
                        targets: [3,4]
                    },
                    {
                        width: '5%',
                        targets: 5
                    }
                ],
                order: [[ 5, 'desc' ]],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                displayLength: 1000
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
	 
</script>
</html>
