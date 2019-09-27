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
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
		.panel-body {
			margin:0 15px;
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
                <li><a href="home-work.php">Home Work</a></li>
				<li class="active">Preview Test View</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- basic datatable -->
					
            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
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
										<b>Ans:</b><?php echo $choose_fet['answer']; ?>
										<br/><br/>
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
							
								$$ques_ans_array = "";
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
										<br/><br/>
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
                                        
										<?php echo $m . ') ' . $ques_fet['answer']; ?> 
										
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
                                    
										<?php echo $m . ') ' . $ques_fet['question']; ?>
									
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
                                        <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2">
                                            &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $ques_fet['answer']; ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                        </div>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>


                            <?php /* ?>
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
                                        <h6><b><?php echo $ques_fet['other_type']; ?></b></h6>
                                        <?php } ?>
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<b>Ans:</b><?php echo $ques_fet['answer']; ?>
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
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                    <?php
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
										
										<?php if($otype=="rhyming words") { ?>
										
										<div class="col-lg-2 col-md-2 col-sm-5 col-xs-5">
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
										<?php echo $m . ') ' . $other_ques_fet['question']; ?>
										<br/>
										<b>Ans:</b><?php echo $other_ques_fet['answer']; ?>
										<br/><br/>
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
 

            </div>
            <!-- /content area -->

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

        });
    } );
</script>

</body>
</html>
