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
	header("Location: report-self-test.php?error=1");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
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



$ques_sql = "select * from self_test_answer where daily_test_id='$test_id' group by student_id order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);

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
                        <li><a href="report-self-test.php">Self Test Report</a></li>
                        <li class="active">Selft Test Report View</li>
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
										<input type="text" value="Class : <?php echo $ques_bank_fet['class_name']; ?> <?php echo $ques_bank_fet['section_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
                                        <input type="text" value="Subject : <?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
                                        <input type="text" value="Test Name : <?php echo $ques_bank_fet['daily_test_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
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
							
							
<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
							 </br>
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>STUDENT NAME</th>
                                    <th>TEST NAME</th>
                                    <th>MARK"S</th>
								</tr>
                                </thead>
                                <?php
                                if($ques_cnt>0)
                                {
                                    ?>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($ques_fet=mysql_fetch_array($ques_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
											<?php 
											$student_id=$ques_fet['student_id'];
											$student_query="SELECT name FROM `users` WHERE `id`='$student_id'";
											$student_query_exe=mysql_query($student_query);
											$student_query_fet=mysql_fetch_assoc($student_query_exe);
											
											echo $student_query_fet['name']; 
											?>
											</td>
                                            <td><?php echo $ques_fet['daily_test_name'] ?></td>
                                            <td>
											<?php
											$std_ques_sql = "select * from self_test_answer where daily_test_id='$test_id' AND `student_id`='$student_id' order by id asc";
											$std_ques_exe = mysql_query($std_ques_sql);
												
											/*
											while($std_ques_fet=mysql_fetch_array($std_ques_exe))
												{
													$std_ques_id[]=$std_ques_fet['id'];
												}
											$daily_test_answer_id=implode(',',$std_ques_id);
											echo $mark_query="SELECT SUM(daily_test_mark) AS mark FROM `daily_test_question_answer` WHERE `daily_test_answer_id` IN($daily_test_answer_id) AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
											*/
											
											while($std_ques_fet=mysql_fetch_array($std_ques_exe))
												{
												$daily_test_answer_id=$std_ques_fet['id'];
												
												$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `self_test_question_answer` WHERE `daily_test_answer_id`='$daily_test_answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
												$mark_query_exe=mysql_query($mark_query);
												$mark_query_fet=mysql_fetch_assoc($mark_query_exe)
											?>
											<a href="report-self-test-answer-view.php?test_id=<?php echo $test_id; ?>&answer_id=<?php echo $daily_test_answer_id; ?>" title="<?php echo $std_ques_fet['created_at']; ?>">
											<button type="button" class="btn btn-info btn-xs"><?php echo $mark_query_fet['mark']; ?> </button>
											</a>
											<?php		
												}
											?>
											
											</td>
										</tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table> 
						</div>
                        <!-- /basic datatable -->

                    </div>
                </div>
							
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
                        width: '10%',
                        targets: 0
                    },
					{
                        width: '25%',
                        targets: 1
                    },
					{
                        width: '25%',
                        targets: 2
                    },
                    {
                        width: '40%',
                        targets:3
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
	
</script>
</html>
