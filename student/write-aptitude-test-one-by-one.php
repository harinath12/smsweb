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

$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from aptitude_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");

$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);


if(isset($_REQUEST['question_id'])) {
	$qid=$_REQUEST['question_id'];
}
else
{
	$qid_sql = mysql_fetch_array(mysql_query("SELECT * FROM `aptitude_test_question` WHERE `daily_test_id`='$test_id' ORDER BY question_id ASC"));
	
	$qid=$qid_sql['question_id'];
}


$daily_test_question_sql = "SELECT * FROM `aptitude_test_question` WHERE `daily_test_id`='$test_id' AND `question_id`='$qid'";

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
                        <li><a href="aptitude-test.php">Aptitude Test</a></li>
                        <li class="active">Write Aptitude Test</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-write-aptitude-test-one-by-one.php" method="POST" >
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
							
							
							   

                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where id IN ($questionbank_id) and question_type='Choose' ORDER BY RAND()");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Choose</b></h6>
                                <?php
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
										<?php
                                        $mean_ques = $choose_fet['question'];
                                        $mean_opt = " A) " . $choose_fet['optiona'] . "<br/> B) " . $choose_fet['optionb'] . "<br/> C) " . $choose_fet['optionc'] . "<br/> D) " . $choose_fet['optiond']. "<br/> E) " . $choose_fet['optione'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br><p style="padding:10px 50px">' . $mean_opt . '</p><br>';
                                        ?>
										<br/>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										</div>
									
									</div>
									<div class="row" style="margin-left: 20px;">
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
										
										</div>
										
										<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
										<input class="choose" type="hidden" name="questions[]" value="<?php echo $choose_fet['id']; ?>" /> 
										<!--
										<input class="choose" type="text" name="answers[<?php echo $choose_fet['id']; ?>]" value="" style="width:90%" /> 
										-->
										<select class="form-control" name="answers[<?php echo $choose_fet['id']; ?>]" style="width:90%" >
											<option value="">Answer</option>
											<option value="A">A</option>
											<option value="B">B</option>
											<option value="C">C</option>
											<option value="D">D</option>
											<option value="E">E</option>
										</select>	
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										
										</div>											
                                    
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
    						
							<br/><br/>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
										
										</div>
										<div class="col-md-2">
											<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
											<?php if(isset($_REQUEST['answer_id'])) { ?>
											<input type="hidden" name="answer_id" value="<?php echo $_REQUEST['answer_id']; ?>" />
											<?php } ?>
											<input type="hidden" name="test_id" value="<?php echo $test_id; ?>" />
											<input type="hidden" name="test_name" value="<?php echo $ques_bank_fet['daily_test_name']; ?>" />
											<button type="submit" class="form-control btn btn-info" name="submit">NEXT</button>
                                        </div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
										
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
