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

$ques_sql = "select q.*, c.class_name from aptitude_question_bank as q
left join classes as c on c.id = q.class_id
where question_bank_status='1'";
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Aptitude Question Bank</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Aptitude Question Bank</li>
            </ol>
        </section>
         
        <!-- Main content -->
        <section class="content">
			<div class="row">
			<br/>
				<div class="col-sm-3" style="float: right">
					<div class="form-group">
					<a href="aptitude-questionbankimport.php">
						<button type="button" class="form-control btn btn-info">Import Aptitude Question Bank</button>
					</a>
					</div>
				</div>
				
				<div class="col-md-3" style="float: right">
					<a href="aptitude-questionbankadd.php">
						<button type="button" class="form-control btn btn-info">Add Aptitude Question Bank</button>
					</a>
				</div>
			</div>
						
			<div class="box-body" id="predate">

        <table class="table datatable">
            <thead>
            <tr>
                <th>S.No.</th>
                <th>CLASS</th>
                <th>SUBJECT</th>
                <th>CHAPTER</th>
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
                        <td><?php echo $ques_fet['class_name']; ?></td>
                        <td><?php echo $ques_fet['subject_name'] ?></td>
                        <td><?php echo $ques_fet['chapter']; ?></td>
                        <td class="text-center">
                            <ul class="icons-list">
                                <li><a href="aptitude-question-bank-view.php?question_id=<?php echo $ques_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
								<li><a href="aptitude-question-bank-edit.php?question_id=<?php echo $ques_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                            </ul>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            <?php
            }
			else
			{
            ?>
				<tbody>
                    <tr>
                        <td colspan="5" class="text-center">
                            <p> No Data Found! </p>
                        </td>
                    </tr>
                </tbody>
			<?php
			}
			?>
        </table>
        
			</div>
		</section>
		<!-- Main content -->
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 4
                }
            ]
        });
    } );
</script>

</body>
</html>
