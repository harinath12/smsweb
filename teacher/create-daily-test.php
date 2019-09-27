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

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql="SELECT * FROM `class_subject` where class_id='$classId' and class_subject_status=1";
$sub_exe=mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$ques_sql = "select q.*, c.class_name from question_bank as q
left join classes as c on c.id = q.class_id
where question_bank_status='1' and class_id='$classId' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);

$classHandling = $teacher_fet['class_handling'];

$subjectHandling = $teacher_fet['subject'];
$sbjteacherhandling = explode(",", $subjectHandling);
$sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);

if(!empty($classHandling)) {
    $clsteacherhandling = explode(",", $classHandling);
    $clsteacherhandling_array = array_map('trim', $clsteacherhandling);
    $clshandle = null;

    $cnt = count($clsteacherhandling_array);
    for ($i = 0; $i < $cnt; $i++) {
        if ($i == $cnt - 1) {
            $clshandle = $clshandle . '\'' . $clsteacherhandling_array[$i] . '\'';
        } else {
            $clshandle = $clshandle . '\'' . $clsteacherhandling_array[$i] . '\'' . ',';
        }
    }

    $class_sql = "SELECT * FROM `classes` where class_name IN ($clshandle)";
    $class_exe = mysql_query($class_sql);
    $class_results = array();
    while($row = mysql_fetch_assoc($class_exe)) {
        array_push($class_results, $row);
    }

}
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
						<li><a href="daily-test.php">Test</a></li>
                        <li class="active">Create Daily Test</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Questions inserted Successfully</strong>
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
					<?php
                    if(isset($_REQUEST['error'])) {
                        if ($_REQUEST['error'] == 1) {
                            ?>
                            <div class="alert alert-warning alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Please Selection Minimum One Chapter</strong>
                            </div>
                        <?php
                        }
                        else  if ($_REQUEST['error'] == 2) {
                            ?>
                            <div class="alert alert-warning alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Please Selection Minimum One Chapter</strong>
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
							
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-3" style="float: right">
                                    <a href="report-daily-test.php"><button type="button" class="form-control btn btn-info">Test Report</button></a>
                                </div>
                                <div class="col-md-3" style="float: right">
                                    <a href="daily-test.php"><button type="button" class="form-control btn btn-info">View Test</button></a>
                                </div>
                            </div>
                            </br>

                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-control" name="classId" id="classId">
                                        <option value="">Select Class</option>
                                        <?php
                                        foreach($class_results as $value){
                                            ?>
                                            <option value="<?php echo $value['id'];?>"><?php echo $value['class_name'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select class="form-control subjectName" name="subjectName" id="subjectName" required>
                                        <option value="">Select Subject</option>
                                        <?php
                                        foreach($sbjteacherhandling_array as $key => $value){ ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php /* ?>
                                    <select class="form-control" name="subjectName" id="subjectName">
                                        <option value="">Select Subject</option>

                                        <?php
                                        foreach($sub_results as $value){
                                            ?>
                                            <option value="<?php echo $value['subject_name'];?>"><?php echo $value['subject_name'];?></option>
                                            <?php
                                        }
                                            ?>
                                    </select>
                                    <?php */ ?>
                                </div>

                                <div class="col-md-3">
                                    <select class="form-control" name="term" id="term">
                                        <option value="">Select Term</option>
                                        <option value="Term 1">Term 1</option>
                                        <option value="Term 2">Term 2</option>
                                        <option value="Term 3">Term 3</option>
                                    </select>
                                </div>
                            </div>
                            </br>

                            <div id="questionBank">
                                <form action="daily-test-view.php" method="POST" >
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>CLASS</th>
                                            <th>SUBJECT</th>
                                            <th>TERM</th>
                                            <th>CHAPTER</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <?php /*
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
                                                    <td><?php echo $ques_fet['class_name']; ?></td>
                                                    <td><?php echo $ques_fet['subject_name'] ?></td>
                                                    <td><?php echo $ques_fet['term'] ?></td>
                                                    <td><?php echo $ques_fet['chapter']; ?></td>
                                                    <td class="text-center">
                                                        <ul class="icons-list">

                                                            <li> <input type="checkbox" name="chapter[]" value="<?php echo $ques_fet['id']; ?>" /> <?php echo $ques_fet['id']; ?></li>&nbsp;&nbsp;

                                                            <?php /* ?>

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
                                                    ----

                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        <?php
                                        } */
                                        ?>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-3" style="float: right">
                                        </div>
                                        <div class="col-md-3" style="float: right">
                                            <button type="submit" class="form-control btn btn-info" name="submit">Create Test</button>
                                        </div>
                                    </div>
                                    </br>
                                </form>
                            </div>
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
                                        width: '20%',
                                        targets: 5,
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

<script>
    $(function() {
        $('#classId').change(function() {
            var cid = $(this).val();
            var subName = $('#subjectName').val();
            var term = $('#term').val();
            $.get('ajaxsection.php', {cid: cid}, function(result){
                var sublist = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.section_name + "'>" + item.section_name + "</option>";
                });
                $("#sectionName").html(sublist);
            });

            $.ajax({
                url: "ajax-question-bank-daily-test.php?cid="+ cid +"&subName=" + subName + "&term=" + term,
                context: document.body
            }).done(function(response) {
                $('#questionBank').html(response);
            });
        });

        $('#subjectName').change(function() {
            var subName = $(this).val();
            var cid = $('#classId').val();
            var term = $('#term').val();
            $.ajax({
                url: "ajax-question-bank-daily-test.php?cid="+ cid +"&subName=" + subName + "&term=" + term,
                context: document.body
            }).done(function(response) {
                $('#questionBank').html(response);
            });
        });

        $('#term').change(function() {
            var term = $(this).val();
            var cid = $('#classId').val();
            var subName = $('#subjectName').val();
            $.ajax({
                url: "ajax-question-bank-daily-test.php?cid="+ cid +"&subName=" + subName +"&term=" + term,
                context: document.body
            }).done(function(response) {
                //alert(response);
                $('#questionBank').html(response);
            });
        });
    });
</script>
</body>
</html>