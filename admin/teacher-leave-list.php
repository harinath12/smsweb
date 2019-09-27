<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];


// Finds extensions of files
function findexts($filename) {
  $filename=strtolower($filename);
  $exts=split("[/\\.]", $filename);
  $n=count($exts)-1;
  $exts=$exts[$n];
  return $exts;
}



$teacher_sql = "SELECT sl.*,sg.teacher_name,sa.class_handling FROM `teacher_leave` AS sl 
LEFT JOIN `teacher_general` AS sg ON sg.user_id = sl.teacher_id 
LEFT JOIN `teacher_academic` as sa on sa.user_id = sl.teacher_id 
WHERE sl.teacher_id>0 ";
$teacher_exe = mysql_query($teacher_sql);
$teacher_cnt = @mysql_num_rows($teacher_exe);

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
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Teacher Leave List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Teacher Leave List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body">
                            <form method="post" action="">
                                <div class="panel-body">
                                    <?php
                                    if(isset($_REQUEST['import'])){
                                        if($_REQUEST['import'] == 1){
                                            ?>
                                            <div class="alert alert-success alert-dismessible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Teacher Info imported Successfully</strong>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                     
                                </div>
                                <?php
                                if($teacher_cnt>0)
                                {
                                    ?>
                                     <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>APPLIED ON</th>
                                                <th>LEAVE DATE</th>
												<th>NAME</th>
                                                <th>CLASS</th>
                                                <th>SUBJECT</th>
                                                <th>DETAILS</th>
                                                <th>ATTACHMENT</th>
												<th>STATUS</th>
                                                <th class="text-center">ACTIONS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i =1;
                                            while($teacher_fet=mysql_fetch_array($teacher_exe))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td>
													<?php //$applyon = explode(" ",$teacher_fet['created_at']); echo $applyon[0]; ?>
													<?php echo date_display($teacher_fet['created_at']); ?>
													</td>
                                                    <td>
													<?php //echo $teacher_fet['leave_from_date'].' :: '.$teacher_fet['leave_to_date']; ?>
													<?php echo date_display($teacher_fet['leave_from_date']); ?>
													<?php if($teacher_fet['leave_to_date']!="") { ?>
													<?php echo ' :: '.date_display($teacher_fet['leave_to_date']);?>
													<?php } ?>
													</td>
													<td><?php echo $teacher_fet['teacher_name']; ?></td>
                                                    <td><?php echo $teacher_fet['class_handling']; ?></td>
                                                    <td><?php echo $teacher_fet['title']; ?></td>
                                                    <td>
														<?php
														if($teacher_fet['leave_type'] == 'Text'){
															echo $teacher_fet['leave_details'];
														}
														else  if($teacher_fet['leave_type'] == 'Audio'){
														if($teacher_fet['leave_details'])
														{
															$file_ext = findexts($teacher_fet['leave_details']);


															$file_ext_value = "voice.png";
															?>
															<a href="javascript:void(0);" data-href="../teacher/<?php echo $teacher_fet['leave_details']; ?>" class="openPopup">
																<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
															</a>
															&nbsp;&nbsp;&nbsp; 
																<a href="<?php echo '../teacher/' . $teacher_fet['leave_details']; ?>" download> <i class="fa fa-microphone"></i> </a>
														<?php } }?>

													</td>
                                                    <td>
													<?php
													if($teacher_fet['leave_filepath'])
													{
														$file_ext = findexts($teacher_fet['leave_filepath']);	
													
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
                                                        <a href="javascript:void(0);" data-href="../teacher/<?php echo $teacher_fet['leave_filepath']; ?>" class="openPopup">
                                                            <img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
                                                        </a>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <a href="<?php echo '../teacher/' . $teacher_fet['leave_filepath']; ?>" download> <i class="fa fa-microphone"></i> </a>
													<?php } ?>
                                            </td>
											<td>
											<?php 
											if($teacher_fet['admin_status']==0) { echo "<p style='color:orange;'>WAITING</p>"; }
											else if($teacher_fet['admin_status']==1) { echo "<p style='color:green;'>APPROVED</p>"; }
											else if($teacher_fet['admin_status']==2) { echo "<p style='color:red;'>REJECTED</p>"; }
											?>
											</td>
                                                    <td class="text-center">
                                                        <?php if($teacher_fet['admin_status']==0) { ?>
                                                        <ul class="icons-list">
                                                            <li><a href="teacher-leave-action.php?leave_id=<?php echo $teacher_fet['id']; ?>&admin_status=1"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-check"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="teacher-leave-action.php?leave_id=<?php echo $teacher_fet['id']; ?>&admin_status=2"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-times"></i></button></a></li>&nbsp;&nbsp;
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
                                    </span>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> Records are being updated. </b></p>
                                <?php
                                }
                                ?>
                            </form>
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script type='text/javascript'>
    $(document).ready(function() {
        $('.datatable').DataTable({
            autoWidth: false,
            "scrollX": true,
            columnDefs: [
                {
                    width:'15%',
                    orderable: false,
                    targets: 7
                }
            ]
        });
    });
</script>
<!-- page script -->

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
        $('#myModal').on('hidden.bs.modal', function (e) {
            $('#myModal .modal-body').html('<iframe src="" width="100%" height="100%" />');
        });
    });
</script>
<style>
    div.modal-dialog { width:75% !important; }
    div.modal-body { height:600px !important; }
</style>


</body>
</html>