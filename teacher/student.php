<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$staff_sql = "select * from teacher_academic where user_id='$user_id'";
$staff_exe = mysql_query($staff_sql);
$staff_fet = mysql_fetch_assoc($staff_exe);
$staff_cnt = @mysql_num_rows($staff_exe);

if($staff_cnt > 0){
    $classTeacher = explode(" ", $staff_fet['class_teacher']);
    $class = $classTeacher[0];
    $section = $classTeacher[1];

    $cls_sql="SELECT * FROM `classes` where class_name='$class'";
    $cls_exe=mysql_query($cls_sql);
    $cls_fet = mysql_fetch_assoc($cls_exe);
    $classId = $cls_fet['id'];

$stu_sql = "select sgen.* from student_general as sgen
LEFT JOIN student_academic as saca on saca.admission_number = sgen.admission_number
LEFT JOIN classes as c on c.id = saca.class
LEFT JOIN section as s on s.id = saca.section
where c.class_name = '$class' and saca.section_name = '$section'";
$stu_exe = mysql_query($stu_sql);
    $stu_cnt = @mysql_num_rows($stu_exe);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Teacher</title>
    <?php include "head-inner.php"; ?>
</head>
<body>
<!-- Main navbar -->
<?php
include 'header.php';
?>
<!-- /main navbar -->

<!-- Page container -->
<div class="page-container" style="min-height:700px">

    <!-- Page content -->
    <div class="page-content"><!-- Main sidebar -->
        <div class="sidebar sidebar-main hidden-xs">
            <?php include "sidebar.php"; ?>
        </div>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="fa fa-th-large position-left"></i> STUDENT LIST</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Student List</li>
                    </ul>
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Info updated Successfully</strong>
                            </div>
                        <?php
                        }
						if ($_REQUEST['succ'] == 2) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Student Section updated Successfully</strong>
                            </div>
                        <?php
                        }
						
                    }
                    ?>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <!-- basic datatable -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <div class="row">
                                <div class="col-md-8"><h4 class="panel-title">Student List</h4>
								</div>
                                <div class="col-md-2" style="float: right">
                                	<a href="student-add-section.php"><button type="button" class="form-control btn btn-info">ADD</button></a>
								</div>
								<div class="col-md-2" style="float: right">
                                	<a href="student-move-section.php"><button type="button" class="form-control btn btn-info">MOVE </button></a>
                                </div>
                            </div>
                            </br>
                            </div>
                            <form method="post">
                                <?php
                                if($staff_cnt>0)
                                {
                                    ?>
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
											<th>PHOTO</th>
                                            <th>NAME</th>
                                            <th>ADMISSION NO.</th>
                                            <th>MOBILE</th>
                                            <th>FATHER NAME</th>
                                            <?php if($classId != 13){
                                                ?>
                                                <th class="text-center">ACTIONS</th>
                                            <?php
                                            }?>

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
												<td>
													<img src=" <?php echo '../admin/' . $stu_fet['photo']; ?>" alt="<?php echo $stu_fet['student_name']; ?>" title="<?php echo $user_name; ?>" class="img-circle img-lgX" style="width:60px;height:60px;" />
												</td>												
                                                <td><?php echo $stu_fet['student_name']; ?></td>
                                                <td><?php echo $stu_fet['admission_number'] ?></td>
                                                <td><?php echo $stu_fet['mobile']; ?></td>
                                                <td><?php echo $stu_fet['father_name']; ?></td>
                                                <?php if($classId != 13){
                                                    ?>
                                                    <td class="text-center">
                                                        <ul class="icons-list">
                                                            <li><a href="student-view.php?student_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                            <li><a href="student-edit.php?student_id=<?php echo $stu_fet['user_id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                        </ul>
                                                    </td>
                                                <?php
                                                }?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> No Results Found. </b></p>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                        <!-- /basic datatable -->

                        <!-- The Modal -->
                        <div id="myModal" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header" style="padding-top: 0px;">
                                    <span class="close">&times;</span>
                                    <h2>Add To Groups</h2>
                                </div>
                                <div class="modal-body">
                                    <form id="modalForm" class="modalForm" action="doAddStaffGroup.php" method="post" >
                                        <div class="col-md-12">
                                            <label class="col-md-5">Group Name:<span style="color:red">*</span> </label>
                                            <input type="text" class="form-control col-md-7" name="groupName" required />
                                        </div>

                                        <div class="col-md-12" style="height:15px"></div>

                                        <div class="col-md-4">
                                            <input type="hidden" name="staffId" class="staffId" value=""/>
                                            <input type="submit" class="btn btn-info form-control" name="" value="Add" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <script type='text/javascript'>
                    $(document).ready(function() {
                        $(function() {
                            $('.styled').uniform();
                        });
                        $(function() {

                            // DataTable setup
                            $('.datatable').DataTable({
                                autoWidth: false,

                                order: [[ 0, 'asc' ]],
                                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                                language: {
                                    search: '<span>Search:</span> _INPUT_',
                                    lengthMenu: '<span>Show:</span> _MENU_',
                                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                                },
                                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                                displayLength: 100
                            });

                            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

                            $('.dataTables_length select').select2({
                                minimumResultsForSearch: Infinity,
                                width: '60px'
                            });
                        });
                    });
                </script>
                <!-- Footer -->
                <?php include "footer.php"; ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
</body>
</html>