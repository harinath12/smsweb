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

$ques_sql = "select q.*, c.class_name from self_test as q
left join classes as c on c.id = q.class_id
where daily_test_status='1' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
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
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Self Test Report</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- basic datatable -->
                <div class="panel panel-flat" style="overflow-x: scroll;">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>STUDENT</th>
                            <th>CLASS</th>
                            <th>SECTION</th>
                            <th>SUBJECT</th>
                            <th>TEST NAME</th>
                            <th>REMARK</th>
                            <th>DATE</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <?php
                        if($ques_cnt>0)
                        {
                            ?>
                            <tbody>
                            <?php
                            $i =1;
                            while($ques_fet=mysql_fetch_array($ques_exe))
                            {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $ques_fet['created_by']; ?></td>
                                    <td><?php echo $ques_fet['class_name']; ?></td>
                                    <?php
                                    $id=$ques_fet['section_id'];
                                    $sec_sql="SELECT * FROM `class_section` where id='$id'";
                                    $sec_exe=mysql_query($sec_sql);
                                    $sec_fet = mysql_fetch_assoc($sec_exe);
                                    $section_name = $sec_fet['section_name'];
                                    ?>
                                    <td><?php echo $section_name; ?></td>
                                    <td><?php echo $ques_fet['subject_name'] ?></td>
                                    <td><?php echo $ques_fet['daily_test_name'] ?></td>
                                    <td><?php echo $ques_fet['daily_test_remark']; ?></td>
                                    <td>
									<?php //echo $ques_fet['created_at']; ?>
									<?php echo date_display($ques_fet['created_at']);?>
									</td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li><a href="report-self-test-answer.php?test_id=<?php echo $ques_fet['id']; ?>" title="View"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View Report</button></a></li>&nbsp;&nbsp;
                                        </ul>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <!-- /basic datatable -->

            </div>
        </div>
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

</body>
</html>
