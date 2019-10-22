<?php error_reporting(0);

$hostname		=	"localhost";
$username		=	"srivina3_admin";
$password	    =	"sms_school";
$database		=	"srivina3_sms_school";
 


$connection	=	mysql_connect($hostname,$username,$password) or die("not Server not connected");
$database	=	mysql_select_db($database) or die("Data base not connected");

mysql_set_charset('utf8',$link);
mysql_query('set names utf8');
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

/*
$hostname		=	"localhost";
$username		=	"akst_adminuser";
$password	    =	"ac5c~N%Jc?98";
$database		=	"akst_sms_school";

	$connection	=	mysql_connect($hostname,$username,$password) or die("not Server not connected");
	$database	=	mysql_select_db($database) or die("Data base not connected");
*/

/*
$hostname		=	"localhost";
$username		=	"root";
$password	    =	"";
$database		=	"sms_school";
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
} */

?>
                            
						

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='../lib/moment.min.js'></script>
<script src='../lib/jquery.min.js'></script>
<script src='../fullcalendar.min.js'></script>
<script>
/*
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      defaultDate: '2019-01-12',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2019-01-01'
        },
        {
          title: 'Long Event',
          start: '2019-01-07',
          end: '2019-01-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2019-01-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2019-01-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2019-01-11',
          end: '2019-01-13'
        },
        {
          title: 'Meeting',
          start: '2019-01-12T10:30:00',
          end: '2019-01-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2019-01-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2019-01-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2019-01-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2019-01-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2019-01-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2019-01-28'
        }
      ]
    });

  });
*/
</script>
<?php
$calendar_list = "";

$calendar_sql = "SELECT * FROM `calendar` WHERE calendar_status=1";
$calendar_exe = mysql_query($calendar_sql);
$calendar_cnt = @mysql_num_rows($calendar_exe);
while($calendar_fetch = mysql_fetch_array($calendar_exe))
{
	$calendar_title = $calendar_fetch['calendar_title'].'-'.$calendar_fetch['calendar_classes'];
	$calendar_classes = $calendar_fetch['calendar_classes'];
	$calendar_type = $calendar_fetch['calendar_type'];
	$calendar_start_date = $calendar_fetch['calendar_start_date'];
	$calendar_end_date = $calendar_fetch['calendar_end_date'];
	
	if($calendar_end_date!="") { 
	$calendar_end_date = date('Y-m-d', strtotime("+1 day", strtotime($calendar_end_date)));
	}
	
	if($calendar_type==1) {
	$calendar_list .= "{";
	$calendar_list .= "title: '$calendar_title',";
    $calendar_list .= "start: '$calendar_start_date',";
	$calendar_list .= "end: '$calendar_end_date',";
	$calendar_list .= "className: ['event', 'greenEvent']";
	$calendar_list .= "},";
	}
	if($calendar_type==2) {
	$calendar_list .= "{";
	$calendar_list .= "title: '$calendar_title',";
    $calendar_list .= "start: '$calendar_start_date',";
	$calendar_list .= "end: '$calendar_end_date',";
	$calendar_list .= "className: ['event', 'blueEvent']";
	$calendar_list .= "},";
	}
	
	
}
$calendar_list .= "{}";
?>
<?php //echo $calendar_list; ?>
<script>
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      defaultDate: '<?php echo date("Y-m-d"); ?>',
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: [
	  <?php echo $calendar_list; ?>,
	  ]
    });

  });
</script>
<style>
.event {
    //shared event css
}

.greenEvent {
    background-color: #06df06;
    /* height: 100px; */ height:auto;
    color: #000;
    font-weight: bold;
    text-align: center;
    padding: 10px;
}

.blueEvent {
    background-color:#00c0ef;
    /* height: 100px; */ height:auto;
    color: #000;
    font-weight: bold;
    text-align: center;
    padding: 10px;
}
</style>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }
  
  .fc-sun { 
color:#337ab7;  
border-color: black;  
background-color: #ffa58c; }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
