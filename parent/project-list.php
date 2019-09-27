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

		
$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$date = date("Y-m-d");
$date1 = date("Y-m-d", strtotime( '-1 days' ) );
$date2 = date("Y-m-d", strtotime( '-2 days' ) );
$date3 = date("Y-m-d", strtotime( '-3 days' ) );
$date4 = date("Y-m-d", strtotime( '-4 days' ) );

$dates = array();
$dates = [$date,$date1,$date2,$date3,$date4];


if(isset($_REQUEST['date']))
{
    $dat=$_REQUEST['date'];
}
else
{
    $dat=date("Y-m-d");
}

$prev_date = date('Y-m-d', strtotime($dat .' -1 day'));
$next_date = date('Y-m-d', strtotime($dat .' +1 day'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Parent</title>
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Projects</li>
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
                            
                            <div class="box-body" id="predate">
							
								<div class="row">

                                    <div class='col-sm-5'>
                                        <a href="project-list.php?date=<?php echo $prev_date; ?>">
                                            <button type="button" class="btn btn-info btn-xs" style="float: left; margin:10px;"><i class="fa fa-arrow-left"></i> <?php //echo $prev_date; ?><?php echo date_display($prev_date); ?></button>
                                        </a>
                                    </div>
                                    <div class='col-sm-2'>
									<div class="form-group">
                                        <div class='input-group date'>
                                            <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                                        </div>
                                    </div>
									</div>
                                    <div class='col-sm-5'>
                                        <?php if($dat==date("Y-m-d")) { ?>
                                            <a href="#">
                                                <button type="button" class="btn btn-infoX btn-xs" style="float: right; margin:10px;"><?php //echo $next_date; ?>None <i class="fa fa-arrow-right"></i> </button>
                                            </a>
                                        <?php } else { ?>
                                            <a href="project-list.php?date=<?php echo $next_date; ?>">
                                                <button type="button" class="btn btn-info btn-xs" style="float: right; margin:10px;"><?php //echo $next_date; ?><?php echo date_display($next_date); ?> <i class="fa fa-arrow-right"></i> </button>
                                            </a>
                                        <?php } ?>
                                    </div>


                                </div>
								
                                <table id="example2" class="table datatable curdate">
                                    <thead>
                                    <tr>
                                        <th colspan="4">
                                            
											<center>
											<?php if($dat==date("Y-m-d")) { ?>
											TODAY PROJECTS :: <?php //echo $dat; ?><?php echo date_display($dat); ?>
											<?php } else { ?>
											PROJECTS :: <?php //echo $dat; ?><?php echo date_display($dat); ?>
											<?php } ?>
											</center>
											
                                        </th>
                                    </tr>
                                    </thead>
									
									<thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>SUBJECT</th>
                                        <th>DESCRIPTION</th>
                                        <th>ATTACHMENTS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
										$proj_exe = mysql_query("select * from project where class='$className' and section='$sectionName' and date='$dat' and admin_status='1'");
                                        ?>
                                         
                                        <?php
                                        $i = 1;
										$proj_count=@mysql_num_rows($proj_exe);
                                        if($proj_count>0) 
										{
										while($proj_fet=mysql_fetch_array($proj_exe))
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <?php echo $proj_fet['subject']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $proj_fet['description']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($proj_fet['project1'])
                                                    {
                                                       	
												$file_ext = findexts($proj_fet['project1']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project1']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $proj_fet['project1']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
													<br/><br/>
                                                    <?php } ?>
                                                
												<?php
                                                    if($proj_fet['project2'])
                                                    {
                                                      	
												$file_ext = findexts($proj_fet['project2']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project2']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $proj_fet['project2']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
													<br/><br/>
                                                    <?php } ?>
                                                
												<?php
                                                    if($proj_fet['project3'])
                                                    {
                                                          	
												$file_ext = findexts($proj_fet['project3']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project3']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $proj_fet['project3']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
													<br/><br/>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
										}
										else
										{
                                    ?>
									<tr>
										<td colspan="4"><center>No Projects Found</center></td>
									</tr>
									<?php 
										}
									?>
									
                                    </tbody>

                                </table>
                            
								<div class="row">

                                    <div class='col-sm-5'>
                                        <a href="project-list.php?date=<?php echo $prev_date; ?>">
                                            <button type="button" class="btn btn-info btn-xs" style="float: left; margin:10px;"><i class="fa fa-arrow-left"></i> <?php //echo $prev_date; ?><?php echo date_display($prev_date); ?></button>
                                        </a>
                                    </div>
                                    <div class='col-sm-2'>
									</div>
                                    <div class='col-sm-5'>
                                        <?php if($dat==date("Y-m-d")) { ?>
                                            <a href="#">
                                                <button type="button" class="btn btn-infoX btn-xs" style="float: right; margin:10px;"><?php //echo $next_date; ?>None <i class="fa fa-arrow-right"></i> </button>
                                            </a>
                                        <?php } else { ?>
                                            <a href="project-list.php?date=<?php echo $next_date; ?>">
                                                <button type="button" class="btn btn-info btn-xs" style="float: right; margin:10px;"><?php //echo $next_date; ?><?php echo date_display($next_date); ?> <i class="fa fa-arrow-right"></i> </button>
                                            </a>
                                        <?php } ?>
                                    </div>


                                </div>
							</div><!-- /.box-body -->
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