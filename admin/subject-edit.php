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

if(isset($_REQUEST['class_id']))
{
    $classId=$_REQUEST['class_id'];
}
else
{
    exit;
}

$class_sql="select * from class_subject where class_id= '$classId' and class_subject_status='1'";
$class_exe=mysql_query($class_sql);

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
        <section class="content-header">
            <h1>
                Edit Subject
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="subjects.php">Subjects</a></li>
                <li class="active">Edit Subject</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-9">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <form role="form" action="doupdatesubject.php" method="post">
                            <div class="box-body">

                                <div class="col-md-12">
                                    <style>.control-label{line-height:32px;} .form-group{line-height:32px;}</style>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Class Name<span class="req"> *</span></label>
                                        <div class="col-sm-9">
                                            <?php $cls_fet = mysql_fetch_array(mysql_query("select class_name from classes where id='$classId'")); ?>
                                            <input class="form-control" type="text" name="subjectName" id="subjectName" value="<?php echo $cls_fet['class_name']; ?>" readonly/>
                                        </div>
                                    </div>

                                    <?php
                                    $i = 0;
                                    while($class_fet=mysql_fetch_array($class_exe)){
                                        ?>
                                        <div class="form-group col-md-12">
                                            <?php if($i == 0){
                                               ?>
                                                <label class="col-sm-3 control-label">Subject <span class="req"> *</span></label>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <label class="col-sm-3 control-label"></label>
                                            <?php
                                            }?>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="subjectName[]" value="<?php echo $class_fet['subject_name']; ?>" required/>
                                                <input class="form-control" type="hidden" name="subjectid[]" value="<?php echo $class_fet['id']; ?>" required/>
                                            </div>
                                        </div>
                                    <?php
                                        $i++;
                                    } ?>


                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat save-class">Save Changes</button>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

</body>
</html>
