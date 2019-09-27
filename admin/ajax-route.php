<?php session_start();
ob_start();

include "config.php";

if (isset($_REQUEST['ord'])){
    $ord = $_REQUEST['ord'];
	
	for($i=1;$i<count($ord);$i++)
	{
	$id = $ord[$i];	
	$stop_order_sql="UPDATE `route_stop` SET `route_order`='$i' WHERE id='$id'";
	$stop_exe=mysql_query($stop_order_sql);
		
		/*
		//Something to write to txt log
		$log  = "ORDER: ".$i.'  '.PHP_EOL.
				"ID: ".$ord[$i].' '.PHP_EOL.
				"-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		file_put_contents('log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
		*/
		
	}
	
} 

?>
