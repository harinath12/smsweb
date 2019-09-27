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

$ques_bank_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
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
                        <li><a href="question-bank.php">Question Bank</a></li>
                        <li class="active">Question Bank Edit</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <?php /* ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class <span class="req"> *</span></label>
                                        <div class="col-md-8">
                                            <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" name="className" readonly/>
                                            <input type="hidden" class="form-control" name="classId" id="classId" value="<?php echo $classId;?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject <span class="req"> *</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                <option value="">Select Subject</option>
                                                <?php
                                                foreach($sub_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['subject_name']; ?>" <?php if($ques_bank_fet['subject_name'] == $value['subject_name']){ echo 'selected'; }?>><?php echo $value['subject_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Term <span class="req"> *</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="term" id="term" required>
                                                <option value="">Select Term</option>
                                                <option value="Term 1" <?php if($ques_bank_fet['term'] == 'Term 1'){ echo 'selected'; }?>>Term 1</option>
                                                <option value="Term 2" <?php if($ques_bank_fet['term'] == 'Term 2'){ echo 'selected'; }?>>Term 2</option>
                                                <option value="Term 3" <?php if($ques_bank_fet['term'] == 'Term 3'){ echo 'selected'; }?>>Term 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Chapter <span class="req"> *</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control chapter" name="chapter" id="chapter" required>
                                                <option value="">Select Chapter</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
  <?php */ ?>

                            <form action="doupdatequestionbank.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="questionbankid" value="<?php echo $questionbank_id; ?>" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4">Class</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4">Subject</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4">Term</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['term']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4">Chapter</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $ques_bank_fet['chapter']; ?>" class="form-control" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row meaning-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Meanings</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-meaning" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Meanings'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="meanquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldmeanquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldmeananswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="meanquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="meananswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row opposite-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Opposites</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-opposite" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Opposites'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="oppoquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldoppoquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldoppoanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="oppoquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="oppoanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row fill-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Fill Up</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-fill" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Fill Up'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="fillquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldfillquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldfillanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="fillquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="fillanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
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
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Choose'");
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
                                                <div class="col-lg-1">
                                                    <label style="float: right;">Ans:</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" name="oldchooseans[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="Answer"/>
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
                                        <div class="col-lg-1">
                                        <label style="float: right;">Ans:</label>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="chooseans[]" placeholder="Answer"/>
                                        </div>
                                        </div>
                                        </br>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row true-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>True or False</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-true" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='True or False'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="truequestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldtruequestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldtrueanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="truequestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="trueanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row match-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Match</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-match" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Match'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="matchquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldmatchquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldmatchanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="matchquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="matchanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row ques-ans-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>One or Two Words</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-ques-ans" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='One or Two Words'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <input type="hidden" class="form-control" name="quesid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                <div class="col-lg-5">
                                                    <textarea name="oldquesword[]" class="form-control" placeholder="Question"><?php echo $ques_fet['question']; ?></textarea>
                                                </div>
                                                <div class="col-lg-6">
                                                    <textarea name="oldansword[]" class="form-control" placeholder="answer"><?php echo $ques_fet['answer']; ?></textarea>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <textarea name="quesword[]" class="form-control" placeholder="Question"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea name="answord[]" class="form-control" placeholder="answer"></textarea>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row missing-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Missing Letters</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-missing" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Missing Letters'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="missingquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldmissingquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldmissinganswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="missingquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="missinganswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row jumble-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Jumbled Words</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-jumble" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Jumbled Words'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="jumblequestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldjumblequestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldjumbleanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="jumblequestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="jumbleanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row jumbleletter-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Jumbled Letters</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-jumbleletter" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Jumbled Letters'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="jumbleletterquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control" name="oldjumbleletterquestion[]" value="<?php echo $ques_fet['question']; ?>" placeholder="Question"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="oldjumbleletteranswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" name="jumbleletterquestion[]" placeholder="Question"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="jumbleletteranswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row dictation-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Dictation</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-dictation" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Dictation'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        $q = 0;
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){

                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <input type="hidden" class="form-control" name="dicquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="file" class="form-control" name="olddicquestion[]" placeholder="Question" accept="audio/*"/>
                                                    <audio controls>
                                                        <source src="<?php echo $ques_fet['question'];?>">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="olddicanswer[]" value="<?php echo $ques_fet['answer']; ?>" placeholder="answer"/>
                                                </div>
                                            </div>
                                        <?php
                                            $q++;
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="hidden" class="form-control" name="newdicquestionId[]">
                                                <input type="file" class="form-control" name="dicquestion[]" placeholder="Question" accept="audio/*"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="dicanswer[]" placeholder="answer"/>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row other-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Other</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-other" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Other' group by other_type");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            $otype = $ques_fet['other_type'];
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php
                                                $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and other_type='$otype'");
                                                $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                                ?>
                                                <?php
                                                while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                                    ?>
                                                    <div class="row">
                                                        <input type="hidden" class="form-control" name="otherquestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control othertype0" name="oldothertype[]" value="<?php echo $other_ques_fet['other_type']; ?>" placeholder="Question Type"/>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-bottom: 5px;">
                                                        <div class="col-lg-5">
                                                            <textarea class="form-control" name="oldotherquestion[]" placeholder="Question"><?php echo $other_ques_fet['question']; ?></textarea>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <textarea class="form-control" name="oldotheranswer[]" placeholder="Answer"><?php echo $other_ques_fet['answer']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control othertype0" name="othertype[]" placeholder="Question Type"/>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 5px;">
                                            <div class="col-lg-5">
                                                <textarea class="form-control" name="otherquestion[]" placeholder="Question"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" name="otheranswer[]" placeholder="Answer"></textarea>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" class="btn btn-info add-other" title="Add More">+</button>
                                            </div>
                                        </div>
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
        $('.add-meaning').click(function(event){
            event.preventDefault();
            var newRow1 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="meanquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="meananswer[]"/> </div> </div>');
            $('.meaning-row').append(newRow1);
        });
    });

    $(function(){
        $('.add-opposite').click(function(event){
            event.preventDefault();
            var newRow2 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="oppoquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="oppoanswer[]"/> </div> </div>');
            $('.opposite-row').append(newRow2);
        });
    });

    $(function(){
        $('.add-fill').click(function(event){
            event.preventDefault();
            var newRow3 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="fillquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="fillanswer[]"/> </div> </div>');
            $('.fill-row').append(newRow3);
        });
    });

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
            '<div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> ' +
            '<div class="col-lg-2"> <input type="text" class="form-control" placeholder="Answer" name="chooseans[]"/> </div> ' +
            '</div> </br>');
            $('.choose-row').append(newRow);
        });
    });

    $(function(){
        $('.add-match').click(function(event){
            event.preventDefault();
            var newRow4 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="matchquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="matchanswer[]"/> </div> </div>');
            $('.match-row').append(newRow4);
        });
    });

    $(function(){
        $('.add-true').click(function(event){
            event.preventDefault();
            var newRow5 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="truequestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="trueanswer[]"/> </div> </div>');
            $('.true-row').append(newRow5);
        });
    });

    $(function(){
        $('.add-ques-ans').click(function(event){
            event.preventDefault();
            var newRow6 = $('<div class="row"> <div class="col-lg-5"> ' +
            '<textarea class="form-control" placeholder="question" name="quesword[]"></textarea> </div> ' +
            '<div class="col-lg-6"> <textarea class="form-control" placeholder="answer" name="answord[]"></textarea> </div> </div>');
            $('.ques-ans-row').append(newRow6);
        });
    });

    $(function(){
        $('.add-missing').click(function(event){
            event.preventDefault();
            var newRow4 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="missingquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="missinganswer[]"/> </div> </div>');
            $('.missing-row').append(newRow4);
        });
    });

    $(function(){
        $('.add-jumble').click(function(event){
            event.preventDefault();
            var newRow4 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="jumblequestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="jumbleanswer[]"/> </div> </div>');
            $('.jumble-row').append(newRow4);
        });
    });

    $(function(){
        $('.add-jumbleletter').click(function(event){
            event.preventDefault();
            var newRow4 = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="text" class="form-control" placeholder="Question" name="jumbleletterquestion[]"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="jumbleletteranswer[]"/> </div> </div>');
            $('.jumbleletter-row').append(newRow4);
        });
    });

    $(function(){
        $('.add-dictation').click(function(event){
            event.preventDefault();
            var newRowdic = $('<div class="row"> <div class="col-lg-5">' +
            '<input type="hidden" class="form-control" name="newdicquestionId[]" />' +
            '<input type="file" class="form-control" placeholder="Question" name="dicquestion[]" accept="audio/*"/> </div> '+
            '<div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="dicanswer[]"/> </div> </div>');
            $('.dictation-row').append(newRowdic);
        });
    });

    $(function(){
        var counter = 1;
        $('.add-other').click(function(event){
            event.preventDefault();
            var o =counter - 1;
            var otype = $('.othertype'+ o).val();

            var newRow7 = $('<div class="row"> ' +
            '<div class="col-lg-6">'+
            '<input type="text" class="form-control othertype'+counter+'" value="'+otype+'" name="othertype[]" placeholder="Question Type"/>'+
            '</div>'+
            '</div>'+
            '<div class="row" style="margin-bottom: 5px;">'+
            '<div class="col-lg-5">'+
            '<textarea class="form-control" placeholder="Question" name="otherquestion[]"></textarea>'+
            '</div>'+
            '<div class="col-lg-6">'+
            '<textarea class="form-control" placeholder="answer" name="otheranswer[]"></textarea>'+
            '</div>'+
            '</div>');
            counter++;
            $('.other-row').append(newRow7);
        });
    });
</script>
</html>
