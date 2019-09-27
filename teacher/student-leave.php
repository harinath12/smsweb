<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");


// Finds extensions of files
        function findexts($filename) {
          $filename=strtolower($filename);
          $exts=split("[/\\.]", $filename);
          $n=count($exts)-1;
          $exts=$exts[$n];
          return $exts;
        }
		


$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

$csql = "SELECT id,class_name FROM `classes` WHERE class_name='$className'";
$cexe = mysql_query($csql);
$cfet = @mysql_fetch_array($cexe);
$classId = $cfet['id'];

$stu_sql = "select si.user_id from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
where users.delete_status=1 and aca.class ='$classId' and aca.section_name='$sectionName'";

$student_list = "";
$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);
if($stu_cnt>0)
{
	while($stu_fet = mysql_fetch_array($stu_exe))
	{
		if($student_list=="")
		{
		$student_list = $stu_fet['user_id'];
		}
		else
		{
		$student_list = $student_list.','.$stu_fet['user_id'];
		}
	}
}

$remark_sql = "SELECT * FROM `student_leave` WHERE student_id IN ($student_list)";
$remark_exe = mysql_query($remark_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                        <h4><i class="fa fa-th-large position-left"></i> STUDENT LEAVE</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Student Leave</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h3 class="box-title" style="line-height:30px;">Student Leave - <?php echo $className . " " . $sectionName; ?></h3>
                            </div><!-- /.box-header -->
							<div class="row hidden">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <button type="button" class="form-control btn btn-info" id="addHomeWorkBtn">Apply Leave</button>
                                </div>
                            </div>
                            <div class="row" id="editHomeWork">

                            </div>

                            <div class="row" id="addHomeWork" style="display: none;">
                                <div class="panel-body">
                                    <form action="doleaveapply.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
                                        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
                                            <b>Apply Leave</b>
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Leave Subject</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="title" id="title" value=""/>
                                                    </div>
                                                </div>

                                                
												<div class="form-group">
                                                    <label class="control-label col-lg-4">Leave From Date</label>
                                                    <div class="col-lg-8">
                                                        <div class='input-group date'>
															<input type='text' class="form-control" id='datepicker1' name="fromdate"/>
															<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
														</div>
                                                    </div>
                                                </div>

												<div class="form-group">
                                                    <label class="control-label col-lg-4">Leave To Date</label>
                                                    <div class="col-lg-8">
                                                        <div class='input-group date'>
															<input type='text' class="form-control" id='datepicker2' name="todate"/>
															<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
														</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Leave Reason</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="description" id="description" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Attachment</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="LeaveApplyFile">
                                                    </div>
                                                </div>
												
											</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <input type="submit" value="APPLY" class="btn btn-info form-control" onclick="return show_confirm();"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            
							<div class="box-body" id="predate">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>APPLY ON</th>
										<th>TITLE</th>
                                        <th>DETAILS</th>
                                        <th>DATES</th>
                                        <th>ATTACHMENT</th>
										<th>STATUS</th>
										<th>ACTION</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($remark_fet=mysql_fetch_array($remark_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date_display($remark_fet['created_at']); ?></td>
											<td><?php echo $remark_fet['title']; ?></td>
											<td>
                                                <?php
                                                if($remark_fet['leave_type'] == 'Text'){
                                                    echo $remark_fet['leave_details'];
                                                }
                                                else  if($remark_fet['leave_type'] == 'Audio'){
                                                    if($remark_fet['leave_details'])
                                                    {
                                                        $file_ext = findexts($remark_fet['leave_details']);


                                                        $file_ext_value = "voice.png";
                                                        ?>
                                                        <a href="javascript:void(0);" data-href="../parent/<?php echo $remark_fet['leave_details']; ?>" class="openPopup">
                                                            <img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
                                                        </a>
                                                    <?php } }?>

                                            </td>
                                            <td><?php echo date_display($remark_fet['leave_from_date']).' :: '.date_display($remark_fet['leave_to_date']); ?></td>
                                            <td>
                                                <?php
                                                if($remark_fet['leave_filepath'])
                                                {
                                                   	$file_ext = findexts($remark_fet['leave_filepath']);	
                                                
												if($file_ext=="png" || $file_ext=="jpg" || $file_ext=="jpeg" || $file_ext=="bmp" || $file_ext=="tif" || $file_ext=="gif")
												{
													$file_ext_value = "image.png";
												}
												
												if($file_ext=="doc" || $file_ext=="docx" || $file_ext=="txt")
												{
													$file_ext_value = "word.png";
												}
												
												if($file_ext=="pdf")
												{
													$file_ext_value = "pdf.png";
												}
												
												if($file_ext=="ppt" || $file_ext=="pptx")
												{
													$file_ext_value = "ppt.png";
												}
												
												if($file_ext=="xls" || $file_ext=="xlsx")
												{
													$file_ext_value = "excell.png";
												}
												
												if($file_ext=="mov" || $file_ext=="mp4" || $file_ext=="3gp" || $file_ext=="wmv" || $file_ext=="flv" || $file_ext=="avi")
												{
													$file_ext_value = "video.png";
												}
												
												
												if($file_ext=="mp3" || $file_ext=="wav" || $file_ext=="wma")
												{
													$file_ext_value = "voice.png";
												}
												
                                                    ?>
													<a href="javascript:void(0);" data-href="<?php echo $remark_fet['leave_filepath']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
                                                <?php } ?>
                                            </td>
											<td>
											<?php 
											if($remark_fet['admin_status']==0) { echo "<p style='color:orange;'>WAITING</p>"; }
											else if($remark_fet['admin_status']==1) { echo "<p style='color:green;'>APPROVED</p>"; }
											else if($remark_fet['admin_status']==2) { echo "<p style='color:red;'>REJECTED</p>"; }
											?>
											</td>
											<td class="text-center">
											<?php if($remark_fet['admin_status']==0) { ?>
												<ul class="icons-list">
													<li><a href="student-leave-action.php?leave_id=<?php echo $remark_fet['id']; ?>&admin_status=1"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-check"></i></button></a></li>&nbsp;&nbsp;
													<li><a href="student-leave-action.php?leave_id=<?php echo $remark_fet['id']; ?>&admin_status=2"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-times"></i></button></a></li>&nbsp;&nbsp;
												</ul>
											<?php } else { ?>
												PROCESSED
											<?php } ?>
											</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.content -->
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
        });
		$( "#datepicker2").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
        });
    } );
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,
                columnDefs: [
                    {
                        width: '5%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets:[1,2,3]
                    },
                    {
                        width: '10%',
                        targets: [4,5,6]
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
<!-- page script -->

<script>
    $( function() {
        $( "#datepicker1").on( "change", function() {
            var d = $(this).val();
        });
		$( "#datepicker2").on( "change", function() {
            var d = $(this).val();
        });
    } );
</script>



<script>
    $(function() {
        $('.className').change(function() {
            var clsId = $('#className').val();
            $('#sectionName').empty();
            
			$.get('ajaxsection.php', {cid: clsId}, function(result){
				console.log(result);
                var sublist = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.section_name + "'>" + item.section_name + "</option>";
                });
                $("#sectionName").html(sublist);
            });
        });
    });
</script>


<script>
    $(function() {
        $('#addHomeWorkBtn').click(function() {
            $('#addHomeWork').toggle();
            $('#editHomeWork').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.editHomeWorkBtn').click(function() {
            $('#addHomeWork').hide();
            $('#editHomeWork').toggle();
            var id = $(this).siblings('.homeworkId').val();
            $.ajax({
                url: "ajax-edit-home-work.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editHomeWork').html(response);
            });
        });
    });
</script>
<script type="text/javascript">
    function show_confirm() {
        var txt = 'HI';
        var From_Message =  'From Date::'+$('#className').val();
        var To_Message =  'To Date::'+$('#sectionName').val();
        var title_Message =  'Title::'+$('#title').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to apply the Leave?'+'\n'+From_Message+'\n'+To_Message+'\n'+title_Message+'\n'+details_Message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            </div>
        </div>
      
    </div>
</div>
<script>
$(document).ready(function(){
	
	$(document).on("click", '.openPopup', function(event) { 
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal').modal({show:true});
			$('#myModal .modal-body').html('<iframe src="'+dataURL+'" width="100%" height="100%" />');
        });
    }); 
	
});
</script>
<style>
div.modal-dialog { width:75% !important; }
div.modal-body { height:600px !important; }
</style>
</body>
</html>