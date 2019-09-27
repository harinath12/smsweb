<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$student_sql = "select * from student_academic where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);
$classId = $student_fet['class'];
$sectionName = $student_fet['section_name'];

$cls_sql = mysql_query("Select * from classes where id='$classId'");
$cls_fet = mysql_fetch_assoc($cls_sql);
$className = $cls_fet['class_name'];
$classTeacher = $className . " " . $sectionName;

$teacher_sql = mysql_query("Select gen.teacher_name, gen.user_id from teacher_academic as aca
Left join teacher_general as gen on gen.user_id = aca.user_id
where aca.class_teacher='$classTeacher'");
$teacher_fet = mysql_fetch_assoc($teacher_sql);
$teacherName = $teacher_fet['teacher_name'];
$teacherId = $teacher_fet['user_id'];

$information_sql = mysql_query("Select * from information_teacher where student_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Parent</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> Information to School/Teacher</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Information to School/Teacher</li>
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
                                <h3 class="box-title" style="line-height:30px;">Information to School/Teacher</h3>
                            </div><!-- /.box-header -->

                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <button type="button" class="form-control btn btn-info" id="addRemarksBtn">Add Information</button>
                                </div>
                            </div>
                            <div class="row" id="addRemarks" style="display: none;">
                                <div class="panel-body">
                                    <form action="doaddinformationteacher.php" method="post" enctype="multipart/form-data" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
                                        <h4 class="panel-title" style="margin: 0 0 20px 20px;">
                                            <b>Add Information</b>
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-lg-4">Teacher <span class="req"> *</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="teacherName" id="teacherName" value="<?php echo $teacherName; ?>" required/>
                                                        <input type="hidden" class="form-control" name="teacherId" id="teacherId" value="<?php echo $teacherId ?>" required/>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <label class="control-label col-lg-4">Title <span class="req"> *</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" name="title" id="title" value="" required/>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <label class="control-label col-lg-4">Information Type</label>
                                                    <div class="col-lg-8">
                                                        <input type="radio" name="remarksType" class="remarksType" value="Text"/> Text &nbsp;&nbsp;
                                                        <input type="radio" name="remarksType" class="remarksType" value="Audio"/> Audio
                                                    </div>
                                                </div>

                                                <div class="row form-group" id="remarksText" style="display:none;">
                                                    <label class="control-label col-lg-4">Information Details</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="remark_details" id="remark_details" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row form-group" id="remarksAudio" style="display:none;">
                                                    <label class="control-label col-lg-4">Attachment</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" name="remarkFile" accept="audio/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <input type="submit" value="ADD" class="btn btn-info form-control" onclick="return show_confirm();"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            </br>
                            <form method="post">
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
                                    while($information_fet=mysql_fetch_array($information_sql))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php echo $information_fet['teacher_name']; ?>
                                            </td>
                                            <td><?php echo $information_fet['title']; ?></td>
                                            <td><?php echo $information_fet['remark_details']; ?></td>
                                            <td>
                                                <?php
                                                if($information_fet['remark_filepath'])
                                                {
                                                    ?>
                                                    <a href="<?php echo $information_fet['remark_filepath']; ?>" target="_blank"> <i class="fa fa-microphone"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </form>
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

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            $('.styled').uniform();
        });
        $(function() {

            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs: [
                    {
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets:[1,2]
                    },
                    {
                        width: '25%',
                        targets: 3
                    },
                    {
                        width: '20%',
                        targets: 4,
                        orderable: false
                    }
                ],
                order: [[ 0, 'asc' ]],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                displayLength: 10
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
</script>

<script>
    $(function() {
        $('#addRemarksBtn').click(function() {
            $('#addRemarks').toggle();
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $('#studentId').change(function() {
            var studId =  $('#studentId').val();
            $.get('ajax-student-name.php', {studid: studId}, function(result){
                $("#studentName").val(result.trim());
            });
        });
    });

    function show_confirm() {
        //var remark_details_Message =null;
        var title_Message =  'Title::'+$('#title').val();
        var studentName_Message =  'Student Name::'+$('#studentName').val().trim();
        if($('#remark_details').val()){
            var remark_details_Message =  'Remarks::'+$('#remark_details').val();
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message+'\n'+remark_details_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else{
            if(confirm('Do you want to add the Remarks?'+'\n'+studentName_Message+'\n'+title_Message))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
</script>

<script>
    $(function() {
        $('.remarksType').change(function() {
            var rType = $('input[name="remarksType"]:checked').val();
            if(rType == 'Text'){
                $('#remarksAudio').hide();
                $('#remarksText').show();
            }
            else if(rType == 'Audio'){
                $('#remarksText').hide();
                $('#remarksAudio').show();
            }
        });
    });
</script>

</body>
</html>