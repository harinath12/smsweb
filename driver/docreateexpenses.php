<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$expenses_details = $_REQUEST['expenses_details'];
$amount = $_REQUEST['amount'];
$amount_paid = $_REQUEST['amount_paid'];
$expense_date = $_REQUEST['expense_date'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;
if(isset($_FILES['bill'])){
    $info = pathinfo($_FILES['bill']['name']);
    $base = basename($_FILES['bill']['name']);
    if(!empty($base)) {
        $ext = $info['extension'];
        $newname = "bill-" . time() . "." . $ext;
        $target = 'upload/expensebill/' . $newname;
        $moveFile = move_uploaded_file($_FILES['bill']['tmp_name'], $target);
    }
}

$expense_sql = "INSERT into expenses (expenses_details, amount, amount_paid, expense_date, bill, expense_status, created_by)
values ('$expenses_details', '$amount', '$amount_paid', '$expense_date', '$target', '1', '$username')";
$expense_exe = mysql_query($expense_sql);
header("Location: expenses-list.php?suc=1");

?>