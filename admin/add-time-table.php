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
 
$exam_sql="SELECT * FROM `exam_time_table` WHERE `exam_status`=1";
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
								<a href="time-table.php">
									<button type="button" class="form-control btn btn-info"> Time Table </button>
								</a>
                            </div>
                        </div>
                        <div class="row" id="editExam">

                        </div>
                        <div class="row" id="viewExam">

                        </div>

                        <div class="row" id="addExam" style="display: block;margin: 0px 20px;">
                            <div class="panel-body">
                                <h4>Add Time Table</h4>
                                <form action="doaddtimetable.php" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                    
										<div class="form-group">
                                            <label class="control-label col-lg-2">Class</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="className" id="className">
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['class_name']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
										<br/>
									</div>
									<div class="col-md-12">
                                    
										<div class="form-group">
											<label class="control-label col-lg-2">Section</label>
											<div class="col-lg-4">
                                                <select class="form-control" name="sectionName" id="sectionName">
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                        </div>									
										<br/>
									</div>
									
                                    <div class="col-md-12">
                                        <div id="timetableentry" style="overflow-x: scrollX;padding: 0px 10px;margin: 0px 20px;">

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

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
    $(function() {
        $('#className').change(function() {
			$('#sectionName').empty();
            $('#timetableentry').empty();
			$.get('sectionscript.php', {cls: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionName").html(list);
            });
        });
    });
</script>

<script>
    $( function() {
 
		$( "#sectionName").on( "change", function() {
            var className = $('#className').val();
            var sectionName = $('#sectionName').val();
			if(className!='' && sectionName!="") {
            $.ajax({
                url: "ajax-add-time-table.php?sectionName=" + sectionName + "&className=" + className,
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
                url: "ajax-view-examtimetable.php?id=" + id,
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
                url: "ajax-edit-examtimetable.php?id=" + id,
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
