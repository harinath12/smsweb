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

$fee_id = $_REQUEST['fee_id'];

$fee_sql = "select * from fee_info where id = $fee_id";
$fee_exe = mysql_query($fee_sql);
$fee_fet = mysql_fetch_array($fee_exe);

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color: red;
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
                Fees Edit
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="fees_list.php"> Fees</a></li>
                <li class="active">Fees Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body no-padding-bottom">
                            <div class="col-md-6">
                                <form action="doupdatefees.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Name <span class="req"> *</span> </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="fee_name" value="<?php echo $fee_fet['fee_name']; ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Amount <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="number" min="0" step="0.01" class="form-control" name="fee_amount" value="<?php echo $fee_fet['fee_amount']; ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fee Terms </label>
                                            <div class="col-lg-8">
                                                <input type="hidden" name="f_term" class="f_term" value="<?php echo $fee_fet['fee_terms']; ?>"/>
                                                <select class="form-control fee_terms" name="fee_terms" id="fee_terms">
                                                    <option value="">Select Terms</option>
                                                    <option value="Term 1" <?php if($fee_fet['fee_terms'] == 'Term 1'){ echo 'selected'; } ?>>Term 1</option>
                                                    <option value="Term 2" <?php if($fee_fet['fee_terms'] == 'Term 2'){ echo 'selected'; } ?>>Term 2</option>
                                                    <option value="Term 3" <?php if($fee_fet['fee_terms'] == 'Term 3'){ echo 'selected'; } ?>>Term 3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                            $term1_sql = "select * from fee_terms where fee_id= '$fee_id' and fee_term='Term 1' and fee_term_status=1";
                                            $term1_fet = mysql_fetch_array(mysql_query($term1_sql));
                                        ?>
                                        <div id="term1" style="display: none;">
                                            <label class="control-label col-lg-4">Term 1 </label>
                                            <div class="col-lg-4">
                                                <label>Start Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term1_startdate" class="form-control datepicker" value="<?php echo $term1_fet['fee_term_start_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>End Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term1_enddate" class="form-control datepicker" value="<?php echo $term1_fet['fee_term_end_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $term2_sql = "select * from fee_terms where fee_id= '$fee_id' and fee_term='Term 2' and fee_term_status=1";
                                        $term2_fet = mysql_fetch_array(mysql_query($term2_sql));
                                        ?>
                                        <div id="term2" style="display: none;">
                                            <label class="control-label col-lg-4">Term 2 </label>
                                            <div class="col-lg-4">
                                                <label>Start Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term2_startdate" class="form-control datepicker" value="<?php echo $term2_fet['fee_term_start_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>End Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term2_enddate" class="form-control datepicker" value="<?php echo $term2_fet['fee_term_end_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $term3_sql = "select * from fee_terms where fee_id= '$fee_id' and fee_term='Term 3' and fee_term_status=1";
                                        $term3_fet = mysql_fetch_array(mysql_query($term3_sql));
                                        ?>
                                        <div id="term3" style="display: none;">
                                            <label class="control-label col-lg-4">Term 3 </label>
                                            <div class="col-lg-4">
                                                <label>Start Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term3_startdate" class="form-control datepicker" value="<?php echo $term3_fet['fee_term_start_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>End Date :</label>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type="text" name="term3_enddate" class="form-control datepicker" value="<?php echo $term3_fet['fee_term_end_date']; ?>"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                <input type="hidden" name="fee_id" value="<?php echo $fee_id; ?>"/>
                                                <input type="submit" value="SUBMIT" class="btn btn-info form-control" onclick="return show_confirm();"/>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.row -->
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
        $( ".datepicker").datepicker({
            dateFormat:'yy-mm-dd'
        });
    } );
</script>

<script>
    $(function() {
        var ft = $('.f_term').val();
        if(ft == 'Term 1'){
            $('#term1').show();
        }
        else if(ft == 'Term 2'){
            $('#term1').show();
            $('#term2').show();
        }
        else if(ft == 'Term 3'){
            $('#term1').show();
            $('#term2').show();
            $('#term3').show();
        }


        $('#fee_terms').change(function() {
            var fee_terms =  $('#fee_terms option:selected').val();
            if(fee_terms == 'Term 1'){
                $('#term1').show();
                $('#term2').hide();
                $('#term3').hide();
            }
            else if(fee_terms == 'Term 2'){
                $('#term1').show();
                $('#term2').show();
                $('#term3').hide();
            }
            else if(fee_terms == 'Term 3'){
                $('#term1').show();
                $('#term2').show();
                $('#term3').show();
            }
        });
    });
</script>

</body>
</html>
