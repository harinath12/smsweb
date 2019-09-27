<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}


if(isset($_REQUEST['test_id']))
{
$maths_test_id = $_REQUEST['test_id'];
}
else
{
	header("Location: self-test.php?error=1");
}


include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/* CREATE TEST # START * /

$student_sql = "select aca.class as classID, aca.section_name from student_academic as aca
left join class_section as cs on cs.class_id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$classID = $student_fet['classID'];
//$sectionID = $student_fet['sectionID'];
$sectionID = 1;

$create_maths_test = "INSERT INTO `maths_test` 
			   (`student_id`, `class_id`, `subject_name`, `section_id`, `daily_test_name`, `daily_test_remark`, `daily_test_chapters`, `daily_test_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
			   VALUES 
			   ('$user_id', '$classID', 'Maths', '1', 'Maths Test', 'None', '', '1', 'Student', 'Student', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $create_maths_test;

$create_maths_test_exe = mysql_query($create_maths_test);

$maths_test_id = mysql_insert_id();
			   

#TYPE-1
$number_array = array(0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine'); 
$randIndex = array_rand($number_array);

$maths_test_type = 1;
$maths_test_question = "Wrire the Number Name : ".$randIndex." = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


#TYPE-2
$number_array = array(0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine'); 
$randIndex = array_rand($number_array);

$maths_test_type = 2;
$maths_test_question = "Wrire in Numerals: ".$number_array[$randIndex]." = ";
$maths_test_answer = $randIndex;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-3
$number_array = array(2=>'10',3=>'100',4=>'1000',5=>'10000'); 
$randIndex = array_rand($number_array);

$maths_test_type = 3;
$maths_test_question = "Smallest ".$randIndex." digit no = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-4
$number_array = array(1=>'9',2=>'99',3=>'999',4=>'9999',5=>'99999'); 
$randIndex = array_rand($number_array);

$maths_test_type = 4;
$maths_test_question = "Largest ".$randIndex." digit no = ";
$maths_test_answer = $number_array[$randIndex];
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);

#TYPE-5

$randValue = rand(10,100);
$randValuebefore = $randValue-1;

$maths_test_type = 5;
$maths_test_question = "What comes before : ".$randValue." = ";
$maths_test_answer = $randValuebefore;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


#TYPE-6

$randValue = rand(10,100);
$randValuebefore = $randValue+1;

$maths_test_type = 6;
$maths_test_question = "What comes after : ".$randValue." = ";
$maths_test_answer = $randValuebefore;
$insert_maths_test = "INSERT INTO `maths_test_answer` 
                      (`student_id`, `maths_test_id`, `maths_test_type`, `maths_test_question`, `maths_test_answer`, `maths_test_status`, `created_at`, `updated_at`) 
					  VALUES 
					  ('$user_id', '$maths_test_id', '$maths_test_type', '$maths_test_question', '$maths_test_answer', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000')";

//echo $insert_maths_test."<hr>";

$insert_maths_test_exe = mysql_query($insert_maths_test);


			   
			   
//echo $create_test;			   
//exit;
/* CREATE TEST # END */

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];




$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from maths_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$maths_test_id");

$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);
/*


$daily_test_question_sql = "SELECT * FROM `maths_test_question` WHERE `daily_test_id`='$test_id'";

$daily_test_question_exe = mysql_query($daily_test_question_sql);


while($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe))
{
	$questionbank_id_array[] = $daily_test_question_fetch['question_id'];
}

$questionbank_id=implode(",",$questionbank_id_array);
*/
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
                        <li><a href="maths-test.php">Maths Test</a></li>
                        <li class="active">Write Maths Test</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-write-maths-test.php" method="POST" >
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                        <input type="text" value="Test Name : <?php echo $ques_bank_fet['daily_test_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                        </div>
                                        <div class="col-md-3">
										<?php 										
										$mark_query="SELECT COUNT(id) AS mark FROM `maths_test_answer` WHERE `maths_test_id`='$maths_test_id'";
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
							

							
                                <h6><b>Questions</b></h6>
							<?php
							$ques_sql=mysql_query("SELECT * FROM `maths_test_answer` WHERE `maths_test_id` IN ($maths_test_id)");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
								                            
                                <?php
                            while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                ?>
                                <div class="row" style="margin-left: 20px;margin-bottom: 10px;">
								
									<div class="col-lg-4 col-md-4 col-sm-2 col-xs-6">
									<?php echo $m . ') ' . $ques_fet['maths_test_question']; ?> 
									</div>
									<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
									-&nbsp;&nbsp;&nbsp;
									<input class="meanings" type="hidden" name="questions[]" value="<?php echo $ques_fet['id']; ?>" /> 
									<input class="meanings" type="hidden" name="question_answer[<?php echo $ques_fet['id']; ?>]" value="<?php echo $ques_fet['maths_test_answer']; ?>" /> 
									<input class="meanings" type="text" name="answers[<?php echo $ques_fet['id']; ?>]" value="" style="width:90%" /> 
									</div>
									<div class="col-lg-4 col-md-4 col-sm-2 col-xs-0">
									
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
