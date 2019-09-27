<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$stu_sql = "select si.*, aca.class_teacher, aca.subject from teacher_general as si
LEFT JOIN `users` ON users.id = si.user_id
LEFT JOIN teacher_academic as aca on aca.user_id = si.user_id
where users.delete_status=1";
$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);
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
                Teacher List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Teacher List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body">
                            <form method="post" action="">
                                <div class="panel-body">
                                    <?php
                                    if(isset($_REQUEST['import'])){
                                        if($_REQUEST['import'] == 1){
                                            ?>
                                            <div class="alert alert-success alert-dismessible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Teacher Info imported Successfully</strong>
                                            </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3 hidden">
                                            <button type="submit" class="form-control btn btn-info" onclick="return confirm('Do you want to delete?');">Delete Student</button>
                                        </div>
                                        <div class="col-md-3 hidden">
                                            <button type="button" class="form-control btn btn-info"> Send Message</button>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="teacher-import.php"><button type="button" class="form-control btn btn-info" id="myBtn">Import Teacher</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="teacher-add.php"><button type="button" class="form-control btn btn-info">Add Teacher</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="teacher-search.php"><button type="button" class="form-control btn btn-info">Search Teacher</button></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($stu_cnt>0)
                                {
                                    ?>
                                    <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>NAME</th>
                                                <th>CLASS TEACHER</th>
                                                <th>SUBJECT</th>
                                                <th>EMAIL</th>
                                                <th>MOBILE</th>
                                                <th class="text-center">ACTIONS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i =1;
                                            while($stu_fet=mysql_fetch_array($stu_exe))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $stu_fet['teacher_name']; ?></td>
                                                    <td><?php echo $stu_fet['class_teacher'] ?></td>
                                                    <td><?php echo $stu_fet['subject']; ?></td>
                                                    <td><?php echo $stu_fet['email']; ?></td>
                                                    <td><?php echo $stu_fet['mobile']; ?></td>
                                                    <td class="text-center">
                                                        <ul class="icons-list">
                                                            <li><a href="teacher-view.php?teacher_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="teacher-edit.php?teacher_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="teacher-delete.php?teacher_id=<?php echo $stu_fet['user_id']; ?>" onclick="return confirm('Do you want to delete?');"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-remove"></i></button></a></li>&nbsp;&nbsp;
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </span>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> Records are being updated. </b></p>
                                <?php
                                }
                                ?>
                            </form>
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
    $(document).ready(function() {
        $('.datatable').DataTable({
            autoWidth: false,
            "scrollX": true,
            columnDefs: [
                {
                    width:'15%',
                    orderable: false,
                    targets: 6
                }
            ]
        });
    });
</script>
<!-- page script -->

</body>
</html>