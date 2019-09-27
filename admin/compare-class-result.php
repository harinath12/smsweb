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
                <li><a href="result.php"> Result</a></li>
                <li class="active">Compare Class</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body" id="predate">
                            <form action="compare-class.php" method="post">
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
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2">Select Classes </label>
                                            <div class="col-lg-10">
                                                <?php
                                                foreach($class_master_results as $key => $value)
                                                {
                                                    $className = $value['class_name'];
                                                    $classId = $value['id'];

                                                    $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
                                                    $section_exe=mysql_query($section_sql);
                                                    $section_results = array();
                                                    while($row = mysql_fetch_assoc($section_exe))
                                                    {
                                                        array_push($section_results, $row);
                                                    }

                                                    foreach ($section_results as $sec_key => $sec_value)
                                                    {
                                                        $sectionName = $sec_value['section_name'];
                                                        $classSectionId = $sec_value['id'];
                                                        ?>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" class="comparecls" name="comparecls[]" value="<?php echo $classSectionId; ?>"> <?php echo $className . " " . $sectionName; ?>
                                                        </div>

                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info form-control">Compare</button>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div>
                            </form>
                            <!-- /.box-body -->

                        </div><!-- /.box -->


                    </div><!-- /.col -->
                </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<script>
    $(document).ready(function () {
        $('input.comparecls').on('change', function(evt) {
            var cnt = $("input[type=checkbox]:checked").length;
            if(cnt > 2) {
                alert("Maximum 2 is allowed");
                this.checked = false;
            }
        });
    });
</script>

</body>
</html>
