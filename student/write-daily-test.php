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

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

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
                        <li class="active">Write Test</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-write-daily-test.php" method="POST" >
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
										$mark_query="SELECT COUNT(id) AS mark FROM `daily_test_question` WHERE `daily_test_id`='$test_id'";
										$mark_query_exe=mysql_query($mark_query);
										$mark_query_fet=mysql_fetch_assoc($mark_query_exe);
										?>
										
                                        <input type="text" value="Mark : <?php echo $mark_query_fet['mark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
                                        <input type="text" value="Remark : <?php echo $ques_bank_fet['daily_test_remark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                    </div>
								</div> 
                            </div>
							
							
							<?php /* ?>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
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
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
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

							<?php
							$ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Meanings' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Meanings</b></h6>
								                            
                                <?php
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <div class="row" style="margin-left: 20px;">
								
									<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
									<?php echo $m . ') ' . $ques_fet['question']; ?> 
									</div>
									<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
									-&nbsp;&nbsp;&nbsp;
									<input class="meanings" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
									<input class="meanings" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" /> 
									</div>
									<div class="col-lg-8 col-md-8 col-sm-4 col-xs-0">
									
									</div>
									 
                                </div>
                            <?php
                                $m++;
                            }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Opposites' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Opposites</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
																		    
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
										<?php echo $m . ') ' . $ques_fet['question']; ?> 
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
										X&nbsp;&nbsp;&nbsp;
										<input class="opposites" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="opposites" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" /> 
										</div>
										<div class="col-lg-8 col-md-8 col-sm-4 col-xs-0">
										
										</div>
										
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Fill Up' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Fill Up</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
											
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										<input class="fillup" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="fillup" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" /> 
										</div>
										<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
										
										</div>											
                                        
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Choose' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Choose</b></h6>
                                <?php
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<?php
                                        $mean_ques = $choose_fet['question'];
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                        ?>
										<br/>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										<input class="choose" type="hidden" name="questions[]" value="<?php echo $choose_fet['id']; ?>" /> 
										<input class="choose" type="text" name="answers[<?php echo $choose_fet['id']; ?>]" value="" style="width:90%" /> 
										</div>
										<div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
										
										</div>											
                                    
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='True or False' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>True or False</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
									
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										</div> 
										<div class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
										<input class="trueorfalse" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="trueorfalse" type="radio" name="answers[<?php echo $ques_fet['id']; ?>]" value="true" /> True 
										<input class="trueorfalse" type="radio" name="answers[<?php echo $ques_fet['id']; ?>]" value="false" /> False
										</div>
										<div class="col-lg-3 col-md-3 col-sm-1 col-xs-1">
										
										</div>	
										 
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
							
								$$ques_ans_array = "";
								while($ques_ans_fet = mysql_fetch_assoc($ques_ans_sql)){
									$ques_ans_array[] = $ques_ans_fet['answer'];
								}
								
								//print_r($ques_ans_array);
								$question_answers = shuffle($ques_ans_array);
								//print_r($ques_ans_array);
							}
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Match' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                

								<h6><b>Match</b> </h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										-&nbsp;&nbsp;&nbsp;
										<input class="match" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="match" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" />
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo  $ques_ans_array[$m-1]; ?>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-0 col-xs-0">
										
										</div>
										
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='One or Two Words' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>One or Two Words</b></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
										-&nbsp;&nbsp;&nbsp;
										<input class="oneortwo" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="oneortwo" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" /> 
										</div>
										<div class="col-lg-8 col-md-8 col-sm-4 col-xs-2">
										
										</div>
										
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                                <?php
								$rand=rand(1, 3);
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Missing Letters' ORDER BY RAND()");
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
										<?php 
											if($ques_bank_fet['subject_name']=="Tamil") { 
											$str_expl = explode(" ",$ques_fet['question']);
											/*
											echo "<br/>";
											print_r($str_expl);
											echo "<br/>";
											echo count($str_expl);
											echo "<br/>";
											*/
											if($rand==1) {
												for($i = 0; $i < count($str_expl); $i++) {
													if ($i == '1') {
													$str_expl[$i] = ' _ ';
													} elseif($i == '3'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '5'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '8'){
													$str_expl[$i] = ' _ ';
													}
												}
											}
											if($rand==2) {
												for($i = 0; $i < count($str_expl); $i++) {
													if ($i == '0') {
													$str_expl[$i] = ' _ ';
													} elseif($i == '2'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '4'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '6'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '8'){
													$str_expl[$i] = ' _ ';
													}
												}
											}
											if($rand==3) {
												for($i = 0; $i < count($str_expl); $i++) {
													if ($i == '1') {
													$str_expl[$i] = ' _ ';
													} elseif($i == '4'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '7'){
													$str_expl[$i] = ' _ ';
													} elseif($i == '9'){
													$str_expl[$i] = ' _ ';
													}
												}
											}
											
											//shuffle($str_expl);
											//shuffle($str_expl);
											$str=implode("",$str_expl);
											}
										?>
											
                                        <div class="row" style="margin-left: 20px;">
                                             
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											<?php echo $m . ') ' . $str; ?>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											-&nbsp;&nbsp;&nbsp;
											<input class="missing" type="hidden" name="question_answer[<?php echo $ques_fet['id']; ?>]" value="<?php echo $str; ?>" />
											<input class="missing" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
                                            <input class="missing" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" />
											</div>
											<div class="col-lg-8 col-md-8 col-sm-4 col-xs-2">
											
											</div>
											
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Jumbled Words' ORDER BY RAND()");
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
											
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											<?php echo $m . ') ' . $translatedWords; ?>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											-&nbsp;&nbsp;&nbsp;
											<input class="jumble" type="hidden" name="question_answer[<?php echo $ques_fet['id']; ?>]" value="<?php echo $translatedWords; ?>" />
											<input class="jumble" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
                                            <input class="jumble" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" />
											</div>
											<div class="col-lg-8 col-md-8 col-sm-4 col-xs-0">
											
											</div>
											
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>
								
								
								<?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Jumbled Letters' ORDER BY RAND()");
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
                                        <?php 
											if($ques_bank_fet['subject_name']=="Tamil") { 
											$str_expl = explode(" ",$ques_fet['question']);
											shuffle($str_expl);
											shuffle($str_expl);
											$translatedWords=implode("",$str_expl);
											}
										?>
                                        <div class="row" style="margin-left: 20px;">
                                            
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											<?php if($ques_bank_fet['subject_name']=="Tamil") { ?>
											<?php echo $m . ') ' . $translatedWords; ?>
											<?php } else { ?>
											<?php echo $m . ') ' . str_shuffle($ques_fet['question']); ?>
											<?php } ?>
                                            </div>
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											-&nbsp;&nbsp;&nbsp;
											<input class="jumble" type="hidden" name="question_answer[<?php echo $ques_fet['id']; ?>]" value="<?php echo $translatedWords; ?>" />
											<input class="jumble" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
                                            <input class="jumble" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" />
											</div>
											<div class="col-lg-8 col-md-8 col-sm-4 col-xs-0">
											
											</div>
											
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Dictation' ORDER BY RAND()");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
                                    <h6><b>Dictation</b></h6>

                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">
                                                <?php echo $m . ') '; ?>
                                                <audio controls style="width: 80%;">
                                                    <source src="<?php echo '../teacher/' . $ques_fet['question'];?>">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
                                                -&nbsp;&nbsp;&nbsp;
                                                <input class="meanings" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
                                                <input class="meanings" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-0">

                                            </div>

                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

							<?php /* ?>
                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php if($m == 1){ ?>
                                        <h6><b><?php echo $ques_fet['other_type']; ?></b></h6>
                                        <?php } ?>
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<input class="other" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
										<input class="other" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:500px" /> 
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
							<?php */ ?>
							
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
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and other_type='$otype' ORDER BY RAND()");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                    <?php
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
											
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											<?php echo $m . ') ' . $other_ques_fet['question']; ?>
											</div>
											<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5">
											-&nbsp;&nbsp;&nbsp;
											<input class="other" type="hidden" name="questions[]" value="<?php echo $other_ques_fet['id']; ?>" /> 
											<input class="other" type="text" name="answers[<?php echo $other_ques_fet['id']; ?>]" value="" style="width:90%" /> 
											</div>
											<div class="col-lg-8 col-md-8 col-sm-4 col-xs-2">
											
											</div>
											
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
							
							<br/><br/>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4">
											<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
											<input type="hidden" name="test_name" value="<?php echo $ques_bank_fet['daily_test_name']; ?>" />
											<button type="submit" class="form-control btn btn-info" name="submit">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

							</form>
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
	
	$('input').attr('autocomplete', 'off');
	$('textarea').attr('autocomplete', 'off');
	
	});	
</script>

<script type='text/javascript'>
/*
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
                        width: '20%',
                        targets: 0
                    },
                    {
                        width: '40%',
                        targets:[ 1,2]
                    }
                ],
                order: [[ 0, 'asc' ]],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                displayLength: 10
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
	*/
</script>
</html>
