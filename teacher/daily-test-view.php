<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['chapter']))
{
$chapter_array = $_REQUEST['chapter'];
$questionbank_id = implode(",", $chapter_array);
}
else
{
	header("Location: create-daily-test.php?error=1");
}	
include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/*
$questionbank_id = $_REQUEST['question_id'];

$ques_bank_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id='$questionbank_id'");
*/

$ques_bank_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id IN ($questionbank_id)");


$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

$ques_bank_chapter_name = "";
$ques_bank_chapter_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id IN ($questionbank_id)");
while($ques_bank_chapter_fet = mysql_fetch_assoc($ques_bank_chapter_sql))
{
		$ques_bank_chapter_name .= $ques_bank_chapter_fet['chapter'].',';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
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
						<li><a href="create-daily-test.php">Create Daily Test</a></li>
                        <li class="active">Daily Test View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-daily-test.php" method="POST" >
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class</label>
                                        <div class="col-md-8">
										<?php
										$class_id=$ques_bank_fet['class_id'];
										$section_query="SELECT * FROM `class_section` WHERE `class_id` = '$class_id'";
										$section_exe = mysql_query($section_query);
                                        ?>
										<select name="section_id" class="form-control">
											<?php
											while($section_fet = mysql_fetch_assoc($section_exe)){
											?>
											<option value="<?php echo $section_fet['id']; ?>" > <?php echo $ques_bank_fet['class_name']; ?> <?php echo $section_fet['section_name']; ?></option>
											
											<?php
											}
											?>
										</select>
                                        
										<input type="hidden" name="class_name" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject</label>
                                        <div class="col-md-8">
                                            <input type="text" name="subject_name" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Test Name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_name" value="<?php echo $ques_bank_fet['class_name']; ?>-<?php echo $ques_bank_fet['subject_name']; ?>-<?php echo date("Y-m-d"); ?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Remarks</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_remark" value="<?php echo $ques_bank_chapter_name; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
								
								
                            </div>

							<?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Meanings'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Meanings</b> <input type="checkbox" onClick="toggle(this,'meanings')" /> Check All / Uncheck All<br/></h6>
								                            
                                <?php
								$chapter="";
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
								<?php
								$bank_id=$ques_fet['question_bank_id'];
								$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
								$chap_fet=mysql_fetch_assoc($chap_sql);
								
								if($chapter!=$chap_fet['chapter'])
								{
								$chapter=$chap_fet['chapter'];	
								echo "<strong>".$chapter."</strong>";
								}
								?>
								
                                <div class="row" style="margin-left: 20px;">
                                    
									
									<div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
									<input class="meanings" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php echo $m . ') ' . $ques_fet['question']; ?> 
									</div>
									<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
										&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
									</div>
									<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
									<?php echo $ques_fet['answer']; ?>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-0 col-xs-0">
									
									</div>
									
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
                                <h6><b>Opposites</b> <input type="checkbox" onClick="toggle(this,'opposites')" /> Check All / Uncheck All<br/></h6>
                                <?php
								$chapter="";
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$ques_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                         
										<div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
										<input class="opposites" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $ques_fet['question']; ?> 
										</div>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
											&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;
										</div>
										<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
										<?php echo $ques_fet['answer']; ?>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-0 col-xs-0">
										
										</div>
										
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
                                <h6><b>Fill Up</b> <input type="checkbox" onClick="toggle(this,'fillup')" /> Check All / Uncheck All<br/></h6>
                                <?php
								$chapter="";
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$ques_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="fillup" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
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
                                <h6><b>Choose</b>  <input type="checkbox" onClick="toggle(this,'choose')" /> Check All / Uncheck All<br/> </h6>
                                <?php
								$chapter="";
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$choose_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="choose" type="checkbox" name="questions[]" value="<?php echo $choose_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                <h6><b>True or False</b> <input type="checkbox" onClick="toggle(this,'trueorfalse')" /> Check All / Uncheck All<br/> </h6>
                                <?php
								$chapter="";
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$ques_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="trueorfalse" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
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
                                

								<h6><b>Match</b> <input type="checkbox" onClick="toggle(this,'match')" /> Check All / Uncheck All<br/> </h6>
                                <?php
								$chapter="";
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php 
										/*
										?>
										
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
									<?php */ ?>
									
									<?php
									$bank_id=$ques_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
									 <div class="row" style="margin-left: 20px;">
										
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										<input class="match" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $ques_fet['question']; ?>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo  $ques_ans_array[$m-1]; ?>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<b>Ans: </b><?php echo $ques_fet['answer']; ?>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-0 col-xs-0">
										
										</div>
										 
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
                                <h6><b>One or Two Words</b> <input type="checkbox" onClick="toggle(this,'oneortwo')" /> Check All / Uncheck All<br/></h6>
                                <?php
								$chapter="";
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$ques_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="oneortwo" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>

                                <?php
								$rand=rand(1, 3);
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Missing Letters'");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
                                    <h6><b>Missing Letters</b> <input type="checkbox" onClick="toggle(this,'missing')" /> Check All / Uncheck All<br/></h6>

                                    <?php
									$chapter="";
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
										$bank_id=$ques_fet['question_bank_id'];
										$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
										$chap_fet=mysql_fetch_assoc($chap_sql);
										
										if($chapter!=$chap_fet['chapter'])
										{
										$chapter=$chap_fet['chapter'];	
										echo "<strong>".$chapter."</strong>";
										}
										?>    
										<div class="row" style="margin-left: 20px;">
                                            <input class="missing" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $m . ') ' .$ques_fet['answer']; ?>
											<?php //echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?><?php //echo $m . ') ' . $str . ' - ' . $ques_fet['answer']; ?>
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
                                    <h6><b>Jumbled Words</b> <input type="checkbox" onClick="toggle(this,'jumbled')" /> Check All / Uncheck All<br/></h6>

                                    <?php
									$chapter="";
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
										<?php 
										$translatedWords = explode(' ',$ques_fet['question']); 
										shuffle($translatedWords);
										$translatedWords = implode(' ',$translatedWords); 
										?>
										<?php
										$bank_id=$ques_fet['question_bank_id'];
										$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
										$chap_fet=mysql_fetch_assoc($chap_sql);
										
										if($chapter!=$chap_fet['chapter'])
										{
										$chapter=$chap_fet['chapter'];	
										echo "<strong>".$chapter."</strong>";
										}
										?>
                                        <div class="row" style="margin-left: 20px;">
                                            <input class="jumbled" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $m . ') ' .$ques_fet['answer']; ?>
											<?php //echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?><?php //echo $m . ') ' . $translatedWords . ' - ' . $ques_fet['answer']; ?>
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
                                    <h6><b>Jumbled Letters</b> <input type="checkbox" onClick="toggle(this,'jumbledletter')" /> Check All / Uncheck All<br/></h6>

                                    <?php
									$chapter="";
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <?php
										$translatedWords = str_shuffle($ques_fet['question']);
										?>
										<?php
										$bank_id=$ques_fet['question_bank_id'];
										$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
										$chap_fet=mysql_fetch_assoc($chap_sql);
										
										if($chapter!=$chap_fet['chapter'])
										{
										$chapter=$chap_fet['chapter'];	
										echo "<strong>".$chapter."</strong>";
										}
										?>
										<div class="row" style="margin-left: 20px;">
                                            <input class="jumbledletter" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $m . ') ' .$ques_fet['answer']; ?>
											<?php //echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?><?php //echo $m . ') ' . $translatedWords . ' - ' . $ques_fet['answer']; ?>
                                        </div>
                                        <?php
                                        $m++;
                                    }
                                }
                                ?>

                                <?php
                                $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Dictation'");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    $m = 1;
                                    ?>
                                    <h6><b>Dictation</b> <input type="checkbox" onClick="toggle(this,'dictation')" /> Check All / Uncheck All<br/></h6>

                                    <?php
                                    $chapter="";
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <?php
                                        $bank_id=$ques_fet['question_bank_id'];
                                        $chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
                                        $chap_fet=mysql_fetch_assoc($chap_sql);

                                        if($chapter!=$chap_fet['chapter'])
                                        {
                                            $chapter=$chap_fet['chapter'];
                                            echo "<strong>".$chapter."</strong>";
                                        }
                                        ?>

                                        <div class="row" style="margin-left: 20px;">
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                                <input class="dictation" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo $m . ') '; ?>
                                                <audio controls style="width: 80%;">
                                                    <source src="<?php echo $ques_fet['question'];?>">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                                &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                                <?php echo $ques_fet['answer']; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-0 col-xs-0">

                                            </div>

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
                                        <input class="other" type="checkbox" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> ::: 
										<?php //if($m == 1){ ?>
                                        <h6><b><?php echo $ques_fet['other_type']; ?></b></h6>
                                        <?php //} ?>
                                        <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
							<?php */ ?>
							
							<?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Other' group by other_type");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                ?>
                                <h6 class="hidden"><b>Other</b> <input type="checkbox" onClick="toggle(this,'other')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    $otype = $ques_fet['other_type'];
                                    ?>
                                    <div class="row" style="margin-left: 0px;">
                                        <h6><b><?php echo $otype; ?></b></h6>
                                        <?php
										$other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                    <?php
									$chapter="";
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
										<?php
										$bank_id=$other_ques_fet['question_bank_id'];
										$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
										$chap_fet=mysql_fetch_assoc($chap_sql);
										
										if($chapter!=$chap_fet['chapter'])
										{
										$chapter=$chap_fet['chapter'];	
										echo "<strong>".$chapter."</strong>";
										}
										?>
                                        <div class="row" style="margin-left: 20px;">
										<?php if($otype=="rhyming words") { ?>
										
										<div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
										<input class="other" type="checkbox" name="questions[]" value="<?php echo $other_ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $other_ques_fet['question']; ?> 
										</div>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
											&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
										</div>
										<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
										<?php echo $other_ques_fet['answer']; ?>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-0 col-xs-0">
										
										</div>
										
										<?php } else { ?>
										
										<input class="other" type="checkbox" name="questions[]" value="<?php echo $other_ques_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer']; ?>
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
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <input type="hidden" name="class_id" value="<?php echo $ques_bank_fet['class_id']; ?>" />
											<input type="hidden" name="questionbank_id" value="<?php echo $questionbank_id; ?>" />
											<button type="submit" class="form-control btn btn-info" name="submit">Generate</button>
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
