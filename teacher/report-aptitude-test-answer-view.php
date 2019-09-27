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
	header("Location: aptitude-test.php?error=1");
}

if(isset($_REQUEST['answer_id']))
{
$answer_id = $_REQUEST['answer_id'];
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
    <title>SMS - Teacher</title>
    <?php include "head-inner.php"; ?>
	<style>
	p.red-color { color:red; }
        p{
            margin : 2px 0px;
        }
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
                        <li><a href="aptitude-test.php">Aptitude Test</a></li>
						<li><a href="report-aptitude-test.php">Aptitude Test Report</a></li>
                        <li><a href="report-aptitude-test-answer.php?test_id=<?php echo $test_id; ?>">Aptitude Test Report Answer</a></li>
                        <li class="active">Aptitude Test Answer View</li>
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
										<?php
										$ans_query= "SELECT * FROM `aptitude_test_answer` WHERE `daily_test_id`='$test_id' AND `id`='$answer_id'";
										$ans_query_exe=mysql_query($ans_query);
										$ans_query_fet=mysql_fetch_assoc($ans_query_exe);

										$student_id=$ans_query_fet['student_id'];
										$student_query="SELECT name FROM `users` WHERE `id`='$student_id'";
										$student_query_exe=mysql_query($student_query);
										$student_query_fet=mysql_fetch_assoc($student_query_exe);
										?>
										<input type="text" value="Student : <?php echo $student_query_fet['name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
										<div class="col-md-3">
										&nbsp;
                                        </div>
										<div class="col-md-3">
                                        &nbsp;
										</div>
									</div>
								</div>
							</div>
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
										$mark_question_query="SELECT COUNT(daily_test_mark) AS mark FROM `aptitude_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
										$mark_question_query_exe=mysql_query($mark_question_query);
										$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
										
										$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `aptitude_test_question_answer` WHERE `daily_test_answer_id`='$answer_id'";
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
							 
                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where id IN ($questionbank_id) and question_type='Choose'");
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
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond']. " E) " . $choose_fet['optione'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                        ?>
                                        <b>Ans:</b><?php echo $choose_fet['answer']; ?>
                                        </br>
                                        <?php
                                        $qid=$choose_fet['id'];
                                        $ans_query= "SELECT * FROM `aptitude_test_question_answer` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid' AND `daily_test_answer_id`='$answer_id'";
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
