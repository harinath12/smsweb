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
    <style>
        h6{
        margin-bottom: 0px;
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
                        <li><a href="question-bank.php">Question Bank</a></li>
                        <li class="active">Question Bank View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
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
                            $ques_sql=mysql_query("SELECT * FROM `question_answer` where question_bank_id='$questionbank_id' and question_type='Jumbled Letters'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Jumbled Letters</b></h6>
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
                                        <?php //echo $m . ') ' . $ques_fet['question'] . ' - ' . $ques_fet['answer']; ?>

                                        <?php echo $m . ') '; ?>
                                            <audio controls>
                                                <source src="<?php echo $ques_fet['question'];?>">
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

<script type='text/javascript'>
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
</script>
</html>
