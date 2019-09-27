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

$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}

$exam_sql="SELECT ett.* FROM exam_time_table AS ett
 LEFT JOIN exam_date_subject AS eds ON eds.exam_id = ett.id
 WHERE exam_status=1 GROUP BY exam_name";
$exam_exe=mysql_query($exam_sql);
$exam_results = array();
while($row = mysql_fetch_assoc($exam_exe)) {
    array_push($exam_results, $row);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
    <style>
        .req{
            color: red;
        }
    </style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Result
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Result</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body" id="predate">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Exam Name <span class="req"> *</span> </label>
                                            <div class="col-lg-8">
                                                <select class="form-control examName" name="examName" id="examId" required>
                                                    <option value="">Select Exam</option>
                                                    <?php
                                                    foreach($exam_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['exam_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <a href="compare-class-result.php">
                                            <button class="btn btn-info form-control">Compare Classes</button>
                                        </a>
                                    </div>
                                        <?php /* ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Compare Classes</label>
                                            <div class="col-lg-8">
                                                <select class="form-control className" name="className" id="classId" multiple style="height: 100px;">
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_master_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" class="form-control" name="clsName" id="clsName" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php */ ?>


                                <div id="studentlist">

                                </div>

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

<script>
    $(function() {
        $('.examName').change(function() {
            var examid = $('.examName').val();
            $.ajax({
                url: "ajaxclasslistforresult.php?examid=" + examid,
                context: document.body
            }).done(function(response) {
                $('#studentlist').html(response);
            });
        });
    });
</script>
<!-- page script -->

</body>
</html>
