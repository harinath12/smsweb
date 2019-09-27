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

if(isset($_REQUEST['id'])){
    $remId = $_REQUEST['id'];
    if(isset($_REQUEST['send'])) {
        $rem_sql = "update teacher_remarks set admin_status = '1' where id='$remId'";
        $rem_exe = mysql_query($rem_sql);
        header("Location: teacher-remarks.php?suc=1");
    }
    else if(isset($_REQUEST['block'])){
        $rem_sql = "update teacher_remarks set admin_status = '2' where id='$remId'";
        $rem_exe = mysql_query($rem_sql);
        header("Location: teacher-remarks.php?suc=2");
    }
}

$remark_sql = "select re.*, gen.student_name, tgen.teacher_name from teacher_remarks as re
LEFT JOIN student_general as gen on gen.user_id = re.student_id
LEFT JOIN teacher_general as tgen on tgen.user_id = re.teacher_id
where remarks_date='$date' and remarks_status='1'";
$remark_exe = mysql_query($remark_sql);

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
                Teacher Remarks
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Teacher Remarks</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Teacher Remarks</h3>
                        </div><!-- /.box-header -->
                        <div class="row">
                        <?php
                        if(isset($_REQUEST['suc'])) {
                            if ($_REQUEST['suc'] == 1) {
                                ?>
                                <div class="alert alert-success alert-dismessible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Remarks sent Successfully</strong>
                                </div>
                            <?php
                            }
                            if ($_REQUEST['suc'] == 2) {
                                ?>
                                <div class="alert alert-success alert-dismessible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Remarks blocked Successfully</strong>
                                </div>
                            <?php
                            }
                        }
                        ?>
                        </div>
                        <div class="row">
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
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>STUDENT NAME</th>
                                    <th>TEACHER NAME</th>
                                    <th>TITLE</th>
                                    <th>DETAILS</th>
                                    <th style="text-align: center;">ATTACHMENT</th>
                                    <th>ACTION</th>
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
                                        <td>
                                            <?php
                                            if($remark_fet['student_id'] == 'all'){
                                                echo 'All';
                                            }
                                            else{
                                                echo $remark_fet['student_name'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $remark_fet['teacher_name']; ?></td>
                                        <td><?php echo $remark_fet['title']; ?></td>
                                        <td><?php echo $remark_fet['remark_details']; ?></td>
                                        <td style="text-align: center;">
                                            <?php
                                                if($remark_fet['remark_filepath'])
                                                {
                                                   	$file_ext_value = findexts($remark_fet['remark_filepath']);	
                                                
                                                    ?>
													<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" class="openPopup">
													<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
													</a>
													&nbsp;&nbsp;&nbsp; 
													<a href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" download> <i class="fa fa-microphone"></i> </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($remark_fet['admin_status'] == 0)
                                            {
                                                ?>
                                                <a href="teacher-remarks.php?id=<?php echo $remark_fet['id']; ?>&send=1"> <button class="btn btn-info">SEND</button> </a>
                                                <a href="teacher-remarks.php?id=<?php echo $remark_fet['id']; ?>&block=1"> <button class="btn btn-info">BLOCK</button> </a>
                                            <?php }
                                            else if($remark_fet['admin_status'] == 1){
                                                ?>
                                            <div class='row'>
                                                <button class="form-control btn btn-info">SENT</button>
                                            </div>
                                            <?php
                                            }
                                            else if($remark_fet['admin_status'] == 2){
                                                ?>
                                            <div class='row'>
                                                <button class="form-control btn btn-primary">BLOCKED</button>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>

                            <?php
                            $rem_sql = "select * from teacher_remarks where remarks_date='$date' and admin_status='0'";
                            $rem_exe = mysql_query($rem_sql);
                            $rem_cnt = mysql_num_rows($rem_exe);
                            if($rem_cnt > 0){
                                ?>
                                <div class="row hidden">
                                    <div class='col-sm-2'>
                                        <form action="dosendhomework.php" method="post">
                                            <input type="submit" class="form-control btn btn-info" value="Send" onclick="return confirm('Do you want to send the Teacher Remarks?');"/>
                                            <input type="hidden" value="1" name="remarksAdminStatus"/>
                                        </form>
                                    </div>
                                </div>
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
                url: "ajax-teacher-remarks.php?dat=" + d,
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
    $('#myModal').on('hidden.bs.modal', function (e) {
        $('#myModal .modal-body').html('<iframe src="" width="100%" height="100%" />');
        //$('#myModal audio').attr("src", $("#myModal audio").removeAttr("src"));
    });
});
</script>
<style>
div.modal-dialog { width:75% !important; }
div.modal-body { height:600px !important; }
</style>

</body>
</html>
