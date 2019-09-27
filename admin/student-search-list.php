<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$query = "select si.*, aca.section_name, c.class_name from student_general as si
LEFT JOIN student_academic as aca on aca.user_id = si.user_id
LEFT JOIN `users` ON users.id = si.user_id
LEFT JOIN classes as c on c.id = aca.class
where users.delete_status=1";

$search = $_REQUEST['search'];
$search_value = $_REQUEST['search_value'];
$cnt = count($search);
//echo $search[0];
for($i =0; $i<$cnt; $i++){
    if(!empty($search[$i])){
        if(($search[$i] == 'student_name') || ($search[$i] == 'admission_number') || ($search[$i] == 'emis_number') || ($search[$i] == 'father_name') || ($search[$i] == 'mother_name') || ($search[$i] == 'gender') || ($search[$i] == 'community') || ($search[$i] == 'religion') || ($search[$i] == 'caste') ){
            $query = $query . " and si.$search[$i] like '%$search_value[$i]%'";
        }
        else if(($search[$i] == 'section_name'))
		{
            $query = $query . " and aca.$search[$i] = '$search_value[$i]'";
        }
		else if(($search[$i] == 'class'))
		{
            $query = $query . " and c.class_name = '$search_value[$i]'";
        }
		else
		{
			$query = $query . " and si.$search[$i] like '%$search_value[$i]%'";
		}
	
    }
}
//echo $query; 
//exit;
$stu_exe = mysql_query($query);
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
                Student List
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="student-search.php">Advance Search</a></li>

                <li class="active">Student List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body">
                            <form method="post" action="#">
                               <span id="studentTable">
                                        <table class="table datatable">
                                            <thead>
                                            <tr>
                                                <th class="hidden"><input type="checkbox" class="stuCheck" onClick="toggle(this)" /> Select All</th>
                                                <th>S.No.</th>
                                                <th>NAME</th>
                                                <th>ADMISSION NO.</th>
                                                <th>CLASS</th>
                                                <th>MOBILE</th>
                                                <th>FATHER NAME</th>
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
                                                    <td class="hidden"><input type="checkbox" class="stuCheck" name="student[]" value="<?php echo $stu_fet['user_id'] ?>"/> </td>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $stu_fet['student_name']; ?></td>
                                                    <td><?php echo $stu_fet['admission_number'] ?></td>
                                                    <td><?php echo $stu_fet['class_name'] . "-" . $stu_fet['section_name']; ?></td>
                                                    <td><?php echo $stu_fet['mobile']; ?></td>
                                                    <td><?php echo $stu_fet['father_name']; ?></td>
                                                    <td class="text-center">
                                                        <ul class="icons-list">
                                                            <li><a href="student-view.php?student_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="student-edit.php?student_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="student-delete.php?student_id=<?php echo $stu_fet['user_id']; ?>" onclick="return confirm('Do you want to delete?');"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-remove"></i></button></a></li>&nbsp;&nbsp;
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </span>
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
    $(document).ready( function () {
        $('.datatable').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 7
                }
            ]
        });
    } );
</script>
<!-- page script -->

</body>
</html>