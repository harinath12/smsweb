<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$expenseId = $_REQUEST['expenseId'];
$expenses_details = $_REQUEST['expenses_details'];
$amount = $_REQUEST['amount'];
$amount_paid = $_REQUEST['amount_paid'];
$expense_date = $_REQUEST['expense_date'];
$username = $_SESSION['adminusername'];
$date = date("Y-m-d");

$target = null;
if(isset($_FILES['bill'])){
    if($_FILES['bill']['name'] != null)
    {
        $info = pathinfo($_FILES['bill']['name']);
        $base = basename($_FILES['bill']['name']);
        if(!empty($base)) {
            $ext = $info['extension'];
            $newname = "bill-" . time() . "." . $ext;
            $target = 'upload/expensebill/' . $newname;
            $moveFile = move_uploaded_file($_FILES['bill']['tmp_name'], $target);
        }
        $vehicle_bill_sql = "UPDATE expenses set bill = '$target' where id='$expenseId'";
        $vehicle_bill_exe = mysql_query($vehicle_bill_sql);
    }
}

$vehicle_sql = "UPDATE expenses set expenses_details = '$expenses_details', amount = '$amount', amount_paid = '$amount_paid', expense_date = '$expense_date', updated_by = '$date' where id='$expenseId'";
$vehicle_exe = mysql_query($vehicle_sql);

if($vehicle_exe){
    header("Location: expenses-view.php?id=$expenseId&suc=1");
}
else{
    header("Location: expenses-edit.php?err=1");
}

?>