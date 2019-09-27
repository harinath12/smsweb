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

$markid = $_REQUEST['id'];

$mark_sql = "select sm.*, ett.exam_name, c.class_name from student_mark as sm
left join exam_time_table as ett on ett.id=sm.exam_id
left join classes as c on c.id=sm.classid
where sm.id='$markid'";
$mark_exe = mysql_query($mark_sql);
$mark_fet = mysql_fetch_array($mark_exe);

$classId = $mark_fet['classid'];
$sectionName = $mark_fet['section_name'];
$exam = $mark_fet['exam_id'];

$cls_sql="SELECT * FROM `classes` where id='$classId'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$className = $cls_fet['class_name'];

/* $student_exe = mysql_query("SELECT gen.student_name, gen.admission_number, sm.subject_name, sm.mark, sm.remarks FROM student_general AS gen
LEFT JOIN student_academic AS aca ON aca.user_id = gen.user_id
LEFT JOIN users AS u ON u.id = gen.user_id
RIGHT JOIN student_mark AS sm ON sm.student_id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1' and sm.subject_name='$sub' and sm.exam_id='$exam'"); */

$student_exe = mysql_query("Select gen.* from student_general as gen
left join student_academic as aca on aca.user_id = gen.user_id
left join users as u on u.id = gen.user_id
where aca.class='$classId' and aca.section_name='$sectionName' and delete_status='1'");
?>
<!DOCTYPE html>
<html>
<head>
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
                Marks View
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="marks-list.php">Marks List</a></li>
                <li class="active">Mark View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="box-body" id="predate">
                            <div class="row">
                                <form action="#" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Exam Name </label>
                                                <div class="col-lg-8">
                                                    <input type="text" value="<?php echo $mark_fet['exam_name'];?>" class="form-control" readonly />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Class</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="className" id="className" value="<?php echo $className;?>" readonly/>
                                                    <input type="hidden" class="form-control" name="classId" value="<?php echo $classId;?>" readonly/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Section</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $sectionName;?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Student Name</th>
                                            <th>Admission Number</th>
                                            <?php
                                            $sub_exe = mysql_query("SELECT DISTINCT subject_name FROM student_mark where classid=$classId and exam_id=$exam and section_name='$sectionName'");
                                            while($sub_fet = mysql_fetch_array($sub_exe)){
                                                ?>
                                                <th><?php echo $sub_fet['subject_name']; ?></th>
                                            <?php
                                            }
                                            ?>
                                            <th>Remarks</th>
                                        </tr>
                                        <?php
                                        $sno =1;
                                        while($student_fet = mysql_fetch_assoc($student_exe)){
                                            $studid = $student_fet['user_id'];
                                            ?>
                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $student_fet['student_name']; ?></td>
                                                <td><?php echo $student_fet['admission_number']; ?></td>
                                                <?php
                                                $sub_exe = mysql_query("SELECT DISTINCT subject_name FROM student_mark where classid=$classId and exam_id=$exam and section_name='$sectionName'");
                                                while($sub_fet = mysql_fetch_array($sub_exe)){
                                                    $subj = $sub_fet['subject_name'];
                                                    $mrk_fet = mysql_fetch_array(mysql_query("select * from student_mark where student_id='$studid' and exam_id=$exam and subject_name='$subj'"));
                                                    ?>
                                                    <td><?php echo $mrk_fet['mark']; ?></td>
                                                <?php
                                                }
                                                ?>
                                                <td>
                                                    <?php
                                                    $sub_exe = mysql_query("SELECT DISTINCT subject_name FROM student_mark where classid=$classId and exam_id=$exam and section_name='$sectionName'");
                                                    while($sub_fet = mysql_fetch_array($sub_exe)){
                                                    $subj = $sub_fet['subject_name'];
                                                    $mrk_fet = mysql_fetch_array(mysql_query("select * from student_mark where student_id='$studid' and exam_id=$exam and subject_name='$subj'"));
                                                        if($mrk_fet['remarks'] != null){
                                                            echo '<b>' . $subj .'</b> : ' . $mrk_fet['remarks'];
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $sno++;
                                        }
                                        ?>
                                    </table>
                                </form>
                            </div>
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
</body>
</html>
