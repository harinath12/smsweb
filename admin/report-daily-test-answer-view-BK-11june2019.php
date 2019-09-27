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
    header("Location: report-daily-test.php?error=1");
}

if(isset($_REQUEST['answer_id']))
{
    $answer_id = $_REQUEST['answer_id'];
}
else
{
    header("Location: report-daily-test.php?error=1");
}

if(isset($_REQUEST['mark']))
{
    $mark = $_REQUEST['mark'];
}
else
{
    $mark = "";
}


include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$ques_bank_sql = mysql_query("select qb.*, c.class_name from daily_test as qb
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
                <li><a href="report-daily-test.php"> Test Report</a></li>
                <li><a href="report-daily-test-answer.php?test_id=<?php echo $test_id; ?>">Test Report View</a></li>
                <li class="active">Test Report Answer</li>
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
                                    $ans_query= "SELECT * FROM `daily_test_answer` WHERE `daily_test_id`='$test_id' AND `id`='$answer_id'";
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


                    </div>
					
					<div class="row">
						<div class="col-md-8"></div>
						<div class="col-md-2">
							<form action="report-daily-test-answer-view.php" method="GET" >
							<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
							<input type="hidden" name="answer_id" value="<?php echo $answer_id; ?>" />
							
								<select name="mark" id="version-select" class="form-control" onchange="this.form.submit()">
									<option value="">All</option>
									<option value="1">Correct</option>
									<option value="0">Wrong</option>
								</select>
							</form>
						</div>
						<div class="col-md-2"></div>
					</div>
					<?php /* ?>
					<select name="version-select" id="version-select">
						<option value="option_1_6">Option 1.6</option>
						<option value="option_1_7">Option 1.7</option>
						<option value="option_1_8">Option 1.8</option>
						<option value="option_2_0">Option 2.0</option>
					</select>

					<div class="class_1_6">
					<img src="my_path/to/my_images"/>
					<p>some text</p>
					</div>

					<div class="class_1_7">
					<img src="my_path/to/my_images"/>
					<p>some text</p>
					</div>

					<div class="class_1_8">
					<img src="my_path/to/my_images"/>
					<p>some text</p>
					</div>
					<?php */ ?>
					<?php /* ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Meanings'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h5><b>Meanings</b></h5>

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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
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
                        <h5><b>Opposites</b></h5>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
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
                        <h5><b>Fill Up</b></h5>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
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
                        <h5><b>Choose</b></h5>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
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
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='True or False'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h5><b>True or False</b></h5>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
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


                        <h5><b>Match</b> </h5>
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
                                    &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
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
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='One or Two Words'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h5><b>One or Two Words</b></h5>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Missing Letters'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h5><b>Missing Letters</b></h5>

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
                                <?php echo $m . ') ' . $ans_query_fet['question_answer']; ?>
                                <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                <br/>
                                <b>Correct Ans: </b><?php echo $ques_fet['answer']; ?>
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp
                                <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                <span style="color:<?php echo $ans_class; ?>">
                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                </span>
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
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
                        <h5><b>Jumbled Words</b></h5>

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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;

                                <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                <span style="color:<?php echo $ans_class; ?>">
                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                </span>
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
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
                        <h5><b>Jumbled Letters</b></h5>

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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;

                                <?php if($ans_query_fet['daily_test_mark']==1) { $ans_class="green"; } else { $ans_class="red"; } ?>
                                <span style="color:<?php echo $ans_class; ?>">
                                <b>Your Ans: </b><?php echo $ans_query_fet['answer']; ?>
                                </span>
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php if($m == 1){ ?>
                                    <h5><b><?php echo $ques_fet['other_type']; ?></b></h5>
                                <?php } ?>
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
                                &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                <b>Marks: </b><?php echo $ans_query_fet['daily_test_mark']; ?>
                                <br/><br/>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>
					<?php */ ?>
					
					<!-- START -->

							<style>
							table td.test-cols span { width:10px; }
							div.dataTables_wrapper { width:90%; }
							</style>
							<?php /*
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
                                    $m++;
                                }
								?>
								</tbody>
							</table>	
                            <?php 
							} */
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
									if($mark==0) {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=0";
									}
									else if($mark==1) {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=1";
									}
									else {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
									}
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
									if($mark==0) {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=0";
									}
									else if($mark==1) {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=1";
									}
									else {
                                    $ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
									}
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
                                
								if($mark==0) {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=0";
								}
								else if($mark==1) {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=1";
								}
								else {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
								}
								
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

								if($mark==0) {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=0";
								}
								else if($mark==1) {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id' AND `daily_test_mark`=1";
								}
								else {
								$ans_query= "SELECT * FROM `daily_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
								}
								
								
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
<?php /* ?>
<script type='text/javascript'>

$(function(){   
$("#version-select").bind("change", function() {
    var value = $(this).find("option:selected").val();
	alert(value);
    var last3chars = value.substring(value.length - 3);
$("div[class]").hide();
    $(".class_" + last3chars).show();
});
});
</script>
<?php */ ?>
</body>
</html>
