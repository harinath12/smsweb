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

$questionbank_id = $_REQUEST['question_id'];

$ques_bank_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id='$questionbank_id'");
$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
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
                <li><a href="question-bank.php">Question Bank</a></li>
                <li class="active">Question Bank View</li>
            </ol>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
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

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Meanings'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Meanings</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Opposites'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Opposites</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' X ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Fill Up'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Fill Up</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Choose'");
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
                                $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                $mean_ans = $choose_fet['answer'];
                                echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br> <b>Ans:</b> ' . $mean_ans;
                                ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='True or False'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>True or False</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Match'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Match</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='One or Two Words'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>One or Two Words</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Missing Letters'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Missing Letters</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Jumbled Words'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Jumbled Words</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Dictation'");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        $m = 1;
                        ?>
                        <h6><b>Dictation</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <?php echo $m . ') '; ?>
                                <audio controls>
                                    <source src="<?php echo '../teacher/' . $ques_fet['question'];?>">
                                    Your browser does not support the audio element.
                                </audio>

                                <?php echo ' - ' . $ques_fet['answer']; ?>
                            </div>
                            <?php
                            $m++;
                        }
                    }
                    ?>

                    <?php
                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Other' group by other_type");
                    $ques_cnt = mysql_num_rows($ques_sql);
                    if($ques_cnt> 0){
                        ?>
                        <h6><b>Other</b></h6>
                        <?php
                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                            $otype = $ques_fet['other_type'];
                            ?>
                            <div class="row" style="margin-left: 20px;">
                                <h6><b><?php echo $otype; ?></b></h6>
                                <?php
                                $other_ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and other_type='$otype'");
                                $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                ?>
                                <?php
                                $m = 1;
                                while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
                                        <?php echo $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                                ?>
                            </div>
                        <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
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
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({

        });
    } );
</script>

</body>
</html>
