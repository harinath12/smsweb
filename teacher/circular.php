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


$circu_sql="SELECT * FROM `circular` where circular_status=1 order by circular_date DESC ";
$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);
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
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> CIRCULAR</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Circular</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">Circular</h4>
                            </div>
                            </br>
                            <table id="example2" class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th class="hidden">Circular To</th>
                                    <th>Description</th>
									<th>Attachment</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i =1;
                                while($circu_fet=mysql_fetch_array($circu_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
										<?php //echo $circu_fet['circular_date']; ?>
										<?php echo date_display($circu_fet['circular_date']); ?>
										</td>
                                        <td><?php echo $circu_fet['circular_title']; ?></td>
                                        <td class="hidden"><?php echo $circu_fet['circular_to'] ?></td>
                                        <td><?php echo $circu_fet['circular_message']; ?></td>
										<td>
										<?php
                                            if($circu_fet['circular_file_path'])
                                            {
												
													
													$file_ext = findexts($circu_fet['circular_file_path']);	
                                                
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
												<a href="javascript:void(0);" data-href="<?php echo '../admin/' . $circu_fet['circular_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    
                                                <a href="<?php echo '../admin/' . $circu_fet['circular_file_path'];?>" download title="download">
                                                    <i class="fa fa-download form-controlX"></i>
                                                </a>
                                            <?php
                                            }
                                            ?>
										</td>
                                        <td class="text-center">
                                            <ul class="icons-list">
                                                <li><a href="circular-view.php?circular_id=<?php echo $circu_fet['id']; ?>" title="view"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /basic datatable -->

                    </div>
                </div>

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