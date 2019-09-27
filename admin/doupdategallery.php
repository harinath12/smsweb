<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$className = $_REQUEST['className'];
$galleryTitle = $_REQUEST['galleryTitle'];
$galleryDesc = $_REQUEST['galleryDesc'];
$galleryId = $_REQUEST['galleryId'];

$cnt = count($_REQUEST["galleryId"]);
//echo $cnt; exit;
for ($i = 0; $i < $cnt; $i++) {
    if (isset($_FILES['gallery'.$i])) {
        $info = pathinfo($_FILES['gallery' . $i]['name']);
        $base = basename($_FILES['gallery' . $i]['name']);
        if (!empty($base)) {
            $ext = $info['extension'];
            $newname = "gallery-" . round(microtime(true) * 1000) . "." . $ext;
            $target = 'upload/gallery/' . $newname;
            $moveFile = move_uploaded_file($_FILES['gallery'.$i]['tmp_name'], $target);
        }

        $gallery_sql = "INSERT INTO `gallery` (class, gallery_title, description, gallery_file_path, gallery_date, gallery_status, created_by, created_at) VALUES
('$className', '$galleryTitle', '$galleryDesc', '$target', '$date','1','$username', '$date')";
        $gallery_exe = mysql_query($gallery_sql);
    }
}

$gal_sql="SELECT gal.* FROM `gallery` as gal where gal.id = '$galleryId'";
$gal_exe = mysql_query($gal_sql);
$gal_fet = mysql_fetch_array($gal_exe);
$title = $gal_fet['gallery_title'];
$galclass = $gal_fet['class'];

$photo_sql = mysql_query("select * from gallery where gallery_title='$title' and class='$galclass' and gallery_status='1'");
$cnt = mysql_num_rows($photo_sql);

if($cnt>0){
    while($photo_fet = mysql_fetch_array($photo_sql)){
        $gid = $photo_fet['id'];
        $update_gal = mysql_query("UPDATE gallery set class='$className', gallery_title='$galleryTitle', description='$galleryDesc' where id='$gid'");
    }
}




header("Location: gallery.php?succ=1");

?>