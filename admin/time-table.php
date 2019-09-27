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
 
$exam_sql="SELECT * FROM `time_table` WHERE `time_table_status`=1 ORDER BY `id` DESC";
$exam_exe=mysql_query($exam_sql);

$class_sql="SELECT * FROM `classes` WHERE `class_status`=1 ";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .brd{
            border-right: 1px solid grey;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
<style>
table#exam-table tr th,table#exam-table tr td { width:150px !important; }
</style>

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 700px;">
                        <div class="row">
                            <div class="col-md-9">
                                <ol class="breadcrumb" style="background-color: white;">
                                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                                    <li class="active">Time Table</li>
                                </ol>
                            </div>
                            <div class="col-md-3" style="float: right">
								<a href="add-time-table.php">
                                <button type="button" class="form-control btn btn-info" >Add Time Table</button>
								</a>
                            </div>
                        </div>
                        <div class="row" id="editExam">

                        </div>
                        <div class="row" id="viewExam">

                        </div>

                        <div class="row" id="addExam" style="display: none;">
                            <div class="panel-body">
                                <h4>Add Exam Time Table</h4>
                                <form action="doaddexamtimetable.php" method="post" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Exam</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="exam_name" id="title" value="" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class</label>
                                            <div class="col-lg-8">
                                                <select class="form-control className" name="className[]" id="className" multiple required>
                                                    <option value="">Select Class</option>
                                                    <option value="100">All</option>
                                                    <?php
                                                    foreach($class_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Start Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="datepicker1" name="start_date" value="" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">End Date</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="datepicker2" name="end_date" value="" required/>
                                            </div>
                                        </div>
									</div>
									
                                    <div class="col-md-12">
                                        <div id="timetableentry" style="overflow-x: scrollX;padding: 0px 10px;margin: 0px 20px;">

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <?php
                            if(isset($_REQUEST['succ'])) {
                                if ($_REQUEST['succ'] == 1) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Time Table inserted Successfully</strong>
                                    </div>
                                <?php
                                }
                                else if($_REQUEST['succ'] == 2) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Time Table updated Successfully</strong>
                                    </div>
                                <?php
                                }
                                else if($_REQUEST['succ'] == 3) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong> Time Table deleted Successfully</strong>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <table id="example2" class="datatable curdate">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sno = 1;
                                while($exam_fet = mysql_fetch_assoc($exam_exe)){
                                    ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $exam_fet['class']; ?></td>
                                        <td><?php echo $exam_fet['section']; ?></td>
                                        <td>
										<?php /* */ ?>
                                            <input type="hidden" class="examId" value="<?php echo $exam_fet['id'];?>"/>
                                            
											<button type="button" class="btn btn-info viewExamBtn" title="View"><i class="fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-info editExamBtn" title="Edit"><i class="fa fa-pencil"></i></button>
                                            
											<a href="dodeletetimetable.php?id=<?php echo $exam_fet['id']; ?>" title="Delete" style="color: black;" onclick="return confirm('Do you want to delete?');">
                                                <button type="button" class="btn btn-info"><i class="fa fa-trash"></i></button>
                                            </a>
										<?php /* */ ?>
										</td>
                                    </tr>
                                <?php
                                    $sno++;
                                }
                                ?>

                                </tbody>
                            </table>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
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
                        targets:[1,2]
                    },
                    {
                        width: '30%',
                        targets:3,
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
			/*
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
			*/
        });
    });
</script>

<script>
    $(function() {
        $('#addExamBtn').click(function() {
            $('#addExam').toggle();
            $('#editExam').css("display","none");
            $('#viewExam').css("display","none");
        });
    });
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
    $( function() {
        $( "#datepicker2").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
</script>

<script>
    $( function() {
 
		$( "#className, #datepicker1, #datepicker2").on( "change", function() {
            var className = $('#className').val();
            var startdate = $('#datepicker1').val();
            var enddate = $('#datepicker2').val();
			
			if(className!='' && startdate!="" && enddate!="") {
            $.ajax({
                url: "ajax-add-exam-time-table.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
                context: document.body
            }).done(function(response) {
                $('#timetableentry').html(response);
            });
			}
        });
		
		
     } );
	
</script>

<script>
    $(function() {
        $('.viewExamBtn').click(function() {
            $('#addExam').hide();
            $('#editExam').hide();
            $('#viewExam').toggle();

            var id = $(this).siblings('.examId').val();
            $.ajax({
                url: "ajax-view-time-table.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#viewExam').html(response);
            });
        });
    });
</script>

<script>
    $(function() {
        $('.editExamBtn').click(function() {
            $('#addExam').hide();
            $('#viewExam').hide();
            $('#editExam').toggle();
            var id = $(this).siblings('.examId').val();
            $.ajax({
                url: "ajax-edit-time-table.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editExam').html(response);
            });
        });
    });
</script>

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
            minDate: 'today'
        });
    } );

    $( function() {
        $( "#editclassName, #editstartdate, #editenddate").on( "change", function() {
            var className = $('#editclassName').val();
            var startdate = $('#editstartdate').val();
            var enddate = $('#editenddate').val();
            if(className!='' && startdate!="" && enddate!="") {
				$.ajax({
					url: "ajax-edit-exam-subject.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
					context: document.body
				}).done(function(response) {
					$('#edittimetableentry').html(response);
				});
			}
        });
    } );
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
    
	
		var className = $('#className').val();
		
		if(className.includes("100")) { var className = "100"; }
		
		var startdate = $('#datepicker1').val();
		var enddate = $('#datepicker2').val();
			
		if(className!='' && startdate!="" && enddate!="") {
		$.ajax({
			url: "ajax-add-exam-time-table.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
			context: document.body
		}).done(function(response) {
			$('#timetableentry').html(response);
		});
		}
	}
}
</script>
</body>
</html>
