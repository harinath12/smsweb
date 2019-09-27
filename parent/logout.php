<?php session_start();
ob_start();

include "config.php";

if(isset($_SESSION['adminuserid']))
{
    unset($_SESSION['adminuserid']);
    unset($_SESSION['adminusername']);
    unset($_SESSION['adminuseremail']);
    unset($_SESSION['adminuserrole']);

    header("Location: index.php?success=1");
}
else
{
    header("Location: index.php?success=1");
}
?>