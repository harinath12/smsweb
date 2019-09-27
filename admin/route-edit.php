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

if(isset($_REQUEST['id']))
{
    $routeId = $_REQUEST['id'];
}
else{
    exit;
}

$stop_sql="SELECT * FROM `stopping_master` where stopping_status='1'";
$stop_exe=mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}

$route_sql="SELECT * FROM `routes` where id='$routeId'";
$route_exe=mysql_query($route_sql);
$route_fet=mysql_fetch_array($route_exe);

$route_stop_sql="SELECT * FROM `route_stop` where route_id='$routeId' ORDER BY route_order ASC";
$route_stop_exe=mysql_query($route_stop_sql);
$route_stop_cnt=mysql_num_rows($route_stop_exe);
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                Edit Route
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="routes-list.php"> Routes List</a></li>
                <li class="active">Edit Route</li>
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
                            <h3 class="box-title">Edit Route Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="doeditroute.php" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Route No.<span class="req"> *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="route_no" id="route_no" value="<?php echo $route_fet['route_no'];?>" required />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Num of Stopping</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="num_of_stopping" id="num_of_stopping" value="<?php echo $route_fet['num_of_stopping'];?>" min="0"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-sm-5 control-label">Pickup Starting Point</label>
                                            <div class="col-sm-7">
                                                <select class="form-control" name="pickup_start">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>" <?php if($value['stopping_name'] == $route_fet['pickup_starting_point']){echo 'selected';} ?>><?php echo $value['stopping_name']; ?></option>
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
                                                        <option value="<?php echo $value['stopping_name']; ?>" <?php if($value['stopping_name'] == $route_fet['pickup_ending_point']){echo 'selected';} ?>><?php echo $value['stopping_name']; ?></option>
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
                                                        <option value="<?php echo $value['stopping_name']; ?>" <?php if($value['stopping_name'] == $route_fet['dropping_starting_point']){echo 'selected';} ?>><?php echo $value['stopping_name']; ?></option>
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
                                                        <option value="<?php echo $value['stopping_name']; ?>" <?php if($value['stopping_name'] == $route_fet['dropping_ending_point']){echo 'selected';} ?>><?php echo $value['stopping_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if($route_stop_cnt > 0){
                                ?>
                                <div class="row">
                                    <div class="form-group col-md-12 addRouteRow" id="addRouteRow">
                                    <h4>Bus Stops</h4>
                                            <?php
                                            $add = 1;
                                    while($route_stop_fet = mysql_fetch_assoc($route_stop_exe)){
                                    ?>
                                        <div class="row" style="margin-bottom: 10px;" id="addStops">
                                            <div class="col-lg-4">
                                                <select class="form-control" name="stop_name[]">
                                                    <option value="">Select Stop</option>
                                                    <?php
                                                    foreach($stop_results as $key => $value){
                                                        ?>
                                                        <option value="<?php echo $value['stopping_name']; ?>" <?php if(trim($value['stopping_name']) == $route_stop_fet['stop_name']){echo 'selected'; }?>> <?php echo $value['stopping_name']; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="number" step="0.01" name="distance[]" class="form-control" id="distance" value="<?php echo $route_stop_fet['distance']; ?>" placeholder="Distance in km" min="0" />
                                            </div>
                                            <div class="col-lg-1">
                                                <input type="number" step="1" name="order[]" class="form-control" id="order" value="<?php echo $route_stop_fet['route_order']; ?>" placeholder="Order" min="0" />
                                            </div>
                                            <?php if($add == 1){?>
                                            <div class="col-lg-1">
                                                <button type="button" class="btn btn-info add-stop" title="Add More">+</button>
                                            </div>
                                            <?php }?>
                                        </div>
                                    <?php
                                        $add++;
                                    }
                                            ?>
                                    </div>
                                </div>
                                <?php
                                }
                                else{
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-12 addRouteRow" id="addRouteRow">
                                            <h4>Bus Stops</h4>
                                            <div class="row" style="margin-bottom: 10px;" id="addStops">
                                                <div class="col-lg-4">
                                                    <select class="form-control" name="stop_name[]">
                                                        <option value="">Select Stop</option>
                                                        <?php
                                                        foreach($stop_results as $key => $value){
                                                            ?>
                                                            <option value="<?php echo $value['stopping_name']; ?>"> <?php echo $value['stopping_name']; ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="number" step="0.01" name="distance[]" class="form-control" id="distance" placeholder="Distance in km" />
                                                </div>
                                                <div class="col-lg-1">
                                                    <button type="button" class="btn btn-info add-stop" title="Add More">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                                <div class="row">
                                    <div class="form-group col-md-5"></div>
                                    <div class="form-group col-md-2">
                                        <input type="hidden" name="routeId" value="<?php echo $routeId; ?>" />
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                '<div class="col-lg-2"> <input type="number" step="0.01" class="form-control" placeholder="Distance in km" name="distance[]" value="'+input1+'"/> </div> ' +
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
