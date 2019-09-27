<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$clsName = $_REQUEST['className'];
$classId = $_REQUEST['classId'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];

$date = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>
    <style>
        .req{
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
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> NOTES</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="notes.php">Notes</a></li>
                        <li class="active">Notes View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-body" style="padding-left: 20px;">
                                <?php $d = 1; ?>
                                <?php
                                //Meanings
                                $meaning_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Meanings'";
                                $meaning_exe=mysql_query($meaning_sql);
                                $meaning_cnt = mysql_num_rows($meaning_exe);
                                if($meaning_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Meanings</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-2"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Opposites
                                $oppo_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Opposites'";
                                $oppo_exe=mysql_query($oppo_sql);
                                $oppo_cnt = mysql_num_rows($oppo_exe);
                                if($oppo_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Opposites</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($oppo_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' X '; ?> </div>
                                            <div class="col-md-2"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Fill up
                                $fill_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Fill up'";
                                $fill_exe=mysql_query($fill_sql);
                                $fill_cnt = mysql_num_rows($fill_exe);
                                if($fill_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Fill Up</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($fill_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $m . '. ' . $mean_ques . '</br><b>' . 'Ans: ' . '</b>' . $mean_ans; ?>
                                            </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Choose
                                $choose_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Choose'";
                                $choose_exe=mysql_query($choose_sql);
                                $choose_cnt = mysql_num_rows($choose_exe);
                                if($choose_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Choose</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($choose_fet = mysql_fetch_assoc($choose_exe))
                                    {
                                        $mean_ques = $choose_fet['question'];
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'] ;
                                        $mean_ans = ($questionType != 1) ? $choose_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $m . '.' .$mean_ques . '<br>' . $mean_opt . '<br> Ans: ' . $mean_ans; ?>
                                            </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //True Or False
                                $true_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='True or False'";
                                $true_exe=mysql_query($true_sql);
                                $true_cnt = mysql_num_rows($true_exe);
                                if($true_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>True or False</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($true_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $m . '. ' . $mean_ques . '</br><b>' . 'Ans: ' . '</b>' . $mean_ans; ?>
                                            </div>
                                        </div>

                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Match
                                $match_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Match'";
                                $match_exe=mysql_query($match_sql);
                                $match_cnt = mysql_num_rows($match_exe);
                                if($match_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Match</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($match_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-2"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //One or Two Words
                                $word_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='One or Two words'";
                                $word_exe=mysql_query($word_sql);
                                $word_cnt = mysql_num_rows($word_exe);
                                if($word_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>One or Two Words</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($word_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $m . '. ' . $mean_ques . '</br><b>' . 'Ans: ' . '</b>' . $mean_ans; ?>
                                            </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Missing Letters
                                $meaning_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Missing Letters'";
                                $meaning_exe=mysql_query($meaning_sql);
                                $meaning_cnt = mysql_num_rows($meaning_exe);
                                if($meaning_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Missing Letters</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-3"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>


                                <?php
                                //Jumbled Words
                                $meaning_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Words'";
                                $meaning_exe=mysql_query($meaning_sql);
                                $meaning_cnt = mysql_num_rows($meaning_exe);
                                if($meaning_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Jumbled Words</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-3"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Jumbled Letters
                                $meaning_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Letters'";
                                $meaning_exe=mysql_query($meaning_sql);
                                $meaning_cnt = mysql_num_rows($meaning_exe);
                                if($meaning_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Jumbled Letters</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-2"> <?php echo $m . '. ' . $mean_ques; ?> </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-3"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Dictation
                                $meaning_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Dictation'";
                                $meaning_exe=mysql_query($meaning_sql);
                                $meaning_cnt = mysql_num_rows($meaning_exe);
                                if($meaning_cnt > 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Dictation</h4>
                                    </div>
                                    <?php
                                    $m = 1;
                                    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
                                    {
                                        $mean_ques = $meaning_fet['question'];
                                        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php echo $m . '. ';?>
                                                <audio controls style="width: 80%;">
                                                    <source src="<?php echo '../teacher/'. $meaning_fet['question'];?>">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>
                                            <div class="col-md-1"> <?php echo ' - '; ?> </div>
                                            <div class="col-md-2"> <?php echo $mean_ans; ?> </div>
                                        </div>
                                        <?php $m++;
                                    }
                                    $d++;
                                }
                                ?>

                                <?php
                                //Others
                                $ques_sql=mysql_query("SELECT qa.* FROM `question_answer` as qa left join question_bank as qb on qb.id = qa.question_bank_id where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Other' group by qa.other_type");
                                $ques_cnt = mysql_num_rows($ques_sql);
                                if($ques_cnt> 0){
                                    ?>
                                    <div class="row">
                                        <h4><?php echo $d . ') '; ?>Others</h4>
                                    </div>
                                    <?php
                                    while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                        $otype = $ques_fet['other_type'];
                                        ?>
                                        <div class="row">
                                            <h6><b><?php echo $otype; ?></b></h6>
                                        </div>

                                        <?php
                                        $other_ques_sql=mysql_query("SELECT qa.* FROM `question_answer` as qa left join question_bank as qb on qb.id = qa.question_bank_id where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.other_type='$otype'");
                                        $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                        ?>
                                        <?php
                                        $m = 1;
                                        while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php echo $m . '. ' . $other_ques_fet['question'] . '</br><b>' . 'Ans: ' . '</b>' . $other_ques_fet['answer']; ?>
                                                </div>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                        ?>
                                    <?php
                                    }
                                }
                                ?>

                                <form action="../teacher/pdf/notes.php" method="post">
                                    <input type="hidden" name="className" value="<?php echo $classId; ?>"/>
                                    <input type="hidden" name="clsName" value="<?php echo $clsName; ?>"/>
                                    <input type="hidden" name="subjectName" value="<?php echo $subjectName; ?>"/>
                                    <input type="hidden" name="term" value="<?php echo $term; ?>"/>
                                    <input type="hidden" name="chapter" value="<?php echo $chapter; ?>"/>
                                    <input type="hidden" name="questionType" value="<?php echo $questionType; ?>"/>
                                    <input type="submit" value="Download" class="btn btn-danger">
                                </form>
                            </div>
                        </div>
                        <!-- /basic datatable -->

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
<script>
    $(function() {
        $('#term').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#subjectId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });
    });
</script>

</body>
</html>