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

$class_sql="SELECT cn.*, tea.teacher_name  FROM class_notes as cn
LEFT JOIN teacher_general as tea on tea.user_id = cn.teacher_id
where class_notes_status=1";
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
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Class Notes List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Class Notes List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-header">
                            <h3 class="box-title" style="line-height:30px;">Class Notes List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            if($class_cnt>0)
                            {
                                ?>
                                <table id="example2" class="table datatable">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Teacher Name</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Period</th>
                                        <th>Description</th>
                                        <th class="text-center">ACTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i =1;
                                    while($class_fet=mysql_fetch_array($class_exe))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $class_fet['teacher_name']; ?></td>
                                            <td><?php echo $class_fet['class'] . ' ' . $class_fet['section']; ?></td>
                                            <td><?php echo $class_fet['subject'] ?></td>
                                            <td><?php echo $class_fet['period'] ?></td>
                                            <td><?php echo $class_fet['description']; ?></td>
                                            <td class="text-center">
                                                <ul class="icons-list">
                                                    <li><a href="class-notes-view.php?notes_id=<?php echo $class_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            <?php
                            }
                            else{
                                ?>
                                <p><b> Records are being updated. </b></p>
                            <?php
                            }
                            ?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
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
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 6
                }
            ]
        });
    } );
</script>
<!-- page script -->

</body>
</html>
