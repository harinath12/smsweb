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
$questionType = $_REQUEST['type'];

$ques_sql="SELECT * FROM `question_answer` where question_bank_id='$questionbank_id'";
$ques_exe=mysql_query($ques_sql);
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
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> QUESTION BANK EDIT</h4>
                    </div>
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
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Question Details
                            </h4>
                        </div>
                        <div class="panel-body">
                            <form action="doupdatequestions.php" method="post">
                                <div class="col-md-12">
                                    <?php
                                    if ($questionType == 'One or Two words') {
                                        ?>
                                        <div class="form-group">
                                            <div class="col-lg-5">
                                                <label>Question</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Answer</label>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" class="btn btn-info add-ques-ans" title="Add More">+</button>
                                            </div>
                                        </div>
                                        <div class="form-group ques-ans-row">
                                        <?php
                                        while($ques_fet=mysql_fetch_array($ques_exe)) {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <textarea name="quesword[]" class="form-control" placeholder="Question"><?php echo $ques_fet['question'];?></textarea>
                                                </div>
                                                <div class="col-lg-6">
                                                    <textarea name="answord[]" class="form-control" placeholder="Answer"><?php echo $ques_fet['answer'];?></textarea>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        </div>
                                    <?php
                                    }
                                    else if ($questionType == 'Choose') {
                                        ?>
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
                                            <div class="col-lg-1">
                                                <label>Answer</label>
                                            </div>
                                        </div>

                                        <div class="form-group choose-row">
                                            <?php $d = 1; ?>
                                            <?php
                                            while($ques_fet=mysql_fetch_array($ques_exe)) {
                                                ?>
                                                <div class="row" style="margin-bottom:10px;">
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="chooseques[]" placeholder="Question" value="<?php echo $ques_fet['question'];?>"/>
                                                    </div>
                                                    <?php if($d == 1){ ?>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-choose" title="Add More">+</button>
                                                    </div>
                                                    <?php  } $d++; ?>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optiona[]" placeholder="Option A" value="<?php echo $ques_fet['optiona'];?>"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optionb[]" placeholder="Option B" value="<?php echo $ques_fet['optionb'];?>"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optionc[]" placeholder="Option C" value="<?php echo $ques_fet['optionc'];?>"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="optiond[]" placeholder="Option D" value="<?php echo $ques_fet['optiond'];?>"/>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label style="float: right;">Ans:</label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control" name="chooseans[]" placeholder="Answer" value="<?php echo $ques_fet['answer'];?>"/>
                                                    </div>
                                                </div>
                                                </br>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    else {
                                        ?>
                                        <div class="form-group">
                                            <div class="col-lg-5">
                                                <label>Question</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Answer</label>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" class="btn btn-info add-question" title="Add More">+</button>
                                            </div>
                                        </div>
                                        <div class="form-group question-row">
                                            <?php
                                            while($ques_fet=mysql_fetch_array($ques_exe)) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <input type="text" class="form-control" name="question[]" placeholder="Question" value="<?php echo $ques_fet['question'];?>"/>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="answer[]" placeholder="Answer" value="<?php echo $ques_fet['answer'];?>"/>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <script>
                                        $(function(){
                                            $('.add-question').click(function(event){
                                                event.preventDefault();
                                                var newRow = $('<div class="row"> ' +
                                                '<div class="col-lg-5"> ' +
                                                '<input type="text" class="form-control" placeholder="Question" name="question[]"/> ' +
                                                '</div> ' +
                                                '<div class="col-lg-6"> ' +
                                                '<input type="text" class="form-control" placeholder="answer" name="answer[]"/> ' +
                                                '</div> ' +
                                                '</div>');
                                                $('.question-row').append(newRow);
                                            });
                                        });

                                        $(function(){
                                            var counter = 1;
                                            $('.add-choose').click(function(event){
                                                event.preventDefault();

                                                var newRow = $('<div class="row" style="margin-bottom:10px;"> ' +
                                                '<div class="col-lg-10"> <input type="text" class="form-control" placeholder="Question" name="chooseques[]"/> </div> </div>' +
                                                '<div class="row"> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option A" name="optiona[]"/> </div> ' +
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
                                            $('.add-ques-ans').click(function(event){
                                                event.preventDefault();

                                                var newRow = $('<div class="row"> ' +
                                                '<div class="col-lg-5"> ' +
                                                '<textarea class="form-control" placeholder="Question" name="quesword[]"></textarea> ' +
                                                '</div> ' +
                                                '<div class="col-lg-6"> <textarea class="form-control" placeholder="Answer" name="answord[]"> </textarea> ' +
                                                '</div>' +
                                                ' </div>');
                                                $('.ques-ans-row').append(newRow);
                                            });
                                        });
                                    </script>

                                    <div class="form-group">
                                        <input type="hidden" name="question_bank_id" value="<?php echo $questionbank_id; ?>" />
                                        <div class="col-lg-2">
                                            <input type="submit" value="OK" class="btn btn-info form-control"/>
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
