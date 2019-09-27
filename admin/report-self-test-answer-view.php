<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_REQUEST['answer_id']))
{
    $answer_id = $_REQUEST['answer_id'];
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
                                    $ans_query= "SELECT * FROM `self_test_answer` WHERE `daily_test_id`='$test_id' AND `id`='$answer_id'";
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
                        </div>


                    </div>


                    <!-- START -->

                    <style>
                        table td.test-cols span { width:10px; }
						div.dataTables_wrapper { width:90%; }
                    </style>
					<p id="table-filter" style="display:none;float: right;width: 200px;">
					Search: 
					<select class="form-control">
					<option value="">All</option>
					<option>Correct</option>
					<option>Wrong</option>
					</select>
					</p>
                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id)");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0)
                    {
                        $m = 1;
                        ?>
                        <table class="table datatable">
                            <thead class="hidden">
                        <tr>
                            <th class="hidden">S.No.</th>
                            <th class="hidden">TYPE</th>
                            <th>QUESTION & ANSWER</th>
                            <th class="test-cols">
							<p>YOUR ANSWERS</p>
							<p>
								<?php
								/*
								$ans_query_test_id = "";
                                $t=0;
                                $ans_query= "SELECT * FROM `daily_test_answer` WHERE `daily_test_id`='$test_id' AND `student_id`='$student_id' ORDER BY `id` ASC";
                                $ans_query_exe=mysql_query($ans_query);
                                while($ans_query_fet=mysql_fetch_assoc($ans_query_exe))
                                {
                                    $ans_query_test_id[] = $ans_query_fet['id'];
                                    $t++;
                                    ?>
                                    <span style="width:20px;">
										<?php echo "T".$t; ?>
									</span>
                                <?php
                                }
								$ans_query_test_ids = implode(",",$ans_query_test_id);
                                */
                               
								$ans_query_test_ids = $answer_id;
                                
								?>
							</p>
							
							</th>
							<th>
								MARK
							</th>
							<th class="test-cols hidden">
								REMARK
							</th> 
							
                        </tr>
                        </thead>
                        <tbody>
 
                            <?php
                            $i =1;
                            while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
								<?php
								if($question_type == $choose_fet['question_type']) 
									{	
									
									}
									else
									{
										$m=1;
										?>
											<tr>
											<td class="hidden">
											<?php echo $i++; ?>
											<?php //echo $choose_fet['question_type']; ?> 
											</td>
											<td class="hidden">
											<?php //echo $choose_fet['question_type']; ?> 
											</td>
											<td>
											<b><?php echo $choose_fet['question_type']; ?> </b>
											</td>
											<td>
											<?php //echo $choose_fet['question_type']; ?> 
											</td>
											<td>
											<?php //echo $choose_fet['question_type']; ?> 
											</td>
											<td class="hidden">
											<?php //echo $choose_fet['question_type']; ?> 
											</td>
											</tr>										
										<?php
									}
									$question_type = $choose_fet['question_type'];
							?>
                                <tr>
                                    <td class="hidden"><?php echo $i++; ?></td>
                                    <td class="hidden">
                                        <?php echo $choose_fet['question_type']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $mean_ques = $choose_fet['question'];
                                        if($choose_fet['question_type']=="Choose")
                                        {
                                            $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                            echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
											?>										
											<b>Answer:</b><?php echo $choose_fet['answer']; ?>
											<br/><br/>
											<?php
                                        }
                                        else if($choose_fet['question_type']=="Dictation")
                                        {
                                            ?>
                                            <audio controls style="width: 80%;">
                                                <source src="<?php echo '../teacher/' . $choose_fet['question'];?>">
                                                Your browser does not support the audio element.
                                            </audio>
											<b>Answer:</b><?php echo $choose_fet['answer']; ?>
											<br/><br/>
										<?php
                                        }
                                        else
                                        {
                                            $mean_opt = "";
											$mean_opt = $choose_fet['answer'];
											echo $m . ') ' . $mean_ques . ' :: ' . $mean_opt . '<br>';
                                        }
                                        ?> 
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
                                             echo $ans_query_fet['answer'];
										
											$daily_test_mark = $ans_query_fet['daily_test_mark'];
											 
											if($ans_query_fet['daily_test_mark']==1) { $correct++; } else { $wrong++; } 
											
                                        }
                                        ?>
                                    </td>
                                    <td>
									<b>Mark:</b> <?php echo $daily_test_mark; ?>
									</td>
									<td class="hidden">
										<?php if($correct==1) { ?>
											<span style="color:green;">
											Correct
											</span>
										<?php } ?>
										<?php if($wrong==1) { ?>
											<span style="color:red;">
											Wrong
											</span>
										<?php } ?>	
											
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

/*
    $(function() {
        $('.datatable').DataTable({
			paging:   false,
			displayLength: 10000,
			dom: 'lr<"table-filter-container">tip',
			initComplete: function(settings){
			  var api = new $.fn.dataTable.Api( settings );
			  $('.table-filter-container', api.table().container()).append(
				 $('#table-filter').detach().show()
			  );
			  
			  $('#table-filter select').on('change', function(){
				 alert(this.value);  
				 table.search(this.value).draw();   
			  });       
			}
        });
    });
*/
$(document).ready(function (){
    var table = $('.datatable').DataTable({
       paging: false,
       dom: 'lr<"table-filter-container">tip',
       initComplete: function(settings){
          var api = new $.fn.dataTable.Api( settings );
          $('.table-filter-container', api.table().container()).append(
             $('#table-filter').detach().show()
          );
          
          $('#table-filter select').on('change', function(){
             table.search(this.value).draw();   
          });       
       }
    });
    
});
</script>

</body>
</html>
