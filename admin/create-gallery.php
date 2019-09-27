<?php session_start();
ob_start();
include "config.php";

$user_id=$_SESSION['adminuserid'];

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$class_existing_sql="SELECT DISTINCT c.class_name, c.id FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1 order by c.id ASC";
$class_existing_exe=mysql_query($class_existing_sql);
$class_existing_results = array();
while($row = mysql_fetch_assoc($class_existing_exe)) {
    array_push($class_existing_results, $row);
}

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <title>Admin Panel</title>
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
                Create Gallery
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="gallery.php">Gallery List</a></li>
                <li class="active">Create Gallery</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content area -->
            <div class="content">
                <form class="form-horizontal" action="docreategallery.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Gallery Details
                                </h4>
                            </div>
                            <div class="panel-body no-padding-bottom">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="className" id="className" required>
                                                <option value="">Select Class</option>
                                                <option value="100">All</option>
                                                <?php
                                                foreach($class_existing_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
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
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <input type="submit" value="ADD" class="btn btn-info form-control"/>
                        </div>
                    </div>
                </form>
                <!-- /form horizontal -->
            </div>
            <!-- /content area -->
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
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<!-- page script -->
</body>
</html>