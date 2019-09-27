<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];
$circularId = $_REQUEST['circular_id'];




// Finds extensions of files
function findexts($filename) {
	$filename=strtolower($filename);
	$exts=split("[/\\.]", $filename);
	$n=count($exts)-1;
	$exts=$exts[$n];
	
	$file_ext = $exts;
	$file_ext_value = "image.png";
	
	if($file_ext=="png" || $file_ext=="jpg" || $file_ext=="jpeg" || $file_ext=="bmp" || $file_ext=="tif" || $file_ext=="gif")
	{ $file_ext_value = "image.png"; }

	if($file_ext=="doc" || $file_ext=="docx" || $file_ext=="txt")
	{ $file_ext_value = "word.png"; }

	if($file_ext=="pdf")
	{ $file_ext_value = "pdf.png"; }

	if($file_ext=="ppt" || $file_ext=="pptx")
	{ $file_ext_value = "ppt.png"; }

	if($file_ext=="xls" || $file_ext=="xlsx")
	{ $file_ext_value = "excell.png"; }

	if($file_ext=="mov" || $file_ext=="mp4" || $file_ext=="3gp" || $file_ext=="wmv" || $file_ext=="flv" || $file_ext=="avi")
	{ $file_ext_value = "video.png"; }

	if($file_ext=="mp3" || $file_ext=="wav" || $file_ext=="wma")
	{ $file_ext_value = "voice.png"; }

	return $file_ext_value;
}



$circular_sql="SELECT * FROM `circular` where id=$circularId";
$circular_exe=mysql_query($circular_sql);
$circular_fet = mysql_fetch_assoc($circular_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <title>Admin Panel</title>
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
                View Circular
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="circular-list.php">Circular List</a></li>
                <li class="active">View Circular</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <?php
                    if(isset($_REQUEST['succ'])){
                        if($_REQUEST['succ'] == 1){
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Circular updated Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Circular Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="circularTitle" value="<?php echo $circular_fet['circular_date']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular Title</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="circularTitle" value="<?php echo $circular_fet['circular_title']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Circular To</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" name="circularTitle" value="<?php echo $circular_fet['circular_to']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Message (If any)</label>
                                        <div class="col-lg-8">
                                            <textarea rows="3" class="form-control" name="message" readonly><?php echo $circular_fet['circular_message']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Uploaded File</label>
                                        <div class="col-lg-8">
                                            <?php
                                            if($circular_fet['circular_file_path'])
                                            {
												$file_ext_value = findexts($circular_fet['circular_file_path']);	
                                              
                                                ?>
												<a href="javascript:void(0);" data-href="<?php echo '../admin/' . $circular_fet['circular_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    
                                                <a href="<?php echo '../admin/' . $circular_fet['circular_file_path'];?>" download title="download">
                                                    <i class="fa fa-download form-controlX"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- /form horizontal -->
            </div>
            <!-- /content area -->
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
});
</script>
<style>
div.modal-dialog { width:75% !important; }
div.modal-body { height:600px !important; }
</style>
</body>
</html>