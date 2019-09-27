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
$date = date("Y-m-d");

$class_sql="SELECT * FROM classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

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
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="exam-time-table.php">Exam Time Table</a></li>
                <li class="active">Add Exam Time Table</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <form action="doaddexamtimetable.php" method="post" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Exam</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="exam_name" id="title" value=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Class</label>
                                    <div class="col-lg-8">
                                        <select class="form-control className" name="className[]" id="className" multiple>
                                            <option value="">Select Class</option>
                                            <option value="100">All</option>
                                            <?php
                                            foreach($class_results as $key => $value){ ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Start Date</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="datepicker1" name="start_date" value=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">End Date</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="datepicker2" name="end_date" value=""/>
                                    </div>
                                </div>


                                <div id="timetableentry">

                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker1").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
    $( function() {
        $( "#datepicker2").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
</script>

<script>
    $( function() {
        $( "#datepicker2").on( "change", function() {
            var className = $('#className').val();
            var startdate = $('#datepicker1').val();
            var enddate = $('#datepicker2').val();
            //alert("ajax-add-exam-time-table.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className);
            $.ajax({
                url: "ajax-add-exam-time-table.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
                context: document.body
            }).done(function(response) {
                $('#timetableentry').html(response);

            });

        });
    } );


</script>
</body>
</html>
