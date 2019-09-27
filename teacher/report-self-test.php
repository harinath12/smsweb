<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

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

$classHandling = $teacher_fet['class_handling'];
if(!empty($classHandling)){
    $clsteacherhandling = explode(",", $classHandling);
    $clsteacherhandling_array=array_map('trim',$clsteacherhandling);
    $clshandle = null;

    $cnt = count($clsteacherhandling_array);
    for($i =0 ; $i<$cnt; $i++){
        if($i == $cnt-1){
            $clshandle = $clshandle . '\'' . $clsteacherhandling_array[$i] . '\'';
        }
        else{
            $clshandle = $clshandle . '\'' . $clsteacherhandling_array[$i] . '\'' . ',';
        }
    }

    $cls_sql="SELECT * FROM `classes` where class_name IN ($clshandle)";
    $cls_exe=mysql_query($cls_sql);
    while($cls_fet = mysql_fetch_assoc($cls_exe)){
        $clsId[] = $cls_fet['id'];
    }

    $chandle= null;
    $cnt = count($clsId);
    for($i =0 ; $i<$cnt; $i++){
        if($i == $cnt-1){
            $chandle = $chandle . $clsId[$i];
        }
        else{
            $chandle = $chandle . $clsId[$i] . ',';
        }
    }
}


$subjectHandling = $teacher_fet['subject'];
if(!empty($subjectHandling)){
    $sbjteacherhandling = explode(",", $subjectHandling);
    $sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);

    $subhandle = null;
    $cnt = count($sbjteacherhandling_array);
    for($i =0 ; $i<$cnt; $i++){
        if($i == $cnt-1){
            $subhandle = $subhandle . '\'' . $sbjteacherhandling_array[$i] . '\'';
        }
        else{
            $subhandle = $subhandle . '\'' . $sbjteacherhandling_array[$i] . '\'' . ',';
        }
    }
}

if(empty($classHandling)){
    $ques_sql = "select q.*, c.class_name from self_test as q
left join classes as c on c.id = q.class_id
left join class_section as cs on cs.id = q.section_id
where daily_test_status='1' and cs.section_name='$sectionName' and q.class_id='$classId' order by id desc";
}
else{
    if(empty($subjectHandling)){
        $ques_sql = "select q.*, c.class_name from self_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' and class_id IN ($chandle) order by id desc";
    }
    else{
        $ques_sql = "select q.*, c.class_name from self_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' and class_id IN ($chandle) and subject_name IN ($subhandle) order by id desc";
    }
}
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
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
						<li class="active">Self Test Report </li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Online Test Created Successfully</strong>
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
                                    <th>STUDENT</th>
									<th>CLASS</th>
									<th>SECTION</th>
                                    <th>SUBJECT</th>
                                    <th>TEST NAME</th>
                                    <th>MARK"S</th>
                                    <?php /* ?>
                                    <th>REMARK</th>
									<th>DATE</th>
 <?php */ ?>
                                    <th>ACTION</th>
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
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <?php
											/*
											$stu_id=$ques_fet['student_id'];
											$stu_sql="SELECT * FROM `users` where id='$stu_id'";
											$stu_exe=mysql_query($stu_sql);
											$stu_fet = mysql_fetch_assoc($stu_exe);
											$student_name = $stu_fet['name'];
											*/
											?>
											<td><?php echo $ques_fet['created_by']; ?></td>
                                            <td><?php echo $ques_fet['class_name']; ?></td>
											<?php
											$id=$ques_fet['section_id'];
											$sec_sql="SELECT * FROM `class_section` where id='$id'";
											$sec_exe=mysql_query($sec_sql);
											$sec_fet = mysql_fetch_assoc($sec_exe);
											$section_name = $sec_fet['section_name'];
											?>
											<td><?php echo $section_name; ?></td>
                                            <td><?php echo $ques_fet['subject_name'] ?></td>
                                            <td><?php echo $ques_fet['daily_test_name'] ?></td>
                                            <td>
                                                <?php
                                                $test_id = $ques_fet['id'];
                                                $student_id = $ques_fet['student_id'];
                                                $std_ques_sql = "select * from self_test_answer where daily_test_id='$test_id' AND `student_id`='$student_id' order by id asc";
                                                $std_ques_exe = mysql_query($std_ques_sql);
                                                while($std_ques_fet=mysql_fetch_array($std_ques_exe))
                                                {
                                                    $daily_test_answer_id=$std_ques_fet['id'];

                                                    $mark_query="SELECT SUM(daily_test_mark) AS mark FROM `self_test_question_answer` WHERE `daily_test_answer_id`='$daily_test_answer_id' AND `daily_test_id`='$test_id' ORDER BY `id` DESC";
                                                    $mark_query_exe=mysql_query($mark_query);
                                                    $mark_query_fet=mysql_fetch_assoc($mark_query_exe)
                                                    ?>
                                                    <a href="report-self-test-answer-view.php?test_id=<?php echo $test_id; ?>&answer_id=<?php echo $daily_test_answer_id; ?>" title="<?php echo $std_ques_fet['created_at']; ?>">
                                                        <button type="button" class="btn btn-info btn-xs"><?php echo $mark_query_fet['mark']; ?> </button>
                                                    </a>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                            <?php /* ?>
                                            <td><?php echo $ques_fet['daily_test_remark']; ?></td>
											<td><?php echo $ques_fet['created_at']; ?></td>
 <?php */ ?>
                                            <td class="text-center">
                                                <ul class="icons-list">
												
												
												
                                                    
													    <li><a href="overall-report-self-test-answer-view.php?test_id=<?php echo $ques_fet['id']; ?>&student_id=<?php echo $student_id; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View Overall Report</button></a></li>&nbsp;&nbsp;
                                                
												
                                                    <?php /* ?>
												    <li><a href="report-self-test-answer.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View Report</button></a></li>&nbsp;&nbsp;
                                                
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
                                        width: '10%',
                                        targets: 0
                                    },
                                    {
                                        width: '15%',
                                        targets:[1,2,3,4]
                                    },
                                    {
                                        width: '10%',
                                        targets: 7,
                                        orderable: false
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