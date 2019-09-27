<?php
session_start();
ob_start();

include "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$event_fet = mysql_fetch_array(mysql_query("select * from calendar where id='$id'"));
?>

<form action="doupdateevent.php" method="post" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
    <h4 class="panel-title" style="margin: 0 0 20px 20px;">
        <b>Edit Events</b>
    </h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-lg-4">Title <span class="req">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="event_title" id="title" value="<?php echo $event_fet['calendar_title'];?>" required/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Event From Date <span class="req">*</span></label>
                <div class="col-lg-8">
                    <div class='input-group date'>
                        <input type='text' class="form-control datepicker" name="fromdate" value="<?php echo $event_fet['calendar_start_date'];?>" required/>
                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-4">Event To Date</label>
                <div class="col-lg-8">
                    <div class='input-group date'>
                        <input type='text' class="form-control datepicker" name="todate" value="<?php echo $event_fet['calendar_end_date'];?>"/>
                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-lg-2">
                    <input type="hidden" class="form-control" name="event_id" value="<?php echo $event_fet['id'];?>"/>
                    <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                </div>
            </div>
        </div>
    </div>
</form>
