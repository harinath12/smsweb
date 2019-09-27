<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

if(isset($_REQUEST['title']))
{
    $galTitle = $_REQUEST['title'];
}
else{
    exit;
}

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$circu_sql="SELECT gal.*, c.class_name FROM `gallery` AS gal
LEFT JOIN classes AS c ON c.id = gal.class
WHERE gallery_status=1 and (gal.class = '$classId' or gal.class='100') and gallery_title='$galTitle' ORDER BY gal.id DESC";

$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>

    <link href="../admin/css/photo-gallery.css" rel="stylesheet" type="text/css">
    <script>
        $(document).ready(function(){
            $('ul.first').bsPhotoGallery({
                "classes" : "col-xl-3 col-lg-2 col-md-4 col-sm-4",
                "hasModal" : true,
                "shortText" : false
            });
        });
    </script>

    <?php include "head-inner.php"; ?>
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
                        <li><a href="gallery.php">Gallery List</a></li>
                        <li class="active">Gallery</li>
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
                            <div class="panel-heading">
                                <h4 class="panel-title">Gallery</h4>
                            </div>

                            <div class="box-body">
                                <ul class="row first">
                                    <?php
                                    if($circu_cnt>0)
                                    {
                                        ?>
                                        <?php
                                        $i = 0;
                                        while($circu_fet=mysql_fetch_assoc($circu_exe))
                                        {
                                            ?>
                                            <li class="col-md-3" style="width: 300px;">
                                                <p>
                                                    <?php //echo $circu_fet['gallery_date']; ?><?php echo date_display($circu_fet['gallery_date']); ?>
                                                </p>
                                                <?php
                                                $filePath = $circu_fet['gallery_file_path'];

                                                if((strpos($filePath, 'mp4')) || (strpos($filePath, 'wmv'))||(strpos($filePath, 'mpeg'))||(strpos($filePath, 'mpg'))||(strpos($filePath, 'flv'))||(strpos($filePath, 'avi'))||(strpos($filePath, 'webm'))){
                                                    ?>
                                                    <a href="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" download>
                                                        <video src="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" controls>
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php
                                                }
                                                elseif(strpos($filePath, 'mp3')){
                                                    ?>
                                                    <a href="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" download>
                                                        <audio controls class="form-control" style="height: 200px;">
                                                            <source src="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </a>
                                                <?php
                                                }
                                                else{
                                                    ?>
                                                    <img src="<?php echo '../admin/' .$circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" alt="<?php echo $circu_fet['gallery_title']; ?>" title="<?php echo $circu_fet['gallery_title']; ?>"/>

                                                <?php
                                                }
                                                ?>
                                                <p>
                                                    <?php
                                                    if($circu_fet['class'] == '100'){
                                                        echo "All -" .  $circu_fet['gallery_title'] . "-" . $circu_fet['description'];
                                                    }
                                                    else{
                                                        echo $circu_fet['class_name'] . "-" .  $circu_fet['gallery_title'] . "-" . $circu_fet['description'];
                                                    }
                                                    ?>
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" download class="gal-action">
                                                            <button class="btn btn-info form-control"><i class="fa fa-download"></i> Download </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <p><b> Records are being updated. </b></p>
                                    <?php
                                    }
                                    ?>

                                </ul>
                            </div>
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

<script src="../admin/js/photo-gallery.js"></script>
</body>
</html>