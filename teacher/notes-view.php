<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$clsName = $_REQUEST['className'];
$classId = $_REQUEST['classId'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];

/*$class_sql="SELECT * from classes where id='$classId'";
$class_exe=mysql_query($class_sql);
$class_fet = mysql_fetch_assoc($class_exe);
$clsName = $class_fet['class_name']; */
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
                        <li><a href="notes.php">Notes</a></li>
                        <li class="active">Notes View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
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
                            $missing_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Missing Letters'";
                            $missing_exe=mysql_query($missing_sql);
                            $missing_cnt = mysql_num_rows($missing_exe);
                            if($missing_cnt > 0){
                                ?>
                                <div class="row">
                                    <h4><?php echo $d . ') '; ?>Missing Letters</h4>
                                </div>
                                <?php
                                $m = 1;
                                while($missing_fet = mysql_fetch_assoc($missing_exe))
                                {
                                    $mean_ques = $missing_fet['question'];
                                    $mean_ans = ($questionType != 1) ? $missing_fet['answer'] : Null;
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
                            //Jumbled Words
                            $jumble_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Words'";
                            $jumble_exe=mysql_query($jumble_sql);
                            $jumble_cnt = mysql_num_rows($jumble_exe);
                            if($jumble_cnt > 0){
                                ?>
                                <div class="row">
                                    <h4><?php echo $d . ') '; ?>Jumbled Words</h4>
                                </div>
                                <?php
                                $m = 1;
                                while($jumble_fet = mysql_fetch_assoc($jumble_exe))
                                {
                                    $mean_ques = $jumble_fet['question'];
                                    $mean_ans = ($questionType != 1) ? $jumble_fet['answer'] : Null;
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
                            //Jumbled Letters
                            $jumble_sql="SELECT qa.* FROM `question_answer` as qa
                            left join question_bank as qb on qb.id = qa.question_bank_id
                            where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Letters'";
                            $jumble_exe=mysql_query($jumble_sql);
                            $jumble_cnt = mysql_num_rows($jumble_exe);
                            if($jumble_cnt > 0){
                                ?>
                                <div class="row">
                                    <h4><?php echo $d . ') '; ?>Jumbled Letters</h4>
                                </div>
                                <?php
                                $m = 1;
                                while($jumble_fet = mysql_fetch_assoc($jumble_exe))
                                {
                                    $mean_ques = $jumble_fet['question'];
                                    $mean_ans = ($questionType != 1) ? $jumble_fet['answer'] : Null;
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
                                                <source src="<?php echo $meaning_fet['question'];?>">
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

                            <form action="pdf/notes.php" method="post">
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
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.datatable').DataTable( {
            displayLength: 20
        } );
    } );
</script>
</body>


</html>
