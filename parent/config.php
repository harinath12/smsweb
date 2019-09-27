<?php //error_reporting(0);

/*$hostname		=	"localhost";
$username		=	"srivina3_admin";
$password	    =	"sms_school";
$database		=	"srivina3_sms_school";

	$connection	=	mysql_connect($hostname,$username,$password) or die("not Server not connected");
	$database	=	mysql_select_db($database) or die("Data base not connected");

mysql_set_charset('utf8',$link);
mysql_query('set names utf8');
date_default_timezone_set('Asia/Kolkata');*/


$hostname		=	"localhost";
$username		=	"root";
$password	    =	"";
$database		=	"sms";

$conn = mysqli_connect($hostname, $username, $password, $database);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
$GLOBALS['conn'] = $conn;

function mysql_query($query) {
    $conn = $GLOBALS['conn'];
    return mysqli_query($conn, $query);
}

function mysql_num_rows($exec) {
    return mysqli_num_rows($exec);
}

function mysql_fetch_array($exec) {
    return mysqli_fetch_array($exec);
}

function mysql_fetch_assoc($exec) {
    return mysqli_fetch_assoc($exec);
}

function mysql_insert_id() {
    $conn = $GLOBALS['conn'];
    return mysqli_insert_id($conn);
}



function date_display($date,$time='no')
{
	if(!empty($date))
	{
	$strtotime = strtotime($date);
	
	$date_only = date("d/m/Y", strtotime($date));
	$time_only = "";
	
	if($time=='yes')
	{
	$time_only =  date("H:i a", strtotime($date));
	}
	
	$date_display = $date_only." ".$time_only;
	}
	else
	{
	$date_display = "";	
	}	
	
	return $date_display;	
}


?>
                            
						