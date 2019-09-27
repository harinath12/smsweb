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
		


$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];
$classTeacher = $className . " " . $sectionName;

$teacher_sql = "select aca.* from teacher_academic as aca
Left JOIN users as usr on usr.id = aca.user_id
where delete_status='1' and class_teacher='$classTeacher'";
$teacher_exe = mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$teacherId = $teacher_fet['user_id'];

$remark_sql = "select re.*, tgen.teacher_name from teacher_remarks as re
LEFT JOIN teacher_general as tgen on tgen.user_id = re.teacher_id
where (re.student_id = '$user_id' or (re.student_id = 'all' and tgen.user_id='$teacherId')) and remarks_date='$date' and remarks_status='1' and admin_status='1'";
$remark_exe = mysql_query($remark_sql);
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
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> TEACHER REMARKS</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Teacher Remarks</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h3 class="box-title" style="line-height:30px;">Teacher Remarks - <?php echo $className . " " . $sectionName; ?></h3>
                            </div><!-- /.box-header -->
                            <div class="row">
                                <div class='col-sm-3' style="float: right">
                                    <div class="form-group">
                                        <div class='input-group date'>
                                            <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body" id="predate">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>TEACHER NAME</th>
                                        <th>TITLE</th>
                                        <th>DETAILS</th>
                                        <th>ATTACHMENT</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($remark_fet=mysql_fetch_array($remark_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $remark_fet['teacher_name']; ?></td>
                                            <td><?php echo $remark_fet['title']; ?></td>
                                            <td><?php echo $remark_fet['remark_details']; ?></td>
                                            <td>
                                                <?php
                                                if($remark_fet['remark_filepath'])
                                                {
                                                   	$file_ext = findexts($remark_fet['remark_filepath']);	
                                                
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
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
                                                    <a href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" target="_blank"> <i class="fa fa-microphone"></i> </a>
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
            </div><!-- /.content -->
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
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets:[1,2,4]
                    },
                    {
                        width: '25%',
                        targets: 3
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
                url: "ajax-teacher-remarks.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
                    "bSort": false,
                    autoWidth: false,
                    columnDefs: [
                        {
                            width: '15%',
                            targets: 0
                        },
                        {
                            width: '20%',
                            targets:[1,2,4]
                        },
                        {
                            width: '25%',
                            targets: 3
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