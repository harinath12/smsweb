<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

if(isset($_REQUEST['id']))
{
    $expenseId = $_REQUEST['id'];
}
else{
    exit;
}

$vehicle_sql = "UPDATE expenses set expense_status = '0' where id='$expenseId'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    header("Location: expenses-list.php?suc=2");
}
else{
    header("Location: expenses-list.php?err=1");
}

?>