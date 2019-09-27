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


if(isset($_REQUEST['test_id']))
{
    $test_id = $_REQUEST['test_id'];
}
else
{
    header("Location: question-paper.php?error=1");
}


$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from term_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");
$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);
$daily_test_question_count = $ques_bank_fet['daily_test_question_count'];

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
        .panel-body {
            margin:0 15px;
        }
    </style>
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
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="question-paper.php">Question Paper</a></li>
                <li class="active">Question Paper View</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- basic datatable -->
                <div class="panel panel-flat">
                    <?php
                    $questionbank_id_array = array();
                    for($qc=1;$qc<=$daily_test_question_count;$qc++)
                    {
                        $order_id = $qc;
                        unset($questionbank_id_array);
                        $daily_test_question_sql = "SELECT * FROM `term_test_question` WHERE `daily_test_id`='$test_id' AND `order_id`='$order_id'";

                        $daily_test_question_exe = mysql_query($daily_test_question_sql);


                        while($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe))
                        {
                            $questionbank_id_array[] = $daily_test_question_fetch['question_id'];
                        }

                        $questionbank_id=implode(",",$questionbank_id_array);

                        ?>

                        <div class="row">
                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center><h1><?php echo $ques_bank_fet['daily_test_name']; ?> :: <?php echo $order_id; ?></h1></center>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4">Class</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['class_name']; ?> <?php echo $ques_bank_fet['section_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4">Subject</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <label class="col-md-4">Term</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['term']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group hidden">
                                                <label class="col-md-4">Test Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['daily_test_name']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4">Test Mark</label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['daily_test_mark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4">Time </label>
                                                <div class="col-md-8">
                                                    <input type="text" value="<?php echo $ques_bank_fet['daily_test_remark']; ?>" class="form-control" readonly style="border: 0px;background: none;" />
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Meanings' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Meanings
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b></h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php echo $m . ') ' . $ques_fet['question']; ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Opposites' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Opposites
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php echo $m . ') ' . $ques_fet['question']; ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Fill Up' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Fill Up
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php echo $m . ') ' . $ques_fet['question']; ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Choose' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Choose
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php
                                                $mean_ques = $choose_fet['question'];
                                                $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'];
                                                $mean_ans = $choose_fet['answer'];
                                                echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br>';
                                                ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='True or False' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        True or False
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php echo $m . ') ' . $ques_fet['question']; ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_ans_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Match'");
                                    $ques_ans_cnt = mysql_num_rows($ques_ans_sql);
                                    if($ques_ans_cnt> 0){

                                        $ques_ans_array = "";
                                        while($ques_ans_fet = mysql_fetch_assoc($ques_ans_sql)){
                                            $ques_ans_array[] = $ques_ans_fet['answer'];
                                        }

                                        //print_r($ques_ans_array);
                                        $question_answers = shuffle($ques_ans_array);
                                        //print_r($ques_ans_array);
                                    }
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Match' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>


                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php /* ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
										<br/>
										<b>Ans:</b><?php echo $ques_fet['answer']; ?>
									</div>
									<?php */ ?>

                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Match
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <div class="col-lg-2 col-md-2">
                                                    <?php
                                                    /*
                                                    ?><?php echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>
                                                    <br/>
                                                    <?php */ ?>
                                                    <?php echo $m . ') ' . $ques_fet['question']; ?>

                                                </div>
                                                <div class="col-lg-3 col-md-3">
                                                    &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo  $ques_ans_array[$m-1]; ?>
                                                </div>
                                                <div class="col-lg-4 col-md-4">

                                                </div>
                                                <br/><br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='One or Two Words' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        One or Two Words
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <?php echo $m . ') ' . $ques_fet['question']; ?>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $rand=rand(1, 3);
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Missing Letters' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>

                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Missing Letters
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <?php

                                            $str = $ques_fet['question'];
                                            $strlen = strlen($str);
                                            $char="_";
                                            $pos=0;
                                            if($rand==1) {
                                                if($strlen>10)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = substr_replace($str,$char,5,1);
                                                    $str = @substr_replace($str,$char,9,1);
                                                }
                                                else if($strlen>8)
                                                {
                                                    $str = substr_replace($str,$char,3,1);
                                                    $str = substr_replace($str,$char,6,1);
                                                    $str = @substr_replace($str,$char,8,1);
                                                }
                                                else if($strlen>6)
                                                {
                                                    $str = substr_replace($str,$char,1,1);
                                                    $str = substr_replace($str,$char,3,1);
                                                    $str = @substr_replace($str,$char,5,1);
                                                }
                                                else if($strlen>4)
                                                {
                                                    $str = substr_replace($str,$char,0,1);
                                                    $str = @substr_replace($str,$char,3,1);
                                                }
                                                else if($strlen>2)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                }
                                            }
                                            if($rand==2) {
                                                if($strlen>10)
                                                {
                                                    $str = substr_replace($str,$char,1,1);
                                                    $str = substr_replace($str,$char,4,1);
                                                    $str = @substr_replace($str,$char,8,1);
                                                }
                                                else if($strlen>8)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = substr_replace($str,$char,5,1);
                                                    $str = @substr_replace($str,$char,7,1);
                                                }
                                                else if($strlen>6)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = substr_replace($str,$char,4,1);
                                                    $str = @substr_replace($str,$char,6,1);
                                                }
                                                else if($strlen>4)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = @substr_replace($str,$char,4,1);
                                                }
                                                else if($strlen>2)
                                                {
                                                    $str = substr_replace($str,$char,1,1);
                                                }
                                            }
                                            if($rand==3) {
                                                if($strlen>10)
                                                {
                                                    $str = substr_replace($str,$char,3,1);
                                                    $str = substr_replace($str,$char,5,1);
                                                    $str = @substr_replace($str,$char,7,1);
                                                }
                                                else if($strlen>8)
                                                {
                                                    $str = substr_replace($str,$char,1,1);
                                                    $str = substr_replace($str,$char,3,1);
                                                    $str = @substr_replace($str,$char,6,1);
                                                }
                                                else if($strlen>6)
                                                {
                                                    $str = substr_replace($str,$char,0,1);
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = @substr_replace($str,$char,5,1);
                                                }
                                                else if($strlen>4)
                                                {
                                                    $str = substr_replace($str,$char,2,1);
                                                    $str = @substr_replace($str,$char,4,1);
                                                }
                                                else if($strlen>2)
                                                {
                                                    $str = substr_replace($str,$char,0,1);
                                                }
                                            }

                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <div class="col-lg-4">
                                                    <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                                    <?php echo $m . ') ' . $str; ?>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <br/>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Jumbled Words' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>

                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Jumbled Words
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            $translatedWords = explode(' ',$ques_fet['question']);
                                            shuffle($translatedWords);
                                            $translatedWords = implode(' ',$translatedWords);

                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <div class="col-lg-4">
                                                    <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                                    <?php echo $m . ') ' . $translatedWords; ?>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <br/>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Jumbled Letters' and order_id=$order_id and daily_test_id=$test_id");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        $m = 1;
                                        ?>

                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <?php
                                            if($m ==1){
                                                ?>
                                                <h6><b>
                                                        Jumbled Letters
                                                        <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                    </b> </h6>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            $translatedWords = str_shuffle($ques_fet['question']);
                                            ?>
                                            <div class="row" style="margin-left: 20px;">
                                                <div class="col-lg-4">
                                                    <?php //echo $m . ') ' . $ques_fet['question']; ?>
                                                    <?php echo $m . ') ' . $translatedWords; ?>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                                <br/>
                                                <br/>
                                            </div>
                                            <?php
                                            $m++;
                                        }
                                    }
                                    ?>

                                    <?php /* ?>
                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <?php
                                while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
                                    <div class="row" style="margin-left: 20px;">
										<?php if($m == 1){ ?>
                                        <h6><b><?php echo $ques_fet['other_type']; ?></b></h6>
                                        <?php } ?>
                                        <?php echo $m . ') ' . $ques_fet['question']; ?>
										<br/>
										<b>Ans:</b><?php echo $ques_fet['answer']; ?>
                                    </div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
							<?php */ ?>

                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other' group by other_type");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <!-- <h6><b>Other</b></h6>-->
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            $otype = $ques_fet['other_type'];
                                            ?>
                                            <div class="row" style="margin-left: 20px;">

                                                <?php
                                                $other_ques_sql=mysql_query("
SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.other_type='$otype' and order_id=$order_id and daily_test_id=$test_id");
                                                $other_ques_cnt = mysql_num_rows($other_ques_sql);
                                                ?>
                                                <?php
                                                $m = 1;
                                                while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
                                                    ?>
                                                    <?php
                                                    if($m ==1){
                                                        ?>
                                                        <h6><b>
                                                                <?php echo $otype; ?>
                                                                <span style="float:right"><?php echo ' [ ' .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] ' ?></span>
                                                            </b> </h6>
                                                    <?php
                                                    }
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
                    <?php
                    }
                    ?>

                    <form action="../teacher/pdf/question-paper.php" method="post">
                        <input type="hidden" name="test_id" value="<?php echo $test_id ; ?>"/>
                        <input type="submit" value="Download" class="btn btn-danger">
                    </form>
                </div>
                <!-- /basic datatable -->

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
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({

        });
    } );
</script>

</body>
</html>
