<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT distinct c.* FROM `class_section` as cs LEFT JOIN classes as c on c.id = cs.class_id where c.class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

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
        span.req{
            color: red;
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
                        <li><a href="question-bank.php"> Question Bank</a></li>
                        <li class="active">Add Question Bank</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">

                            <form action="dosavequestionbank.php" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="className" value="<?php echo $className;?>" readonly/>
                                            <input type="hidden" class="form-control" name="classId" id="classId" value="<?php echo $classId;?>" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                <option value="">Select Subject</option>
                                                <?php
                                                foreach($sub_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['subject_name']; ?>"><?php echo $value['subject_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="term" id="term" required>
                                                <option value="">Select Term</option>
                                                <option value="Term 1">Term 1</option>
                                                <option value="Term 2">Term 2</option>
                                                <option value="Term 3">Term 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control chapter" name="chapter" id="chapter" required>
                                                <option value="">Select Chapter</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="padding:10px;">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <h6><b>Meanings</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group meaning-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="meanquestionId[0]">
                                                        <input type="text" class="form-control" name="meanquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="meananswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-meaning" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Opposites</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group opposite-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="oppoquestionId[0]">
                                                        <input type="text" class="form-control" name="oppoquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="oppoanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-opposite" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Fill Up</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group fill-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="fillquestionId[0]">
                                                        <input type="text" class="form-control" name="fillquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="fillanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-fill" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Choose</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-2">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option A</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option B</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option C</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option D</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group choose-row">
                                                <div class="row" style="margin-bottom:10px;">
                                                    <div class="col-lg-10">
                                                        <input type="hidden" class="form-control" name="chooseId[0]">
                                                        <input type="text" class="form-control" name="chooseques0" placeholder="Question"/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optiona0" placeholder="Option A"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optionb0" placeholder="Option B"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optionc0" placeholder="Option C"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optiond0" placeholder="Option D"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label style="float: right;">Ans:</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="chooseans0" placeholder="Answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-choose" title="Add More">+</button>
                                                    </div>
                                                </div>
                                                </br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>True or False</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group true-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="truequestionId[0]">
                                                        <input type="text" class="form-control" name="truequestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="trueanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-true" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Match</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group match-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="matchquestionId[0]">
                                                        <input type="text" class="form-control" name="matchquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="matchanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-match" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>One Or Two Words </b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group ques-ans-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="quesansId[0]">
                                                        <textarea name="quesword0" class="form-control" placeholder="Question"></textarea>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <textarea name="answord0" class="form-control" placeholder="answer"></textarea>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-ques-ans" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Missing Letters</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group missing-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="missingquestionId[0]">
                                                        <input type="text" class="form-control" name="missingquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="missinganswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-missing" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Jumbled Words</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group jumble-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="jumblequestionId[0]">
                                                        <input type="text" class="form-control" name="jumblequestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="jumbleanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-jumble" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Jumbled Letters</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group jumbleletter-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="jumbleletterquestionId[0]">
                                                        <input type="text" class="form-control" name="jumbleletterquestion0" placeholder="Question"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="jumbleletteranswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-jumbleletter" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Dictation</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-5">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
                                            <div class="form-group dictation-row">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="hidden" class="form-control" name="dicquestionId[0]">
                                                        <input type="file" class="form-control" name="dicquestion0" placeholder="Question" accept="audio/*"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="dicanswer0" placeholder="answer"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-dictation" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <h6><b>Others </b></h6>
                                            <div class="form-group other-row">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="hidden" class="form-control" name="otherquestionId[0]">
                                                        <input type="text" class="form-control othertype0" name="othertype0" placeholder="Question Type"/>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 5px;">
                                                    <div class="col-lg-5">
                                                        <textarea class="form-control" name="otherquestion0" placeholder="Question"></textarea>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <textarea class="form-control" name="otheranswer0" placeholder="Answer"></textarea>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-other" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <script>
                                            $(function(){
                                                var counter = 1;
                                                $('.add-meaning').click(function(event){
                                                    event.preventDefault();

                                                    var newRow1 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="meanquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="meanquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="meananswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.meaning-row').append(newRow1);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-opposite').click(function(event){
                                                    event.preventDefault();

                                                    var newRow2 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="oppoquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="oppoquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="oppoanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.opposite-row').append(newRow2);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-fill').click(function(event){
                                                    event.preventDefault();

                                                    var newRow3 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="fillquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="fillquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="fillanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.fill-row').append(newRow3);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-choose').click(function(event){
                                                    event.preventDefault();

                                                    var newRow = $('<div class="row" style="margin-bottom:10px;"> <div class="col-lg-10"> <input type="hidden" class="form-control" name="chooseId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="chooseques' +
                                                    counter + '"/> </div> </div> <div class="row"><div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option A" name="optiona' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option B" name="optionb' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option C" name="optionc' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option D" name="optiond' +
                                                    counter + '"/> </div> <div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Answer" name="chooseans' +
                                                    counter + '"/> </div> </div> </br>');
                                                    counter++;
                                                    $('.choose-row').append(newRow);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-true').click(function(event){
                                                    event.preventDefault();

                                                    var newRow4 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="truequestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="truequestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="trueanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.true-row').append(newRow4);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-match').click(function(event){
                                                    event.preventDefault();

                                                    var newRow5 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="matchquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="matchquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="matchanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.match-row').append(newRow5);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-ques-ans').click(function(event){
                                                    event.preventDefault();

                                                    var newRow6 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="quesansId['+
                                                    counter + ']" /><textarea class="form-control" placeholder="question" name="quesword' +
                                                    counter + '"></textarea> </div> <div class="col-lg-6"> <textarea class="form-control" placeholder="answer" name="answord' +
                                                    counter + '"></textarea> </div> </div>');
                                                    counter++;
                                                    $('.ques-ans-row').append(newRow6);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-missing').click(function(event){
                                                    event.preventDefault();

                                                    var newRow5 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="missingquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="missingquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="missinganswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.missing-row').append(newRow5);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-jumble').click(function(event){
                                                    event.preventDefault();

                                                    var newRow5 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="jumblequestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="jumblequestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="jumbleanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.jumble-row').append(newRow5);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-jumbleletter').click(function(event){
                                                    event.preventDefault();

                                                    var newRow5 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="jumbleletterquestionId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="jumbleletterquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="jumbleletteranswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.jumbleletter-row').append(newRow5);
                                                });
                                            });

                                            $(function(){
                                                var counter = 1;
                                                $('.add-dictation').click(function(event){
                                                    event.preventDefault();

                                                    var newRow1 = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="dicquestionId['+
                                                    counter + ']" /><input type="file" class="form-control" placeholder="Question" accept="audio/*" name="dicquestion' +
                                                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="dicanswer' +
                                                    counter + '"/> </div> </div>');
                                                    counter++;
                                                    $('.dictation-row').append(newRow1);
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
                                                    '<input type="hidden" class="form-control" name="otherquestionId['+counter+']">'+
                                                    '<input type="text" class="form-control othertype'+counter+'" value="'+otype+'" name="othertype'+counter+'" placeholder="Question Type"/>'+
                                                    '</div>'+
                                                    '</div>'+
                                                        '<div class="row" style="margin-bottom: 5px;">'+
                                                    '<div class="col-lg-5">'+
                                                    '<textarea class="form-control" placeholder="Question" name="otherquestion'+counter+'"></textarea>'+
                                                    '</div>'+
                                                    '<div class="col-lg-6">'+
                                                    '<textarea class="form-control" placeholder="answer" name="otheranswer'+counter+'"></textarea>'+
                                                    '</div>'+
                                                    '</div>');
                                                    counter++;
                                                    $('.other-row').append(newRow7);
                                                });
                                            });
                                        </script>

                                        <div class="form-group">
                                            <div class="col-lg-2">
                                                <input type="submit" value="OK" class="btn btn-info form-control"/>
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
</html>

<script>
    $(function() {
        $('#classId').change(function() {
            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var sublist = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(sublist);
            });
        });
    });
</script>

<script>
    $(function() {
        $('#term').change(function() {
            var clsId = $('#classId').val();
            var sub = $('#subjectId').val();
            var term = $('#term').val();
            $('#chapter').empty();
            $.get('ajaxchapter.php', {cid: clsId, sub: sub, term: term}, function(result){
                var sublist = "<option value=''>Select Chapter</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.chaptername + "'>" + item.chaptername + "</option>";
                });
                $("#chapter").html(sublist);
            });
        });
    });
</script>

<script>
    /*$(function() {
     $('#questionType').change(function() {
     var qtype = $('#questionType').val();
     //alert(qtype);
     if(qtype == 'Other'){
     $('#othertype').show();
     }
     else{
     $('#othertype').hide();
     }

     $.ajax({
     url: "ajax-questions.php?qtype=" + qtype,
     context: document.body
     }).done(function(response) {
     $('#questions').html(response);
     });
     });
     });*/
</script>