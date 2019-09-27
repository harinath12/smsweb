<?php session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");

if(isset($_REQUEST['title']))
{
    $galTitle = $_REQUEST['title'];
}
else{
    exit;
}

$circu_sql="SELECT gal.*, c.class_name FROM `gallery` AS gal
LEFT JOIN classes AS c ON c.id = gal.class
WHERE gallery_status=1 and gallery_title='$galTitle' ORDER BY gal.id DESC";

$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Panel</title>
    <link href="css/photo-gallery.css" rel="stylesheet" type="text/css">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>

    <script>
        $(document).ready(function(){
            $('ul.first').bsPhotoGallery({
                "classes" : "col-xl-3 col-lg-2 col-md-4 col-sm-4",
                "hasModal" : true,
                "shortText" : false
            });
        });
    </script>

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
                Gallery
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="gallery.php">Gallery List</a></li>
                <li class="active">Gallery</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px; background:#ebebeb;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Gallery</h3>
                        </div><!-- /.box-header -->
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
                                                <?php //echo $circu_fet['gallery_date']; ?>
												<?php echo date_display($circu_fet['gallery_date']);?>
                                            </p>
                                            <?php
                                            $filePath = $circu_fet['gallery_file_path'];

                                            if((strpos($filePath, 'mp4')) || (strpos($filePath, 'wmv'))||(strpos($filePath, 'mpeg'))||(strpos($filePath, 'mpg'))||(strpos($filePath, 'flv'))||(strpos($filePath, 'avi'))||(strpos($filePath, 'webm'))){
                                                ?>
                                            <a href="<?php echo $circu_fet['gallery_file_path'];?>" download>
                                                <video src="<?php echo $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" controls>
                                                    Your browser does not support the video tag.
                                                </video>
                                            </a>
                                            <?php
                                            }
                                            elseif(strpos($filePath, 'mp3')){
                                                ?>
                                            <a href="<?php echo $circu_fet['gallery_file_path'];?>" download>
                                                <audio controls class="form-control" style="height: 200px;">
                                                    <source src="<?php echo $circu_fet['gallery_file_path'];?>">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </a>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <img src="<?php echo $circu_fet['gallery_file_path'];?>" class="form-control" style="height: 200px;" alt="<?php echo $circu_fet['gallery_title']; ?>" title="<?php echo $circu_fet['gallery_title']; ?>"/>

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
                                                    <a href="<?php echo $circu_fet['gallery_file_path'];?>" download class="gal-action">
                                                        <button class="btn btn-info form-control"><i class="fa fa-download"></i> Download </button>
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="gallery-delete.php?id=<?php echo $circu_fet['id'];?>" class="gal-del" onclick="return confirm('Do you want to delete?');">
                                                        <button class="btn btn-info form-control">Delete</button>
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
                </div>
            </div>
        </section>
    </div>

</div>

<script>

</script>

<script src="js/photo-gallery.js"></script>


</body>

