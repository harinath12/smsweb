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
	header("Location: self-test.php?error=1");
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
<body style="display:none;">
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
                        <li><a href="self-test.php">Self Test</a></li>
						<li><a href="create-self-test.php">Create Self Test</a></li>
                        <li class="active">Self Test View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-self-test.php" method="POST" id="self-test-form" name="self-test-form" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class</label>
                                        <div class="col-md-8">
											<input type="text" name="class_name" value="<?php echo $className.' - '.$sectionName; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject</label>
                                        <div class="col-md-8">
                                            <input type="text" name="subject_name" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Test Name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_name" value="<?php echo $ques_bank_fet['class_name']; ?>-<?php echo $ques_bank_fet['subject_name']; ?>-<?php echo date("Y-m-d"); ?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Remarks</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_remark" value="" class="form-control" />
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
                                <h6><b>Meanings</b> <input type="checkbox" checked="checked" onClick="toggle(this,'meanings')" /> Check All / Uncheck All<br/></h6>
								                            
                                <?php
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <div class="row" style="margin-left: 20px;">
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
                                <h6><b>Opposites</b> <input type="checkbox" checked="checked" onClick="toggle(this,'opposites')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
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
                                <h6><b>Fill Up</b> <input type="checkbox" checked="checked" onClick="toggle(this,'fillup')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
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
                                <h6><b>Choose</b>  <input type="checkbox" checked="checked" onClick="toggle(this,'choose')" /> Check All / Uncheck All<br/> </h6>
                                <?php
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
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
                                <h6><b>True or False</b> <input type="checkbox" checked="checked" onClick="toggle(this,'trueorfalse')" /> Check All / Uncheck All<br/> </h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
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
							
								$$ques_ans_array = "";
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
                                

								<h6><b>Match</b> <input type="checkbox" checked="checked" onClick="toggle(this,'match')" /> Check All / Uncheck All<br/> </h6>
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
									 <div class="row" style="margin-left: 20px;">
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
                                <h6><b>One or Two Words</b> <input type="checkbox" checked="checked" onClick="toggle(this,'oneortwo')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
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
                                    <h6><b>Missing Letters</b> <input type="checkbox" checked="checked" onClick="toggle(this,'missing')" /> Check All / Uncheck All<br/></h6>

                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
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
                                    <h6><b>Jumbled Words</b> <input type="checkbox" checked="checked" onClick="toggle(this,'jumble')" /> Check All / Uncheck All<br/></h6>

                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
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
                                    <h6><b>Jumbled Letters</b> <input type="checkbox" checked="checked" onClick="toggle(this,'jumbleletter')" /> Check All / Uncheck All<br/></h6>

                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
                                            <input class="jumbleletter" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
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
                                    <h6><b>Dictation</b> <input type="checkbox" checked="checked" onClick="toggle(this,'dictation')" /> Check All / Uncheck All<br/></h6>

                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
                                            <input class="dictation" type="checkbox" name="questions[]" checked="checked" value="<?php echo $ques_fet['id']; ?>" style="display:none;" /> ::: <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
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
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id IN ($questionbank_id) and question_type='Other' group by other_type");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                ?>
                                <h6><b>Other</b> <input type="checkbox" checked="checked" onClick="toggle(this,'other')" /> Check All / Uncheck All<br/></h6>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    $otype = $ques_fet['other_type'];
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <h6><b><?php echo $otype; ?></b></h6>
                                        <?php
                                        $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                    <?php
                                    $m = 1;
                                    while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                        ?>
                                        <div class="row" style="margin-left: 20px;">
										<input class="other" type="checkbox" name="questions[]" checked="checked" value="<?php echo $other_ques_fet['id']; ?>" style="display:none;" /> ::: 
                                        <?php echo $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer']; ?>
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
										<?php
										$class_id=$ques_bank_fet['class_id'];
										$section_query="SELECT * FROM `class_section` WHERE `class_id` = '$class_id' AND `section_name`='$sectionName'";
										$section_exe = mysql_query($section_query);
										$section_fet = mysql_fetch_assoc($section_exe)
                                        ?>
											<input type="hidden" name="section_id" value="<?php echo $section_fet['id']; ?>" />
										
                                            <input type="hidden" name="class_id" value="<?php echo $ques_bank_fet['class_id']; ?>" />
											
											<input type="hidden" name="questionbank_id" value="<?php echo $questionbank_id; ?>" />
											<button type="submit" class="form-control btn btn-info" name="BtnSubmit">Generate</button>
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
<script>

window.onload = function(){
  document.forms['self-test-form'].submit();
}

</script>
</html>
