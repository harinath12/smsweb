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

$stud_sql = "SELECT gen.user_id, gen.student_name, aca.class, aca.section_name FROM student_academic as aca
LEFT JOIN student_general as gen on gen.user_id = aca.user_id
LEFT JOIN users as usr on usr.id = gen.user_id
WHERE aca.class = '$classId' and aca.section_name='$sectionName' and usr.delete_status='1'";
$stud_exe = mysql_query($stud_sql);
$stud_results = array();
while($row = mysql_fetch_assoc($stud_exe)) {
    array_push($stud_results, $row);
}

$remark_sql = "select re.*, gen.student_name from teacher_remarks as re
LEFT JOIN student_general as gen on gen.user_id = re.student_id
where teacher_id='$user_id' and remarks_date='$date' and remarks_status='1'";
$remark_exe = mysql_query($remark_sql);

$remark_cnt = @mysql_num_rows($remark_exe);
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
        .req{
            color: red;
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
                        <li class="active">Teacher Remarks</li>
                        <button type="button" class="btn btn-info" style="float:right; padding:3px 10px;" id="addRemarksBtn">Add Remarks</button>
                    </ul>

                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Remarks inserted Successfully</strong>
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
                            <div class="row" id="editRemarks">

                            </div>
                            <div class="row" id="addRemarks" style="display: none;">
                                <div class="panel-body">
                                    <form action="doaddremarks.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
                                        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
                                            <b>Add Remarks</b>
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Student <span class="req"> *</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="studentId[]" id="studentId" multiple required>
                                                            <option value="">Select Student</option>
                                                            <option value="all">All</option>
                                                            <?php
                                                            foreach($stud_results as $key => $value){ ?>
                                                                <option value="<?php echo $value['user_id']; ?>"><?php echo $value['student_name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="hidden" class="form-control" name="studentName" id="studentName" value=""/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-lg-4">Title <span class="req"> *</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="title" id="title" value="" required/>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <label class="control-label col-lg-4">Remarks Type</label>
                                                    <div class="col-lg-8">
                                                        <input type="radio" name="remarksType" class="remarksType" value="Text"/> Text &nbsp;&nbsp;
                                                        <input type="radio" name="remarksType" class="remarksType" value="Audio"/> Video / Audio
                                                    </div>
                                                </div>

                                                <div class="row form-group" id="remarksText" style="display:none;">
                                                    <label class="control-label col-lg-4">Remarks Details</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="remark_details" id="remark_details" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row form-group" id="remarksAudio" style="display:none;">
                                                    <label class="control-label col-lg-4">Attachment</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="remarkFile" accept="*/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <input type="submit" value="ADD" class="btn btn-info form-control" onclick="return show_confirm();"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form method="post">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>STUDENT NAME</th>
                                        <th>TITLE</th>
                                        <th>DETAILS</th>
                                        <th>ATTACHMENT</th>
                                        <th>ACTIONS</th>
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
                                            <td>
                                                <?php
                                                if($remark_fet['student_id'] == 'all'){
                                                    echo 'All';
                                                }
                                                else{
                                                    echo $remark_fet['student_name'];
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $remark_fet['title']; ?></td>
                                            <td><?php echo $remark_fet['remark_details']; ?></td>
                                            <td>
                                                <?php
                                                if($remark_fet['remark_filepath'])
                                                {
														
													$file_ext = findexts($remark_fet['remark_filepath']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo $remark_fet['remark_filepath']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    
													
                                                    <a href="<?php echo $remark_fet['remark_filepath']; ?>" target="_blank"> <i class="fa fa-microphone"></i> </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <input type="hidden" class="remarksId" value="<?php echo $remark_fet['id'];?>"/>
                                                <button type="button" class="btn btn-info editRemarksBtn" ><i class="fa fa-pencil"></i></button>
                                                <a href="dodeleteremarks.php?id=<?php echo $remark_fet['id']; ?>" title="Delete" style="color: black;">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-trash"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </form>
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
                                        width: '20%',
                                        targets:1
                                    },
                                    {
                                        width: '15%',
                                        targets:2
                                    },
                                    {
                                        width: '25%',
                                        targets: 3
                                    },
                                    {
                                        width: '15%',
                                        targets: [4,5],
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
        $('#addRemarksBtn').click(function() {
            $('#addRemarks').toggle();
            $('#editRemarks').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.editRemarksBtn').click(function() {
            $('#addRemarks').hide();
            $('#editRemarks').toggle();
            var id = $(this).siblings('.remarksId').val();
            $.ajax({
                url: "ajax-edit-remarks.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editRemarks').html(response);
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $('#studentId').change(function() {
            var studId =  $('#studentId').val();
            $.get('ajax-student-name.php', {studid: studId}, function(result){
                $("#studentName").val(result.trim());
            });
        });
    });

    function show_confirm() {
        //var remark_details_Message =null;
        var title_Message =  'Title::'+$('#title').val();
        var studentName_Message =  'Student Name::'+$('#studentName').val().trim();
        if($('#remark_details').val()){
            var remark_details_Message =  'Remarks::'+$('#remark_details').val();
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message+'\n'+remark_details_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else{
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
</script>

<script>
    $(function() {
        $('.remarksType').change(function() {
            var rType = $('input[name="remarksType"]:checked').val();
            if(rType == 'Text'){
                $('#remarksAudio').hide();
                $('#remarksText').show();
            }
            else if(rType == 'Audio'){
                $('#remarksText').hide();
                $('#remarksAudio').show();
            }
        });
    });
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
    $('.openPopup').on('click',function(){
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