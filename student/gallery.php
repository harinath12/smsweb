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


$circu_sql="SELECT gal.*, c.class_name FROM `gallery` as gal
LEFT JOIN classes as c on c.id = gal.class
where gallery_status=1 and admin_status=1 and (gal.class = '$classId' or gal.class='100') GROUP BY gal.gallery_title order by gallery_date DESC";
$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                        <h4><i class="fa fa-th-large position-left"></i> Gallery</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Gallery</li>
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
                                <h3 class="box-title" style="line-height:30px;">Gallery</h3>
                            </div><!-- /.box-header -->

                            <div class="box-body" id="predate">
                                <?php
                                if($circu_cnt>0)
                                {
                                    ?>
                                    <div class="row">
                                        <?php
                                        while($circu_fet=mysql_fetch_assoc($circu_exe))
                                        {
                                            ?>
                                            <div class="col-md-3 col-lg-3">
                                                <p>
                                                    <?php //echo $circu_fet['gallery_date']; ?>
													<?php echo date_display($circu_fet['gallery_date']); ?>
                                                </p>
                                                <?php
                                                $video_ext = array('mp4','ogg','wmv','wma','flv','avi','m4a','m4v','f4v','f4a','m4b', 'm4r', 'mov', 'vob', 'mkv', 'webm', 'mpg', 'mpeg');
                                                $filePath = $circu_fet['gallery_file_path'];

                                                if((strpos($filePath, 'mp4')) || (strpos($filePath, 'wmv'))||(strpos($filePath, 'mpeg'))||(strpos($filePath, 'mpg'))||(strpos($filePath, 'flv'))||(strpos($filePath, 'avi'))||(strpos($filePath, 'webm'))){
                                                    ?>
                                                    <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                                        <video src="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" controls>
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </a>
                                                <?php
                                                }
                                                elseif(strpos($filePath, 'mp3')){
                                                    ?>
                                                    <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                                        <audio controls class="form-control" style="height: 200px;">
                                                            <source src="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </a>
                                                <?php
                                                }
                                                else{
                                                    ?>
                                                    <a href="gallery-group.php?title=<?php echo $circu_fet['gallery_title']; ?>">
                                                        <img src="<?php echo '../admin/' . $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" alt="<?php echo $circu_fet['gallery_title']; ?>" title="<?php echo $circu_fet['gallery_title']; ?>"/>
                                                    </a>

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

                                                </br>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> Records are being updated. </b></p>
                                <?php
                                }
                                ?>
                            </div><!-- /.box-body -->
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

</body>
</html>