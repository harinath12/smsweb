<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$clsName = $_REQUEST['className'];
$classId = $_REQUEST['classId'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];

$date = date("Y-m-d");


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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> BOOKS</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="books.php">Books</a></li>
                        <li class="active">Books View</li>
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
                            <div class="panel-body" style="padding-left: 20px;">
                             
							 <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>CLASS</th>
                                    <th>SUBJECT</th>
									<th>TERM</th>
                                    <th>DESCRIPTION</th>
                                    <th>BOOKS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
								
                                $proj_sql="SELECT * FROM `books` WHERE `class`='$clsName' AND `subject`='$subjectName' AND `term`='$term' ";
                                $proj_exe=mysql_query($proj_sql);
                                $i =1;
                                while($proj_fet=mysql_fetch_array($proj_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $proj_fet['class'] . ' ' . $proj_fet['section']; ?></td>
                                        <td><?php echo $proj_fet['subject'] ?></td>
										<td><?php echo $proj_fet['term'] ?></td>
                                        <td><?php echo $proj_fet['description']; ?></td>
                                        <td>
                                            <?php
                                            if($proj_fet['project1'])
                                            {
												$file_ext_value = findexts($proj_fet['project1']);
                                                ?>
												<a href="javascript:void(0);" data-href="../admin/<?php echo $proj_fet['project1']; ?>" class="openPopup">
												<img src="../admin/assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="../admin/<?php echo $proj_fet['project1']; ?>" download> <i class="fa fa-download"></i> </a>
                                            <?php } ?>
											<br/>
											<?php
                                            if($proj_fet['project2'])
                                            {
												$file_ext_value = findexts($proj_fet['project2']);
                                                ?>
                                                <a href="javascript:void(0);" data-href="../admin/<?php echo $proj_fet['project2']; ?>" class="openPopup">
												<img src="../admin/assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="../admin/<?php echo $proj_fet['project2']; ?>" download> <i class="fa fa-download"></i> </a>
                                            <?php } ?>
											</br>
                                            <?php
                                            if($proj_fet['project3'])
                                            {
												$file_ext_value = findexts($proj_fet['project3']);
                                                ?>
                                                <a href="javascript:void(0);" data-href="<?php echo $proj_fet['project3']; ?>" class="openPopup">
												<img src="../admin/assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="<?php echo $proj_fet['project3']; ?>" download> <i class="fa fa-download"></i> </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
 
                            </div>
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

</body>


<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,

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
</html>