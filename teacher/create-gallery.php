<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];

$classHandling = $teacher_fet['class_handling'];
$clsteacherhandling = explode(",", $classHandling);
$clsteacherhandling_array=array_map('trim',$clsteacherhandling);
//print_r($clsteacherhandling_array);

$subjectHandling = $teacher_fet['subject'];
$sbjteacherhandling = explode(",", $subjectHandling);
$sbjteacherhandling_array=array_map('trim',$sbjteacherhandling);

$class_existing_sql="SELECT DISTINCT c.class_name, c.id FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1 order by c.id ASC";
$class_existing_exe=mysql_query($class_existing_sql);
$class_existing_results = array();
while($row = mysql_fetch_assoc($class_existing_exe)) {
    array_push($class_existing_results, $row);
}

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
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
                        <h4><i class="fa fa-th-large position-left"></i> GALLERY</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li class="active">Create Gallery</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">

                            <div class="box-body" id="predate">
                                <form class="form-horizontal" action="docreategallery.php" method="post" enctype="multipart/form-data">
                                    <div class="row" style="margin-left: 20px;">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Class</label>
                                                <div class="col-lg-8">
                                                    <input type="hidden" name="className" value="<?php echo $classId; ?>">
                                                    <input type="text" class="form-control" name="classId" value="<?php echo $className; ?>">
                                                    <?php /* ?>
                                                    <select class="form-control" name="className" id="className" required>
                                                        <option value="">Select Class</option>
                                                        <?php
                                                        foreach($class_existing_results as $key => $value){ ?>
                                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php */ ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Title</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="galleryTitle">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Description</label>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" name="galleryDesc"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Attachment</label>
                                            </div>

                                            <div class="form-group gallery-row">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <input type="hidden" class="form-control" name="galleryId[0]">
                                                        <input type="file" class="form-control galAttachment" name="gallery0" accept="video/*,image/*,audio/*" required>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-info add-gallery" title="Add More">+</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                $(function(){
                                                    var counter = 1;
                                                    $('.add-gallery').click(function(event){
                                                        event.preventDefault();

                                                        var newRow = $('<div class="row"> <div class="col-lg-8"> <input type="hidden" class="form-control" name="galleryId['+
                                                        counter + ']"><input type="file" class="form-control galAttachment" accept="video/*,image/*,audio/*" name="gallery' +
                                                        counter + '"> </div> </div>');
                                                        counter++;
                                                        $('.gallery-row').append(newRow);

                                                    });
                                                });
                                            </script>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-2">
                                                        <input type="submit" value="ADD" class="btn btn-info form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div>
                        <!-- /basic datatable -->

                    </div>
                </div>

                <!-- Footer -->
                <?php include "footer.php"; ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>