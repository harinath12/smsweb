<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id']))
{
    $galId = $_REQUEST['id'];
}
else{
    exit;
}

$vehicle_sql = "UPDATE gallery set gallery_status = '0' where id='$galId'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    if(isset($_REQUEST['gal']))
    {
        header("Location: gallery-edit.php?id=$galId");
    }
    else{
        header("Location: gallery.php?succ=2");
    }
}
else{
    header("Location: gallery.php?err=1");
}

?>