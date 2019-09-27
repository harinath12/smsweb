<?php session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

$circu_sql="SELECT gal.*, c.class_name FROM `gallery` AS gal
LEFT JOIN classes AS c ON c.id = gal.class
WHERE gallery_status=1 GROUP BY gal.gallery_title ORDER BY gal.id DESC";
$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);
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
                Gallery
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Gallery</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Gallery</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            if(isset($_REQUEST['succ'])){
                                if($_REQUEST['succ'] == 1){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Gallery updated Successfully</strong>
                                    </div>
                                <?php
                                }
                                else if($_REQUEST['succ'] == 2){
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Gallery deleted Successfully</strong>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3" style="float: right">
                                    <a href="create-gallery.php"><button type="button" class="form-control btn btn-info">Create Gallery</button></a>
                                </div>
                            </div>
                            </br>
                            <?php
                            if($circu_cnt>0)
                            {
                                ?>
                               <div class="row">
                                   <?php
                                   $i = 0;
                                   while($circu_fet=mysql_fetch_assoc($circu_exe))
                                   {
                                   ?>
                                       <div class="col-md-3 col-lg-3">
                                           <p>
                                               <?php //echo $circu_fet['gallery_date']; ?>
											   <?php echo date_display($circu_fet['gallery_date']);?>
                                           </p>
                                           <?php
                                           $video_ext = array('mp4','ogg','wmv','wma','flv','avi','m4a','m4v','f4v','f4a','m4b', 'm4r', 'mov', 'vob', 'mkv', 'webm', 'mpg', 'mpeg');
                                           $filePath = $circu_fet['gallery_file_path'];

                                           if((strpos($filePath, 'mp4')) || (strpos($filePath, 'wmv'))||(strpos($filePath, 'mpeg'))||(strpos($filePath, 'mpg'))||(strpos($filePath, 'flv'))||(strpos($filePath, 'avi'))||(strpos($filePath, 'webm'))){
                                               ?>
                                               <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                           <video src="<?php echo $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" controls>
                                               Your browser does not support the video tag.
                                           </video>
                                               </a>
                                           <?php
                                           }
                                           elseif(strpos($filePath, 'mp3')){
                                               ?>
                                               <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                               <audio controls class="form-control" style="height: 200px;">
                                                   <source src="<?php echo $circu_fet['gallery_file_path'];?>">
                                                   Your browser does not support the audio element.
                                               </audio>
                                           </a>
                                           <?php
                                           }
                                           else{
                                           ?>
                                               <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                                   <img src="<?php echo $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" alt="<?php echo $circu_fet['gallery_title']; ?>" title="<?php echo $circu_fet['gallery_title']; ?>"/>
                                               </a>

                                           <?php
                                           }
                                           ?>
                                           <p>
                                               <?php
                                               if($circu_fet['class'] == '100'){
                                                   echo "All -" .  $circu_fet['gallery_title'] . "-" . $circu_fet['description'];
                                               }
                                               else{
                                                   echo $circu_fet['class_name'] . "-" .  $circu_fet['gallery_title'] . "-" . $circu_fet['description'];
                                               }
                                               ?>
                                           </p>
                                           <div class="row">
                                                <div class="col-md-6">
													<a href="gallery-edit.php?id=<?php echo $circu_fet['id'];?>">
														<button class="btn btn-info form-control">Edit</button>
													</a>
                                                </div>
											    <div class="col-md-6">
												<?php if($circu_fet['admin_status']==0) { ?>
													<a href="doapprovegallery.php?id=<?php echo $circu_fet['id'];?>">
														<button class="btn btn-info form-control">Approve</button>
													</a>
												<?php } ?>
												</div>
                                           </div>

                                           </br>
                                       </div>

                                   <?php
                                       $i++;
                                   }
                                   ?>
                               </div>
							   
                                <?php
								/*
                                $gal_exe = mysql_query("select * from gallery where admin_status=0 and gallery_status=1");
                                $gal_cnt = mysql_num_rows($gal_exe);
                                if($gal_cnt > 0) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="doapprovegallery.php">
                                                <button class="btn btn-info form-control">Approve</button>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                }
								*/
								?>
								
							<?php	
                            }
                            else{
                                ?>
                                <p><b> Records are being updated. </b></p>
                            <?php
                            }
                            ?>
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
    $(document).ready( function () {
        $('.datatable').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 5
                }
            ]
        });
    } );
</script>
<!-- page script -->

</body>
</html>
