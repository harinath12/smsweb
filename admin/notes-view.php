<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$classId = $_REQUEST['className'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];

$class_sql="SELECT * from classes where id='$classId'";
$class_exe=mysql_query($class_sql);
$class_fet = mysql_fetch_assoc($class_exe);
$clsName = $class_fet['class_name'];

$ques_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter'";
$ques_exe=mysql_query($ques_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel - Notes </title>
    <?php include "head1.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li class="active">Notes View</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box" style="min-height: 600px;">
                    <div class="box-body" style="padding-left: 20px;">
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
                                            <source src="<?php echo '../teacher/' . $meaning_fet['question'];?>">
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
                        
                        <button onclick="myFunction()">Print this page</button>

<script>
function myFunction() {
  window.print();
}
</script>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->


            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
            ],
            displayLength: 10
        } );
    } );
</script>

</body>
</html>
