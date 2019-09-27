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

$stop_sql="SELECT * FROM `stopping_master` where stopping_status='1'";
$stop_exe=mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <style>.control-label{line-height:32px;}  .form-group{line-height:32px;}</style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Route
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="routes-list.php"> Routes List</a></li>
                <li class="active">Add Routes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Routes Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="docreateroute.php" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Route No.<span class="req"> *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="route_no" id="route_no" required />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Num of Stopping</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="num_of_stopping" id="num_of_stopping" min="0"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Starting Point</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="pickup_start">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Ending Point</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="pickup_end">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Dropping Starting Point</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="drop_start">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Dropping Ending Point</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="drop_end">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 addRouteRow" id="addRouteRow">
                                        <h4>Bus Stops</h4>
                                        <div class="row" style="margin-bottom: 10px;" id="addStops">
                                            <div class="col-lg-4">
                                                <select class="form-control" name="stop_name[]">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>"><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="number" step="0.01" name="distance[]" class="form-control" id="distance" placeholder="Distance in km" min="0" />
                                            </div>
                                            <div class="col-lg-1">
                                                <input type="number" step="1" name="order[]" class="form-control" id="order" placeholder="Order" min="0" />
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="button" class="btn btn-info add-stop" title="Add More">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-5"></div>
                                    <div class="form-group col-md-2">
                                        <button type="submit" class="btn btn-info add-route">Save Changes</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

<script>
    $(function(){
        var counter = 1;
        $('.add-stop').click(function(){
            var input1 = $("#distance").val();
            $.get('ajaxstoplist.php', function(result){
                var list = "<option value=''>Select Stop</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.stopname + "'>" + item.stopname + "</option>";
                });
                var newRow = $('<div class="row" style="margin-bottom: 10px;" id="addStops'+counter+'"> ' +
                '<div class="col-lg-4"> ' +
                '<select name="stop_name[]" class="form-control">'+
                list +
                '</select>'+
                '</div>' +
                '<div class="col-lg-2"> <input type="number" step="0.01" class="form-control" placeholder="Distance in km" name="distance[]" value="'+input1+'" min="0" /> </div> ' +
                '<div class="col-lg-1"> <input type="number" step="1" class="form-control" placeholder="Order" name="order[]" value="'+input1+'" min="0" /> </div> ' +
                '<div class="col-lg-1">'+
                '<i class="btn btn-danger removeStop" id="removeStop'+counter+'" data-id="'+counter+'"><span class="fa fa-trash"> </span></i>'+
                '</div>'+
                '</div>');
                counter++;
                $('.addRouteRow').append(newRow);
            });
        });
        $(document).on('click', '.removeStop' , function(){
            $('#addStops'+$(this).data('id')).remove();
            counter--;
        });
    });
</script>

</body>
</html>
