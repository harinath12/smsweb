<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$questionbank_id = $_REQUEST['question_id'];

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql); 
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$ques_bank_sql = mysql_query("select qb.*, c.class_name from aptitude_question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id='$questionbank_id'");
$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

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
                        <li><a href="aptitude-question-bank.php">Aptitude Question Bank</a></li>
                        <li class="active">Aptitude Question Bank Edit</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body"> 
						
                            <form action="doupdateaptitudequestionbank.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="questionbankid" value="<?php echo $questionbank_id; ?>" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-4">Class</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>
									</div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-4">Subject</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-4">Chapter</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['chapter']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row choose-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Choose</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-choose" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where question_bank_id='$questionbank_id' and question_type='Choose'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input type="hidden" class="form-control" name="choosequestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldchooseques[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldoptiona[]" value="<?php echo $ques_fet['optiona']; ?>" placeholder="Option A"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldoptionb[]" value="<?php echo $ques_fet['optionb']; ?>" placeholder="Option B"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldoptionc[]" value="<?php echo $ques_fet['optionc']; ?>" placeholder="Option C"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldoptiond[]" value="<?php echo $ques_fet['optiond']; ?>" placeholder="Option D"/>
                                                </div>
												<div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldoptione[]" value="<?php echo $ques_fet['optione']; ?>" placeholder="Option E"/>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label style="float: right;">Ans:</label>
                                                </div>
                                                <div class="col-lg-1">
													<select class="form-control" name="oldchooseans[]" required>
														<option value="">Answer</option>
														<option value="A" <?php if($ques_fet['answer']=="A") { echo "selected"; } ?>>A</option>
														<option value="B" <?php if($ques_fet['answer']=="B") { echo "selected"; } ?>>B</option>
														<option value="C" <?php if($ques_fet['answer']=="C") { echo "selected"; } ?>>C</option>
														<option value="D" <?php if($ques_fet['answer']=="D") { echo "selected"; } ?>>D</option>
														<option value="E" <?php if($ques_fet['answer']=="E") { echo "selected"; } ?>>E</option>
													</select>	
												</div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="chooseques[]" placeholder="Question"/>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optiona[]" placeholder="Option A"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optionb[]" placeholder="Option B"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optionc[]" placeholder="Option C"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optiond[]" placeholder="Option D"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optione[]" placeholder="Option E"/>
                                        </div>
                                        <div class="col-lg-1">
                                        <label style="float: right;">Ans:</label>
                                        </div>
										<div class="col-lg-2">
											<select class="form-control" name="chooseans[]" required>
												<option value="">Answer</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>	
										</div>
                                        </div>
                                        </br>
                                    <?php
                                    }
                                    ?>
                                </div>
 
								<div class="form-group">
                                    <div class="col-lg-2">
                                        <input type="submit" value="OK" class="btn btn-info form-control"/>
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

<script> 

    $(function(){
        $('.add-choose').click(function(event){
            event.preventDefault();

            var newRow = $('<div class="row" style="margin-bottom:10px;"> ' +
            '<div class="col-lg-10"> <input type="text" class="form-control" placeholder="Question" name="chooseques[]"/> </div> </div> ' +
            '<div class="row">' +
            '<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option A" name="optiona[]"/> </div> ' +
            '<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option B" name="optionb[]"/> </div> ' +
            '<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option C" name="optionc[]"/> </div> ' +
            '<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option D" name="optiond[]"/> </div> ' +
			'<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option E" name="optione[]"/> </div> ' +
            '<div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> ' +
            '<div class="col-lg-1"> <select class="form-control" name="chooseans[]" required><option value="">Answer</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option></select></div> ' +
            '</div> </br>');
            $('.choose-row').append(newRow);
        });
    });
 
</script>
</html>
