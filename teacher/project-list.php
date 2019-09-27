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


$classHandling = $teacher_fet['class_handling'];
$clsteacherhandling = explode(",", $classHandling);
$clsteacherhandling_array=array_map('trim',$clsteacherhandling);
//print_r($clsteacherhandling_array);

$subjectHandling = $teacher_fet['subject'];
$sbjteacherhandling = explode(",", $subjectHandling);
$sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);
//print_r($sbjteacherhandling_array);


$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$home_sql = "select * from project where teacher_id='$user_id' and date='$date' and class='$className' and section='$sectionName' and project_status='1'";
$home_sql = "select * from project where teacher_id='$user_id' and date='$date' and project_status='1'";
$home_exe = mysql_query($home_sql);
$home_cnt = @mysql_num_rows($home_exe);
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
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> PROJECT</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Project</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Project inserted Successfully</strong>
                            </div>
                        <?php
                        }
                        else if($_REQUEST['succ'] == 2) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Project updated Successfully</strong>
                            </div>
                        <?php
                        }
                        else if($_REQUEST['succ'] == 3) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Project deleted Successfully</strong>
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
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <button type="button" class="form-control btn btn-info" id="addProjectBtn">Add Project</button>
                                </div>
                            </div>
                            <div class="row" id="addProject" style="display: none;">
                                <div class="panel-body">
                                    <form action="doaddproject.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
                                        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
                                            <b>Add Project</b>
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Class</label>
                                                    <div class="col-lg-8">
                                                        
														<?php if(empty($classHandling)) { ?>
                                                        <input type="text" class="form-control" name="className" id="className" value="<?php echo $className;?>" readonly/>
														<?php } else { ?>
														<select class="form-control className" name="className" id="className" required>
															<option value="">Select Class</option>
															<?php
															foreach($clsteacherhandling_array as $key => $value){ ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php
															}
															?>
														</select>
														<?php } ?>
														
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Section</label>
                                                    <div class="col-lg-8">
                                                        <?php if(empty($classHandling)) { ?>
                                                        <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
														<?php } else { ?>
														<select class="form-control sectionName" name="sectionName" id="sectionName" required>
															<option value="">Select Section</option>
														</select>
														<?php } ?>
													</div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                                    <div class="col-lg-8">
													
														<select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                            <option value="">Select Subject</option>
                                                            <?php
                                                            foreach($sbjteacherhandling_array as $key => $value){ ?>
                                                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
														
													<?php /* ?>
                                                        <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                            <option value="">Select Subject</option>
                                                            <?php
                                                            foreach($sub_results as $key => $value){ ?>
                                                                <option value="<?php echo $value['subject_name']; ?>"><?php echo $value['subject_name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
													<?php */ ?>
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Project Details</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="description" id="description" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Project File(1)</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="project1" value=""/>
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Project File(2)</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="project2" value=""/>
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="form-group">
                                                    <label class="control-label col-lg-4">Project File(3)</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="project3" value=""/>
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
                            <div class="row" id="editProject">

                            </div>
                            <form method="post">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>CLASS</th>
                                        <th>SUBJECT</th>
                                        <th>DESCRIPTION</th>
                                        <th>ATTACHMENTS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($home_fet=mysql_fetch_array($home_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $home_fet['class'] . ' ' . $home_fet['section']; ?></td>
                                            <td><?php echo $home_fet['subject'] ?></td>
                                            <td><?php echo $home_fet['description']; ?></td>
                                            <td>
                                                <?php
                                                if($home_fet['project1'])
                                                {
													
													$file_ext = findexts($home_fet['project1']);	
                                                
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
													$file_ext_value = "video.png";
												}
												?>
												<a href="javascript:void(0);" data-href="<?php echo $home_fet['project1']; ?>" class="openPopup">
												<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="<?php echo $home_fet['project1']; ?>" download> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                                <?php
                                                if($home_fet['project2'])
                                                {
													
													$file_ext = findexts($home_fet['project2']);	
                                                
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
													$file_ext_value = "video.png";
												}
                                                    ?>
													<a href="javascript:void(0);" data-href="<?php echo $home_fet['project2']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo $home_fet['project2']; ?>" download> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                                <?php
                                                if($home_fet['project3'])
                                                {
													
													$file_ext = findexts($home_fet['project3']);	
                                                
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
													$file_ext_value = "video.png";
												}
                                                    ?>
                                                    <a href="javascript:void(0);" data-href="<?php echo $home_fet['project3']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo $home_fet['project3']; ?>" download> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <input type="hidden" class="projectId" value="<?php echo $home_fet['id'];?>"/>
                                                <button type="button" class="btn btn-info editProjectBtn" title="Edit"><i class="fa fa-pencil"></i></button>
                                                <a href="dodeleteproject.php?id=<?php echo $home_fet['id']; ?>" title="Delete" style="color: black;" onclick="return confirm('Do you want to delete?');">
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
                                        width: '15%',
                                        targets:[1,2]
                                    },
                                    {
                                        width: '25%',
                                        targets: 3
                                    },
                                    {
                                        width: '20%',
                                        targets: 4,
                                        orderable:false
                                    },
                                    {
                                        width: '15%',
                                        targets: 5,
                                        orderable:false
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
        $('#addProjectBtn').click(function() {
            $('#addProject').toggle();
            $('#editProject').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.editProjectBtn').click(function() {
            $('#addProject').hide();
            $('#editProject').toggle();
            var id = $(this).siblings('.projectId').val();
            $.ajax({
                url: "ajax-edit-project.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editProject').html(response);
            });
        });
    });
</script>

<script type="text/javascript">
    function show_confirm() {
        var className_Message =  'Class::'+$('#className').val();
        var sectionName_Message =  'Section::'+$('#sectionName').val();
        var subjectName_Message =  'Subject::'+$('#subjectId').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to add the Project?'+'\n'+className_Message+'\n'+sectionName_Message+'\n'+subjectName_Message+'\n'+details_Message))
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