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

$class_sql="SELECT distinct c.* FROM `class_section` as cs LEFT JOIN classes as c on c.id = cs.class_id where c.class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}
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
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Notes</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box" style="min-height: 600px;">
                    <div class="box-body">
                        <form action="notes-view.php" method="post">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <select class="form-control className" name="className" id="classId" required>
                                            <option value="">Select Class</option>
                                            <?php
                                            foreach($class_results as $key => $value){ ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                            <option value="">Select Subject</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="term" id="term" required>
                                            <option value="">Select Term</option>
                                            <option value="Term 1">Term 1</option>
                                            <option value="Term 2">Term 2</option>
                                            <option value="Term 3">Term 3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <select class="form-control chapterName" name="chapter" id="chapter" required>
                                            <option value="">Select Chapter</option>
                                        </select>
                                        <!-- <input type="text" class="form-control" name="chapter" value="" required/> -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Question Type <span class="req"> *</span></label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="questionType" id="questionType" required>
                                            <option value="">Select Question Type</option>
                                            <option value="1">Only Questions</option>
                                            <option value="2">Question & Answer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <input type="submit" value="OK" class="btn btn-info form-control"/>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
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
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({

        });
    } );
</script>
<script>
    $(function() {
        $('#classId').change(function() {
            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var sublist = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(sublist);
            });
        });
    });
</script>

<script>
    $(function() {
        $('#term').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#subjectId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#classId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });
    });
</script>

</body>
</html>
