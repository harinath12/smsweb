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
$date1 = date("Y-m-d", strtotime( '-1 days' ) );
$date2 = date("Y-m-d", strtotime( '-2 days' ) );
$date3 = date("Y-m-d", strtotime( '-3 days' ) );
$date4 = date("Y-m-d", strtotime( '-4 days' ) );

$dates = array();
$dates = [$date,$date1,$date2,$date3,$date4];




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



$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .brd{
            border-right: 1px solid grey;
        }

        th{
            text-align: center !important;
        }
    </style>
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
                Class Notes
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Class Notes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Class Notes</h3>
                        </div><!-- /.box-header -->
                        <div class="row">
                            <div class="col-md-3">
                                <a href="class-notes-add.php">
                                    <button type="button" class="form-control btn btn-info">Add Class Notes</button>
                                </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <?php
                            $hom_sql = "select * from class_notes where date='$date' and admin_status='0'";
                            $hom_exe = mysql_query($hom_sql);
                            $hom_cnt = mysql_num_rows($hom_exe);
                            if($hom_cnt > 0){
                                ?>
                                <div class="row">
                                    <div class='col-sm-2'>
                                        <form action="dosendhomework.php" method="post">
                                            <input type="hidden" value="1" name="classNotesAdminStatus"/>
                                            <input type="submit" class="form-control btn btn-info" value="Send" onclick="return confirm('Do you want to send the class notes?');"/>
                                        </form>
                                    </div>
                                </div>
                                </br>
                            <?php
                            }
                            ?>

                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th class="brd">Class</th>
                                    <th class="brd">1</th>
                                    <th class="brd">2</th>
                                    <th class="brd">3</th>
                                    <th class="brd">4</th>
                                    <th class="brd">5</th>
                                    <th class="brd">6</th>
                                    <th class="brd">7</th>
                                    <th>8</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($dates as $dat) {
                                    ?>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php //echo $dat; ?><?php echo date_display($dat);?></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                <?php
                                    foreach($class_master_results as $key => $value) {
                                    $className = $value['class_name'];
                                    $classId = $value['id'];

                                    $section_sql="SELECT cs.* FROM `class_section` as cs  where cs.class_section_status=1 and cs.class_id='$classId'";
                                    $section_exe=mysql_query($section_sql);
                                    $section_results = array();
                                    while($row = mysql_fetch_assoc($section_exe)) {
                                        array_push($section_results, $row);
                                    }

                                    foreach ($section_results as $sec_key => $sec_value) {
                                        $sectionName = $sec_value['section_name'];
                                        ?>
                                            <tr>
                                                <td class="brd"><?php echo $className . " " . $sectionName; ?></td>
                                                <td class="brd">
                                                    <?php
                                                    $fet1 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='I' and date='$dat'"));
                                                    echo $fet1['subject'] . " " . $fet1['description'];
                                                    if($fet1['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet1['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet1['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                       <a href="<?php echo '../teacher/' . $fet1['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet2 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='II' and date='$dat'"));
                                                    echo $fet2['subject'] . " " . $fet2['description'];
                                                    if($fet2['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet2['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet2['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet2['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet3 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='III' and date='$dat'"));
                                                    echo $fet3['subject'] . " " . $fet3['description'];
                                                    if($fet3['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet3['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet3['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet3['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet4 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='IV' and date='$dat'"));
                                                    echo $fet4['subject'] . " " . $fet4['description'];
                                                    if($fet4['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet4['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet4['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet4['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet5 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='V' and date='$dat'"));
                                                    echo $fet5['subject'] . " " . $fet5['description'];
                                                    if($fet5['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet5['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet5['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet5['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet6 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VI' and date='$dat'"));
                                                    echo $fet6['subject'] . " " . $fet6['description'];
                                                    if($fet6['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet6['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet6['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet6['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="brd">
                                                    <?php
                                                    $fet7 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VII' and date='$dat'"));
                                                    echo $fet7['subject'] . " " . $fet7['description'];
                                                    if($fet7['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet7['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet7['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet7['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $fet8 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VIII' and date='$dat'"));
                                                    echo $fet8['subject'] . " " . $fet8['description'];
                                                    if($fet8['class_notes_file_path'])
                                                    {
                                                    $file_ext_value = findexts($fet8['class_notes_file_path']);	
													?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet8['class_notes_file_path']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													
                                                        <a href="<?php echo '../teacher/' . $fet8['class_notes_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
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
