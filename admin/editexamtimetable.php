<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}
include "config.php";

if (isset($_GET['id'])){
    $examid = $_GET['id'];
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$class_sql="SELECT * FROM classes where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$exam_sql="SELECT * FROM `exam_time_table` where id='$examid'";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);

$exam_class_sql = "SELECT DISTINCT class_id FROM `exam_date_subject` where exam_id='$examid'";
$exam_class_exe = mysql_query($exam_class_sql);
$exam_class_cnt = mysql_num_rows($exam_class_exe);
while($exam_class_fet = mysql_fetch_assoc($exam_class_exe)){
    $class_id[] = $exam_class_fet['class_id'];
}
$class_cnt = count($class_id);

$startdate = $exam_fet['start_date'];
$enddate = $exam_fet['end_date'];

for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
$examdate_cnt = count($examdate);

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

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="exam-time-table.php">Exam Time Table</a></li>
                            <li class="active">Edit Exam Time Table</li>
                        </ol>
                        <div class="row" id="viewExam">

                        </div>
                        <div class="row" id="editExam">
                            <form action="doeditexamtimetable.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label col-lg-4">Exam</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="editexamname" class="form-control" value="<?php echo $exam_fet['exam_name']; ?>" required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label col-lg-4">Class</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control className" name="className[]" id="editclassName" multiple required>
                                                        <option value="">Select Class</option>
                                                        <option value="100" <?php for($c =0; $c<$class_cnt; $c++){if($class_id[$c] == '100'){echo 'selected'; }}?>>All</option>
                                                        <?php
                                                        foreach($class_results as $key => $value){ ?>
                                                            <option value="<?php echo $value['id']; ?>" <?php for($c =0; $c<$class_cnt; $c++){if($class_id[$c] == $value['id']){echo 'selected'; }}?>><?php echo $value['class_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="editstartdate" class="form-control" value="<?php echo $exam_fet['start_date']; ?>" id="editstartdate" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-8">
                                                    <input type="text" name="editenddate" class="form-control" value="<?php echo $exam_fet['end_date']; ?>" id="editenddate" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="examid" class="form-control" value="<?php echo $examid; ?>" id="examid"/>


                                <div id="edittimetableentry" style="overflow-x: scroll;padding: 0px 10px;margin: 0px 20px;">
                                </div>
                            </form>
                        </div>


                        <table id="example2" class="datatable curdate">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Exam Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $exams_exe = mysql_query("SELECT * FROM `exam_time_table` where exam_status=1");
                            $sno = 1;
                            while($exams_fet = mysql_fetch_assoc($exams_exe)){
                                ?>
                                <tr>
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $exams_fet['exam_name']; ?></td>
                                    <td><?php echo $exams_fet['start_date']; ?></td>
                                    <td><?php echo $exams_fet['end_date'];; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info viewExamBtn" title="View"><i class="fa fa-eye"></i></button>
                                        <input type="hidden" class="examId" value="<?php echo $exams_fet['id'];?>"/>
                                        <?php /* ?>
                                            <button type="button" class="btn btn-info editExamBtn" title="Edit"><i class="fa fa-pencil"></i></button>
  <?php */ ?>
                                        <a href="editexamtimetable.php?id=<?php echo $exams_fet['id']; ?>" title="Edit" style="color: black;">
                                            <button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                                        </a>
                                         
										<?php									
											$exam_id=$exams_fet['id'];
											$exam_date_count=@mysql_fetch_array(mysql_query("SELECT COUNT(`id`) AS `exam_count` FROM `student_mark` WHERE `exam_id`=$exam_id"));
											$exam_date_count_value=$exam_date_count['exam_count'];
											if($exam_date_count_value>0) 
											{
											?>
                                            <a href="#dodeleteexamtimetable.php?id=<?php echo $exam_fet['id']; ?>" title="Delete" style="color: black;" onclick="alert('Don\'t delete this exam time table');">
                                                <button type="button" class="btn btn-info"><i class="fa fa-trash"></i></button>
                                            </a>
											<?php } else { ?>
											<a href="dodeleteexamtimetable.php?id=<?php echo $exam_fet['id']; ?>" title="Delete" style="color: black;" onclick="return confirm('Do you want to delete?');">
                                                <button type="button" class="btn btn-info"><i class="fa fa-trash"></i></button>
                                            </a>
											<?php } ?>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section><!-- /.content -->
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
    $(document).ready(function() {
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
                        width: '30%',
                        targets: 1
                    },
                    {
                        width: '20%',
                        targets:[2,3]
                    },
                    {
                        width: '20%',
                        targets:4,
                        orderable:false
                    }
                ],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 100
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#editstartdate").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
    $( function() {
        $( "#editenddate").datepicker({
            dateFormat:'dd-mm-yy',
            //minDate: 'today'
        });
    } );
</script>

<script>
    $( function() {
        $( "#editclassName, #editstartdate, #editenddate").on( "change", function() {
            var className = $('#editclassName').val();
            var startdate = $('#editstartdate').val();
            var enddate = $('#editenddate').val();
            var examid = $('#examid').val();
            if(className!='' && startdate!="" && enddate!="") {
				$.ajax({
					url: "ajax-edit-exam-subject.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className + "&id=" + examid,
					context: document.body
				}).done(function(response) {
					$('#edittimetableentry').html(response);
				});
			}
		});
    } );
	
	$( window ).load(function() {
		
		var className = $('#editclassName').val();
		var startdate = $('#editstartdate').val();
		var enddate = $('#editenddate').val();
		var examid = $('#examid').val();
		if(className!='' && startdate!="" && enddate!="") {
			$.ajax({
				url: "ajax-edit-exam-subject.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className + "&id=" + examid,
				context: document.body
			}).done(function(response) {
				$('#edittimetableentry').html(response);
			});
		}
	
	});
</script>

<script>
    $(function() {
        $('.viewExamBtn').click(function() {
            //$('#addExam').hide();
            $('#editExam').hide();
            $('#viewExam').toggle();

            var id = $(this).siblings('.examId').val();
            $.ajax({
                url: "ajax-view-examtimetable.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#viewExam').html(response);
            });
        });
    });
</script>
<script>
window.onmousedown = function (e) {
    var el = e.target;
    if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
        e.preventDefault();

        // toggle selection
        if (el.hasAttribute('selected')) el.removeAttribute('selected');
        else el.setAttribute('selected', '');

        // hack to correct buggy behavior
        var select = el.parentNode.cloneNode(true);
        el.parentNode.parentNode.replaceChild(select, el.parentNode);
		
		console.log(el);
		
		var className = $('#editclassName').val();
		
		if(className.includes("100")) { var className = "100"; }
		
		var startdate = $('#editstartdate').val();
		var enddate = $('#editenddate').val();
		var examid = $('#examid').val();
		if(className!='' && startdate!="" && enddate!="") {
			$.ajax({
				url: "ajax-edit-exam-subject.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className + "&id=" + examid,
				context: document.body
			}).done(function(response) {
				$('#edittimetableentry').html(response);
			});
		}
    }
}
</script>
</body>
</html>
