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

if(isset($_REQUEST['chapter_id']))
{
    $chapter_id=$_REQUEST['chapter_id'];
}
else
{
    exit;
}

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$chapter_sql="SELECT cm.*, c.class_name FROM `chapter_master` as cm
LEFT JOIN classes as c on c.id = cm.class_id
where cm.id = '$chapter_id'";
$chapter_exe=mysql_query($chapter_sql);
$chapter_fet=mysql_fetch_array($chapter_exe);
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
                Edit Chapter
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="chapters.php"> Chapters</a></li>
                <li class="active">Edit Chapter</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-9">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Chapter Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="doeditchapter.php" method="post">
                            <div class="box-body">

                                <div class="col-md-12">
                                    <style>.control-label{line-height:32px;} .form-group{line-height:32px;}</style>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Class Name<span class="req"> *</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="className" id="className" required>
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($chapter_fet['class_id'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div id="errClassName" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Term</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="term" id="term">
                                                <option value="">Select term</option>
                                                <option value="Term 1" <?php if($chapter_fet['term'] == 'Term 1'){ echo 'selected'; } ?>>Term 1</option>
                                                <option value="Term 2" <?php if($chapter_fet['term'] == 'Term 2'){ echo 'selected'; } ?>>Term 2</option>
                                                <option value="Term 3" <?php if($chapter_fet['term'] == 'Term 3'){ echo 'selected'; } ?>>Term 3</option>
                                            </select>
                                            <div id="errTerm" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Subject</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?php echo $chapter_fet['subject']; ?>" class="form-control" name="subject" id="subject"/>
                                            <div id="errSubject" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Lesson</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?php echo $chapter_fet['lesson']; ?>" class="form-control" name="lesson" id="lesson"/>
                                            <div id="errLesson" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Chapter</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?php echo $chapter_fet['chapter']; ?>" class="form-control" name="chapter" id="chapter"/>
                                            <div id="errChapter" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-sm-4"> </div>
                                        <div class="col-sm-4">
                                            <input type="hidden" value="<?php echo $chapter_fet['id']; ?>" class="form-control" name="chapter_id" id="chapter"/>
                                            <button type="submit" class="btn btn-primary btn-block btn-flat save-chapter">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

                <!-- right column -->
                <div class="col-md-3">
                    <!-- Horizontal Form -->
                    <div class="box box-danger" >
                        <div class="box-header with-border">
                            <h3 class="box-title">Chapter</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group col-md-12">
                                <a href="chapters.php"><button type="submit" class="btn btn-warning col-md-12" style="margin-bottom:10px;" >Back to Chapter List</button></a>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".save-class").click(function(){
            $("div#errClassName").html( " " );
            $("div#errSectionName").html( " " );
            $("div#errClassStatus").html( " " );
            var className = $('#className').val();
            if(!className){
                $("div#errClassName").html( "This field is required" );
                return false;
            }
            var sectionName = $('#sectionName').val();
            if(!sectionName){
                $("div#errSectionName").html( "This field is required" );
                return false;
            }
            var status = $('#status').val();
            if(status == 2){
                $("div#errClassStatus").html( "This field is required" );
                return false;
            }
        });
    });
</script>
</body>
</html>
