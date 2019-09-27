<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

/* $ques_sql = "select q.*, c.class_name from daily_test as q
left join classes as c on c.id = q.class_id
left join class_section as cs on cs.id = q.section_id
where daily_test_status='1' and cs.section_name='$sectionName' and q.class_id='$classId' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe); */

$ques_sql = "select q.*, c.class_name from aptitude_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' and q.class_id='$classId' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
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
	.today {
    font-size: 15px;
    font-weight: bold;
    color: blue;
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
                        <li class="active">Aptitude Test</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Online Test Completed Successfully</strong>
                            </div>
                        <?php
                        }
                        else  if ($_REQUEST['succ'] == 2) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Questions imported Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
							 </br>
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>DATE</th>
									<th>SUBJECT</th>
                                    <th>TEST NAME</th>
                                    <th>TOTAL</th>
									<th>MARKS</th>
									<th>ACTION</th>
									<th class="hidden">Order</th>
                                </tr>
                                </thead>
                                <?php
                                if($ques_cnt>0)
                                {
                                    ?>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($ques_fet=mysql_fetch_array($ques_exe))
                                    {
										
										
										
										$created_at=explode(" ",$ques_fet['created_at']);
										if(date("Y-m-d")==$created_at[0]) { $style_class="today"; } else { $style_class=""; }
                                        
										$test_id=$ques_fet['id'];
										$test_date=date("Y-m-d");
										$check_test_sql = "select COUNT(id) AS test_count from aptitude_test_answer where daily_test_id='$test_id' AND `student_id`='$user_id' AND `created_at` LIKE '$test_date%' order by id asc";
										$check_test_count = mysql_fetch_array(mysql_query($check_test_sql));
										$test_count=$check_test_count['test_count'];
										if($test_count==1) { $style_class1="today"; } else { $style_class1=""; }
										?>
                                        <tr class="<?php echo $style_class; ?> <?php echo $style_class1; ?>">
                                            <td><?php echo $i++; ?></td>
                                            <td>
											<?php //echo $created_at[0]; ?>
											<?php echo date_display($created_at[0]); ?>
											</td>
                                            <td><?php echo $ques_fet['subject_name'] ?></td>
                                            <td><?php echo $ques_fet['daily_test_name'] ?></td>
                                            <td><?php //echo $ques_fet['daily_test_name'] ?>
											<?php
											$test_id=$ques_fet['id'];
											$mark_question_query="SELECT COUNT(id) AS mark FROM `aptitude_test_question` WHERE `daily_test_id`='$test_id'";
											$mark_question_query_exe=mysql_query($mark_question_query);
											$mark_question_query_fet=mysql_fetch_assoc($mark_question_query_exe);
											echo $mark_question_query_fet['mark'];
											?>
											</td>
                                            <td><?php //echo $ques_fet['daily_test_remark']; ?>
											<?php
											$test_id=$ques_fet['id'];
											$std_ques_sql = "select * from aptitude_test_answer where daily_test_id='$test_id' AND `student_id`='$user_id' order by id asc";
											$std_ques_exe = mysql_query($std_ques_sql);
											
											while($std_ques_fet=mysql_fetch_array($std_ques_exe))
												{
												$daily_test_answer_id=$std_ques_fet['id'];
												
												$mark_query="SELECT SUM(daily_test_mark) AS mark FROM `aptitude_test_question_answer` WHERE `daily_test_answer_id`='$daily_test_answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
												$mark_query_exe=mysql_query($mark_query);
												$mark_query_fet=mysql_fetch_assoc($mark_query_exe)
											?>
											<a href="review-aptitude-test-view.php?test_id=<?php echo $test_id; ?>&answer_id=<?php echo $daily_test_answer_id; ?>" title="<?php echo $std_ques_fet['created_at']; ?>">
											<button type="button" class="btn btn-info btn-xs"><?php echo $mark_query_fet['mark']; ?> </button>
											</a>
											<?php		
												}
											?>
											
											</td>
											<td class="text-center">
                                                <ul class="icons-list">
                                                    <li><a href="preview-aptitude-test.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Read </button></a></li>
                                                    
													<li><a href="write-aptitude-test-one-by-one.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Write </button></a></li>
													
													
													<li><a href="overall-report-aptitude-test-answer-view.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Report </button></a></li>
                                                    
                                                    <?php /* ?>
													
                                                    <li><a href="review-daily-test.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Review </button></a></li>
                                                    
													<li> <input type="checkbox" name="chapter[]" value="<?php echo $ques_fet['id']; ?>" /> <?php echo $ques_fet['id']; ?></li>&nbsp;&nbsp;
                                                    
													<li><a href="questionbankview.php?question_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="questionbankedit.php?question_id=<?php echo $ques_fet['id']; ?>" title="Edit"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;

 <li><a href="excelphp.php?question_id=<?php echo $ques_fet['id']; ?>" title="Download"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-download"></i></button></a></li>&nbsp;&nbsp;
 <li><a href="question-bank-view.php?question_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="question-bank-edit.php?question_id=<?php echo $ques_fet['id']; ?>" title="Edit"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                    <li><a href="question-bank-chapter-edit.php?question_id=<?php echo $ques_fet['id']; ?> ?>" title="Edit Chapter"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
 <li>
                                                        <form action="pdf/question-bank.php" method="post">
                                                            <input type="hidden" name="questionId" value="<?php echo $ques_fet['id']; ?>"/>
                                                            <input type="hidden" name="clsName" value="<?php echo $className; ?>"/>
                                                            <button type="submit" class="btn btn-info btn-xs" title="Download"><i class="fa fa-download"></i></button>
                                                        </form>
                                                    </li>&nbsp;&nbsp;
                                                    <?php */?>

                                                </ul>
                                            </td>
											<td class="hidden">
											<?php echo $style_class.$style_class1; ?>
											</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table> 
						</div>
                        <!-- /basic datatable -->

                    </div>
                </div>

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
                                        width: '5%',
                                        targets: 0
                                    },
                                    {
                                        width: '10%',
                                        targets: [1,2]
                                    },
                                    {
                                        width: '20%',
                                        targets:3
                                    },
									{
                                        width: '5%',
                                        targets:4
                                    },
									{
                                        width: '25%',
                                        targets:5
                                    },
                                    {
                                        width: '25%',
                                        targets: 6,
                                        orderable: false
                                    }
                                ],
                                order: [[ 7, 'desc' ]],
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