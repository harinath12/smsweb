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

$ques_sql="SELECT qa.*, qb.question_type FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where question_bank_id='$questionbank_id'";
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
                        <h4><i class="fa fa-th-large position-left"></i> QUESTION BANK VIEW</h4>
                    </div>
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
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Question Details
                            </h4>
                        </div>
                        <div class="panel-body">

                            <form action="#" method="post">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>QUESTION</th>
                                        <th>ANSWER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($ques_fet=mysql_fetch_array($ques_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <?php if($questionType == 'Choose'){
                                                ?>
                                                <td><?php echo $ques_fet['question'] . " A) " . $ques_fet['optiona'] . " B) " . $ques_fet['optionb'] . " C) " . $ques_fet['optionc'] . " D) " . $ques_fet['optiond']; ?></td>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <td><?php echo $ques_fet['question'] ?></td>
                                            <?php
                                            }?>
                                            <td><?php echo $ques_fet['answer'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

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
