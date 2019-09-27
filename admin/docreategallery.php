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

$cnt = count($_REQUEST["galleryId"]);
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

        $gallery_sql = "INSERT INTO `gallery` (class, gallery_title, description, gallery_file_path, gallery_date, gallery_status, admin_status, created_by, created_at) VALUES
('$className', '$galleryTitle', '$galleryDesc', '$target', '$date','1', 1, '$username', '$date')";
        $gallery_exe = mysql_query($gallery_sql);
    }
}

header("Location: gallery.php?succ=1");

?>