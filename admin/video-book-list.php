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

$proj_sql = "select * from video_books where project_status='1'";
$proj_exe = mysql_query($proj_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Video Books
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Video Books</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Video Books</h3>
                        </div><!-- /.box-header -->
                        <div class="row">
                            <div class="col-md-3">
                                <a href="video-book-add.php">
                                    <button type="button" class="form-control btn btn-info">Add Video Book</button>
                                </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <select class="form-control hidden" name="term" id="term" required>
                                                    <option value="">Select Term</option>
                                                    <option value="Term 1">Term 1</option>
                                                    <option value="Term 2">Term 2</option>
                                                    <option value="Term 3">Term 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>CLASS</th>
                                    <th>SUBJECT</th>
									<th>TERM</th>
									<th>CHAPTER</th>
                                    <th>DESCRIPTION</th>
                                    <th>VIDEO BOOKS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i =1;
                                while($proj_fet=mysql_fetch_array($proj_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $proj_fet['class'] . ' ' . $proj_fet['section']; ?></td>
                                        <td><?php echo $proj_fet['subject'] ?></td>
										<td><?php echo $proj_fet['term'] ?></td>
										<td><?php echo $proj_fet['chapter'] ?></td>
                                        <td><?php echo $proj_fet['description']; ?></td>
                                        <td>
                                            <?php
                                            if($proj_fet['project1'])
                                            {
												$file_ext_value = findexts($proj_fet['project1']);
                                                ?>
												<a href="javascript:void(0);" data-href="<?php echo $proj_fet['project1']; ?>" class="openPopup">
												<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="<?php echo $proj_fet['project1']; ?>" download> <i class="fa fa-download"></i> </a>
                                            <?php } ?>
											<br/>
											<?php
                                            if($proj_fet['project2'])
                                            {
												$file_ext_value = findexts($proj_fet['project2']);
                                                ?>
                                                <a href="javascript:void(0);" data-href="<?php echo $proj_fet['project2']; ?>" class="openPopup">
												<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
												</a>
												&nbsp;&nbsp;&nbsp; 
												<a href="<?php echo $proj_fet['project2']; ?>" download> <i class="fa fa-download"></i> </a>
                                            <?php } ?>
											</br>
                                            <?php
                                            if($proj_fet['project3'])
                                            {
												$file_ext_value = findexts($proj_fet['project3']);
                                                ?>
                                                <a href="javascript:void(0);" data-href="<?php echo $proj_fet['project3']; ?>" class="openPopup">
												<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
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
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-project.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

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

            });

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
