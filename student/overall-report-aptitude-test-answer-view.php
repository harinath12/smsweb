<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

if(isset($_SESSION['adminuserid']))
{
$student_id = $_SESSION['adminuserid'];
}
else 
{
	header("Location: aptitude-test.php?error=1");
}

if(isset($_REQUEST['test_id']))
{
$test_id = $_REQUEST['test_id'];
}
else
{
	header("Location: aptitude-test.php?error=1");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");


$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from aptitude_test as qb
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
                        <li><a href="aptitude-test.php">Aptitude Test Report</a></li>
						<li class="active">Report Aptitude Test Answer View</li>
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
										$mark_query="SELECT COUNT(id) AS mark FROM `aptitude_test_question` WHERE `daily_test_id`='$test_id'";
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
							 
							
							
							<!-- START -->

							<style>
							table td.test-cols span { width:10px; }
							div.dataTables_wrapper { width:90%; }
							</style>
							<?php
							$ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where id IN ($questionbank_id)");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0)
							{
                            $m = 1;
                                ?>
								<table class="table datatable">
                                <thead>
                                <tr>
									<th>S.No.</th>
									<th>QUESTION & ANSWER</th>
									<th class="test-cols">
									<p>YOUR ANSWERS</p>
									<p>
										<?php
										$t=0;
										$ans_query= "SELECT * FROM `aptitude_test_answer` WHERE `daily_test_id`='$test_id' AND `student_id`='$student_id' ORDER BY `id` ASC";
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
											<?php echo "CA"; ?>
										</span>
									</th>
									<th class="test-cols">
										<span style="color:red;">
											<?php echo "WA"; ?>
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
										<?php
										$mean_ques = $choose_fet['question'];
										if($choose_fet['question_type']=="Choose") 
										{
											$mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond']. " E) " . $choose_fet['optione'];
                                            echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
										}

                                        ?>
										<b>Answer:</b><?php echo $choose_fet['answer']; ?>
										<br/><br/>
										</td>
										<td>
										<?php
										$qid=$choose_fet['id'];
										$correct=0;
										$wrong=0;
										$none=0;
										$ans_query= "SELECT * FROM `aptitude_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' ORDER BY `daily_test_answer_id` ASC";
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
										$wrong++; 
										?>
										<span style="color:red;">
										<i class="fa fa-times"></i>
										</span>
										<?php } ?>
										
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
                            <?php 
							}
                            ?>
							</table>
							<!-- END -->
							
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
                        width: '30%',
                        targets: 3
                    },
                    {
                        width: '5%',
                        targets: [4,5]
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
