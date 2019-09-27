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
    <title>SMS - Student</title>
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
                        <li class="active">Class Notes</li>
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
                                        <a href="class-notes.php?date=<?php echo $prev_date; ?>">
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
                                            <a href="class-notes.php?date=<?php echo $next_date; ?>">
                                                <button type="button" class="btn btn-info btn-xs" style="float: right; margin:10px;"><?php //echo $next_date; ?><?php echo date_display($next_date); ?> <i class="fa fa-arrow-right"></i> </button>
                                            </a>
                                        <?php } ?>
                                    </div>


                                </div>
							
							
                                <table id="example2" class="table datatable curdate">
									<thead>
                                    <tr>
                                        <th>
                                            PEROID
                                        </th>
                                        <th>
                                            
											<?php if($dat==date("Y-m-d")) { ?>
											TODAY CLASS NOTES :: <?php //echo $dat; ?><?php echo date_display($dat); ?>
											<?php } else { ?>
											CLASS NOTES :: <?php //echo $dat; ?><?php echo date_display($dat); ?>
											<?php } ?>
											
                                        </th>
                                    </tr>
                                    </thead>
                                     
                                    <tbody>
                                    
                                        <tr>
                                            <td>1</td>
											<td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='I' and date='$dat' and admin_status='1'"));
                                                echo $fet1['subject'] . " " . $fet1['description'];
                                                if($fet1['class_notes_file_path'])
                                                {
													
														
												$file_ext = findexts($fet1['class_notes_file_path']);	
                                                
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
												
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet1['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet1['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>2</td>
											<td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='II' and date='$dat' and admin_status='1'"));
                                                echo $fet2['subject'] . " " . $fet2['description'];
                                                if($fet2['class_notes_file_path'])
                                                {
													
														
												$file_ext = findexts($fet2['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet2['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet2['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>3</td>
											<td>
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='III' and date='$dat' and admin_status='1'"));
                                                echo $fet3['subject'] . " " . $fet3['description'];
                                                if($fet3['class_notes_file_path'])
                                                {
													
														
												$file_ext = findexts($fet3['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet3['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet3['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>4</td>
											<td>
                                                <?php
                                                $fet4 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='IV' and date='$dat' and admin_status='1'"));
                                                echo $fet4['subject'] . " " . $fet4['description'];
                                                if($fet4['class_notes_file_path'])
                                                {
														
												$file_ext = findexts($fet4['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet4['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet4['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>5</td>
											<td>
                                                <?php
                                                $fet5 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='V' and date='$dat' and admin_status='1'"));
                                                echo $fet5['subject'] . " " . $fet5['description'];
                                                if($fet5['class_notes_file_path'])
                                                {
														
												$file_ext = findexts($fet5['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet5['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet5['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>6</td>
											<td>
                                                <?php
                                                $fet6 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VI' and date='$dat' and admin_status='1'"));
                                                echo $fet6['subject'] . " " . $fet6['description'];
                                                if($fet6['class_notes_file_path'])
                                                {
														
												$file_ext = findexts($fet6['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet6['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet6['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>7</td>
											<td>
                                                <?php
                                                $fet7 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VII' and date='$dat' and admin_status='1'"));
                                                echo $fet7['subject'] . " " . $fet7['description'];
                                                if($fet7['class_notes_file_path'])
                                                {
														
												$file_ext = findexts($fet7['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet7['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet7['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<tr>
											<td>8</td>
											<td>
                                                <?php
                                                $fet8 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VIII' and date='$dat' and admin_status='1'"));
                                                echo $fet8['subject'] . " " . $fet8['description'];
                                                if($fet8['class_notes_file_path'])
                                                {
													
														
												$file_ext = findexts($fet8['class_notes_file_path']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet8['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $fet8['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            
								<div class="row">

                                    <div class='col-sm-5'>
                                        <a href="class-notes.php?date=<?php echo $prev_date; ?>">
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
                                            <a href="class-notes.php?date=<?php echo $next_date; ?>">
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
                columnDefs: [
                    {
                        width: '12%',
                        targets: 0,
                        orderable:false
                    },
                    {
                        width: '11%',
                        targets:[1,2,3,4,5,6,7,8],
                        orderable:false
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
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-class-notes.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
                    "bSort": false,
                    autoWidth: false,
                    columnDefs: [
                        {
                            width: '12%',
                            targets: 0,
                            orderable:false
                        },
                        {
                            width: '11%',
                            targets:[1,2,3,4,5,6,7,8],
                            orderable:false
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