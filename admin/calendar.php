<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_cnt=@mysql_num_rows($class_exe);

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Calendar
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Calendar</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
					
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3" style="float: right">
                                <button type="button" class="form-control btn btn-info" id="addEventsBtn">Add Events</button>
                            </div>
                        </div>
                        <div class="row" id="editEvent">

                        </div>

                        <div class="row" id="addEvent" style="display: none;">
                            <div class="panel-body">
                                <form action="doaddevent.php" method="post" style="border: 1px dotted darkgrey; padding:10px; margin:10px 20px;">
                                    <h4 class="panel-title" style="margin: 0 0 20px 20px;">
                                        <b>Add Events</b>
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Type <span class="req">*</span> </label>
                                                <div class="col-lg-8">
													<select class="form-control" name="event_type" id="title" value="" required>
														<option value=''>--Choose--</a>
														<option value='1'>Holiday</a>
														<option value='2'>Information</a>
													</select>
                                                </div>
                                            </div>
											
											<div class="form-group">
                                                <label class="control-label col-lg-4">Title <span class="req">*</span> </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="event_title" id="title" value="" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Event From Date <span class="req">*</span></label>
                                                <div class="col-lg-8">
                                                    <div class='input-group date'>
                                                        <input type='text' class="form-control datepicker" name="fromdate" required/>
                                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Event To Date</label>
                                                <div class="col-lg-8">
                                                    <div class='input-group date'>
                                                        <input type='text' class="form-control datepicker" name="todate"/>
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
                                                    <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
						
							<?php  //include "../fullcalendar/demos/admin-index.php"; ?>
							<iframe src="../fullcalendar/demos/admin-index.php?<?php echo time(); ?>" width="100%" height="800px" border="0" style="border: none;" ></iframe>
							


                        <div class="box-body">
                            <?php
                            if(isset($_REQUEST['succ'])) {
                                if ($_REQUEST['succ'] == 1) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Event Added Successfully</strong>
                                    </div>
                                <?php
                                }
                                else  if ($_REQUEST['succ'] == 2) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Event Deleted Successfully</strong>
                                    </div>
                                <?php
                                }
                                else  if ($_REQUEST['succ'] == 3) {
                                    ?>
                                    <div class="alert alert-success alert-dismessible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Event Updated Successfully</strong>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>TITLE</th>
                                    <th>FROM DATE</th>
                                    <th>TO DATE</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $event_exe = mysql_query("select * from calendar where calendar_status=1");
                                $i =1;
                                while($event_fet=mysql_fetch_array($event_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $event_fet['calendar_title']; ?></td>
                                        <td>
										<?php //echo $event_fet['calendar_start_date'];?>
										<?php echo date_display($event_fet['calendar_start_date']);?>
										</td>
                                        <td>
										<?php //echo $event_fet['calendar_end_date']; ?>
										<?php echo date_display($event_fet['calendar_end_date']);?>
										</td>
                                        <td>
                                            <a href="#"><button type="button" class="btn btn-info btn-xs eventEditBtn" value="<?php echo $event_fet['id'];?>"><i class="fa fa-pencil"></i></button></a>&nbsp;
                                            <a href="calendar-delete.php?id=<?php echo $event_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-trash"></i></button></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        
						</div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( ".datepicker").datepicker({
            dateFormat:'yy-mm-dd'
            //minDate: 'today'
        });
    } );
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs: [
                    {
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets:[1,2,3]
                    },
                    {
                        width: '25%',
                        targets: 4,
                        orderble: false
                    }
                ],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 100
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
</script>

<!-- page script -->

<script>
    $(function() {
        $('#addEventsBtn').click(function() {
            $('#addEvent').toggle();
            $('#editEvent').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.eventEditBtn').click(function() {
            $('#addEvent').hide();
            $('#editEvent').toggle();
            var id = $(this).val();
            $.ajax({
                url: "ajax-edit-calendar-event.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editEvent').html(response);
                $( ".datepicker").datepicker({
                    dateFormat:'yy-mm-dd'
                    //minDate: 'today'
                });
            });
        });
    });
</script>
<!-- page script -->

</body>
</html>
