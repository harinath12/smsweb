<?php session_start();
ob_start(); 

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}


include "config.php";

if(isset($_REQUEST['test_id']))
{
$test_id = $_REQUEST['test_id'];
}
else
{
	header("Location: question-paper.php?error=1");
}

$ques_bank_sql = 	"SELECT qb.*, c.class_name, c.class_name FROM `term_test` as qb
					LEFT JOIN classes as c on c.id = qb.class_id	
					WHERE qb.id=$test_id";

$ques_bank_exe = mysql_query($ques_bank_sql);
$ques_bank_fet = mysql_fetch_array($ques_bank_exe);
$daily_test_question_count = $ques_bank_fet['daily_test_question_count'];

if(isset($ques_bank_fet['daily_test_chapters']))
{
$questionbank_id = $ques_bank_fet['daily_test_chapters'];

$class_id = $ques_bank_fet['class_id'];
$term = $ques_bank_fet['term'];
$subject_name = $ques_bank_fet['subject_name'];
}
else
{
	header("Location: create-question-paper.php?error=1");
}	


$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$class_sql = "SELECT * FROM `classes` where `id`='$class_id' AND `class_status`=1";
$class_exe = mysql_query($class_sql);
$class_fet = mysql_fetch_assoc($class_exe);
$class_name = $class_fet['class_name'];

/* $section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}


$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
} */
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Question Paper</li>
            </ol>
        </div>
 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
							
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <a href="question-paper.php"><button type="button" class="form-control btn btn-info">View Question Paper</button></a>
                                </div>
                            </div>
 
							
							<form action="docreatequestionpaper.php" method="POST" id="self-test-form" name="self-test-form" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class</label>
                                        <div class="col-md-8">
											<input type="text" name="class_name" value="<?php echo $class_name; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject</label>
                                        <div class="col-md-8">
                                            <input type="text" name="subject_name" value="<?php echo $subject_name; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-md-4">Term</label>
                                        <div class="col-md-8">
                                            <input type="text" name="term" value="<?php echo $term; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Test Name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_name" value="<?php echo $class_name; ?>-<?php echo $subject_name; ?>-<?php echo $term; ?>-<?php echo date("Y-m-d"); ?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Mark</label>
                                        <div class="col-md-8">
                                            <input type="number" min="0" name="daily_test_mark" value="" class="form-control overallmark" />
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-md-4">Time</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_remark" value="" class="form-control" />
                                        </div>
                                    </div>
									
									
									<div class="form-group">
                                        <label class="col-md-4">Remaining Mark</label>
                                        <div class="col-md-8">
                                            <input type="number" min="0" name="daily_test_remaining" value="" class="form-control remmark" readonly/>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-md-4">Number of Question Paper </label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_question_count" value="" class="form-control" />
                                        </div>
                                    </div>
                                </div>
								
								
                            </div>
							<br/><br/>
							<div class="row" style="margin-left: 20px;">
                                <div class="col-md-4">
								<b>Type</b>
								</div>
								<div class="col-md-2">
								<b>Available Question</b>
								</div>
								<div class="col-md-2">
								<b>No.of Question</b>
								</div>
								<div class="col-md-2">
								<b>Mark per Question</b>
								</div>
								<div class="col-md-2">
								<b>Total Mark</b>
								</div>
							</div>

							<?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Meanings'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<div class="row" style="margin-left: 20px;">
                                <div class="col-md-4">
								<h6><b>Meanings</b> <input type="checkbox" checked="checked" onClick="toggle(this,'meanings')" style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
								</div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Meanings']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Meanings']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Meanings']" style="border:0px;" readonly value="0" class="totalmarkques"/>
								</div>
								</div>
                                <?php
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <div class="row hidden" style="margin-left: 20px;">
                                    <input class="meanings" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?> 
                                </div>
                            <?php
                                $m++;
                            }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Opposites'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <div class="row" style="margin-left: 20px;">
								<div class="col-md-4">
								<h6><b>Opposites</b> <input type="checkbox" checked="checked" onClick="toggle(this,'opposites')" style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
                                </div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Opposites']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Opposites']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Opposites']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
								
								<?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row hidden" style="margin-left: 20px;">
                                        <input class="opposites" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' X ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Fill Up'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <div class="row" style="margin-left: 20px;">
								<div class="col-md-4">
								<h6><b>Fill Up</b> <input type="checkbox" checked="checked" onClick="toggle(this,'fillup')" style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
                                </div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Fill Up']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Fill Up']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Fill Up']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
								
								<?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row hidden" style="margin-left: 20px;">
                                        <input class="fillup" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Choose'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<div class="row" style="margin-left: 20px;">
                                <div class="col-md-4">
								<h6><b>Choose</b>  <input type="checkbox" checked="checked" onClick="toggle(this,'choose')" style="display:none;"  /> <!-- Check All / Uncheck All<br/> --> </h6>
								</div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Choose']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Choose']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Choose']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
								
                                <?php
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row  hidden" style="margin-left: 20px;">
                                        <input class="choose" type="checkbox" name="questions[]" checked="checked" value="<?php echo $choose_fet['id']; ?>" style="display:none;" /> ::: 
										<?php
                                        $mean_ques = $choose_fet['question'];
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br> <b>Ans:</b> ' . $mean_ans;
                                        ?>
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='True or False'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<div class="row" style="margin-left: 20px;">
                                <div class="col-md-4">
								<h6><b>True or False</b> <input type="checkbox" checked="checked" onClick="toggle(this,'trueorfalse')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --> </h6>
								</div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['True or False']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['True or False']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['True or False']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
								
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row hidden" style="margin-left: 20px;">
                                        <input class="trueorfalse" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
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

							$ques_ans_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Match'");
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

							
							$ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Match'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<div class="row" style="margin-left: 20px;">
                                <div class="col-md-4">
								<h6><b>Match</b> <input type="checkbox" checked="checked" onClick="toggle(this,'match')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --> </h6>
								</div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Match']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Match']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Match']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php 
										/*
										?>
										
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
									<?php */ ?>
									 <div class="row hidden" style="margin-left: 20px;">
										<div class="col-lg-2 col-md-2">
										<input class="match" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: 
										<?php 
										/*
										?>
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
										<br/>
										<?php */ ?>
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										
										</div>
										<div class="col-lg-3 col-md-3">
										&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo  $ques_ans_array[$m-1]; ?>
										</div>
										<div class="col-lg-4 col-md-4">
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
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='One or Two Words'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<div class="row" style="margin-left: 20px;">
								<div class="col-md-4">
                                <h6><b>One or Two Words</b> <input type="checkbox" checked="checked" onClick="toggle(this,'oneortwo')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
								</div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['One or Two Words']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['One or Two Words']" class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['One or Two Words']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row hidden" style="margin-left: 20px;">
                                        <input class="oneortwo" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Missing Letters'");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
									<div class="row" style="margin-left: 20px;">
									<div class="col-md-4">
                                    <h6><b>Missing Letters</b> <input type="checkbox" checked="checked" onClick="toggle(this,'missing')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
									</div>
									<div class="col-md-2">
                                        <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="noofquestion['Missing Letters']" class="noofques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="markperquestion['Missing Letters']" class="markques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="totalmark['Missing Letters']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
									</div>
									</div>
                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row hidden" style="margin-left: 20px;">
                                            <input class="missing" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Jumbled Words'");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
									<div class="row" style="margin-left: 20px;">
									<div class="col-md-4">
                                    <h6><b>Jumbled Words</b> <input type="checkbox" checked="checked" onClick="toggle(this,'jumble')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
									</div>
									<div class="col-md-2">
                                        <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="noofquestion['Jumbled Words']" class="noofques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="markperquestion['Jumbled Words']" class="markques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="totalmark['Jumbled Words']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
									</div>
									</div>
                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row hidden" style="margin-left: 20px;">
                                            <input class="jumble" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Jumbled Letters'");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
									<div class="row" style="margin-left: 20px;">
									<div class="col-md-4">
                                    <h6><b>Jumbled Letters</b> <input type="checkbox" checked="checked" onClick="toggle(this,'jumbleletter')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
									</div>
									<div class="col-md-2">
                                        <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="noofquestion['Jumbled Letters']" class="noofques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="markperquestion['Jumbled Letters']" class="markques"/>
									</div>
									<div class="col-md-2">
									<input type="number" min="0" name="totalmark['Jumbled Letters']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
									</div>
									</div>
                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row hidden" style="margin-left: 20px;">
                                            <input class="jumbleletter" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

							<?php /* ?>
                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Other'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								<h6><b>Other</b> <input type="checkbox" onClick="toggle(this,'other')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="other" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: 
										<?php if($m == 1){ ?>
                                        <h6><b><?php echo $ques_fet['other_type']; ?></b></h6>
                                        <?php } ?>
                                        <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
							<?php */ ?>
							
							
							<?php
                            
							$other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Other'");
                            $other_ques_cnt = mysql_num_rows($other_ques_sql);
										
							$ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Other' group by other_type");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                ?>
								<div class="row hidden" style="margin-left: 20px;">
                                <div class="col-md-4">
								<h6><b>Other</b> <input type="checkbox" checked="checked" onClick="toggle(this,'other')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
                                </div>
								<div class="col-md-2">
                                    <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="noofquestion['Other']" class="noofques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="markperquestion['Other']"  class="markques"/>
								</div>
								<div class="col-md-2">
								<input type="number" min="0" name="totalmark['Other']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
								</div>
								</div>
								<?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    $otype = $ques_fet['other_type'];
                                    ?>

                                        <?php
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
										
										<div class="row" style="margin-left: 20px;">
										<div class="col-md-4">
										<h6><b><?php echo $otype; ?></b> <input type="checkbox" checked="checked" onClick="toggle(this,'other')"  style="display:none;"  /> <!-- Check All / Uncheck All<br/> --></h6>
										</div>
										<div class="col-md-2">
                                            <input type="text" style="border:0px;" readonly value="<?php echo $ques_cnt; ?>" class="quescnt"/>
										</div>
										<div class="col-md-2">
										<input type="number" min="0" name="noofquestion['<?php echo $otype; ?>']" class="noofques"/>
										</div>
										<div class="col-md-2">
										<input type="number" min="0" name="markperquestion['<?php echo $otype; ?>']" class="markques"/>
										</div>
										<div class="col-md-2">
										<input type="number" min="0" name="totalmark['<?php echo $otype; ?>']" style="border:0px;" readonly  value="0" class="totalmarkques"/>
										</div>
										</div>
										
                                        
                                    <?php
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
                                        <div class="row hidden" style="margin-left: 20px;">
										<input class="other" type="checkbox" name="questions[]" checked="checked" value="<?php echo $other_ques_fet['id']; ?>" style="display:none;" /> ::: 
                                        <?php echo $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer']; ?>
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                    ?>

                                    <?php
                                }
                            }
                            ?>
							
							
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4">
										    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" /> 
											<input type="hidden" name="daily_test_chapters" value="<?php echo $questionbank_id; ?>" />
											<button type="submit" class="form-control btn btn-info" name="BtnSubmit">Generate Question Paper</button>
                                        </div>
                                    </div>
 
                                </div>
                                 
								
								
                            </div>

							</form>

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
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script language="JavaScript">
function toggle(source,classname) {
  checkboxes = document.getElementsByClassName(classname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script>
    $(".overallmark").on("input",function() {
		var overallmark = $('.overallmark').val();
		$('.remmark').val(parseInt(overallmark));
	});

	$(".noofques").on("input",function() {
        var ques = $(this).val();
        var qcnt = $(this).parent().prev().children().val();
        if(parseInt(ques) > parseInt(qcnt)){
            $(this).val('');
            alert("Exceeded the available questions");
            return false;
        }
        //$(this).parent().siblings('.quesdiv').css('background-color', 'Red');
        var mark = $(this).parent().next().children().val();
        var total = ques * mark;
        $(this).parent().next().next().children().val(total);

        var overallmark = $('.overallmark').val();
        if(overallmark != null){
            var sum = 0;
            $('.totalmarkques').each(function(){
                sum += parseInt($(this).val());
				remain = overallmark - sum;
            });

            if(parseInt(sum) > parseInt(overallmark)){
                $(this).val('');
                alert("Exceeded the overall assigned mark");
                return false;
            }
            else{
                /* $('.remmark').val(parseInt(sum)); */
				$('.remmark').val(parseInt(remain));
				
            }
        }
    });

    $(".markques").on("input",function() {
        var mark = $(this).val();
        var ques = $(this).parent().prev().children().val();
        var total = ques * mark;
        $(this).parent().next().children().val(total);

        var overallmark = $('.overallmark').val();
        if(overallmark != null){
            var sum = 0;
            $('.totalmarkques').each(function(){
                sum += parseInt($(this).val());
				remain = overallmark - sum;
            });

            if(parseInt(sum) > parseInt(overallmark)){
                $(this).val('');
                alert("Exceeded the overall assigned mark");
                return false;
            }
            else{
                /* $('.remmark').val(parseInt(sum)); */
				$('.remmark').val(parseInt(remain));
            }
        }
    });
</script>
</body>
</html>
