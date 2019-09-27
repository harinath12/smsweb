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

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

/* $section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}


$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
} */
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
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
                <li class="active">Question Paper</li>
            </ol>
        </div>
 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
							
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3" style="float: right">
                                    <a href="question-paper.php"><button type="button" class="form-control btn btn-info">View Question Paper</button></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control className" name="className" id="className" required>
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
                                        <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control term" name="term" id="term" required>
                                                <option value="">Select Term</option>
                                                <option value="Term 1">Term 1</option>
                                                <option value="Term 2">Term 2</option>
                                                <option value="Term 3">Term 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Subject <span class="req"> *</span> </label>
                                        <div class="col-lg-8">
                                            <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                <option value="">Select Subject</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </br>
                            <div id="questionpaperlist">

                            </div>

						</div>
                        <!-- /basic datatable -->

                    </div>
                </div>

                 
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<script>
    $(function() {
        $('#className').change(function() {
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var list = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(list);
            });
        });
    });
</script>

<script>
    $(function() {
        $('.subjectName').change(function() {
            var cid = $('.className').val();
            var sub = $('.subjectName').val();
            var term = $('#term').val();

            $.ajax({
                url: "ajaxcreatequestionpaper.php?sub=" + sub + "&term=" + term + "&cid=" + cid,
                context: document.body
            }).done(function(response) {
                $('#questionpaperlist').html(response);
            });
        });
    });

    $(function() {
        $('#term').change(function() {
            var cid = $('.className').val();
            var sub = $('.subjectName').val();
            var term = $('#term').val();

            $.ajax({
                url: "ajaxcreatequestionpaper.php?sub=" + sub + "&term=" + term + "&cid=" + cid,
                context: document.body
            }).done(function(response) {
                $('#questionpaperlist').html(response);
            });
        });
    });
</script>
</body>
</html>
