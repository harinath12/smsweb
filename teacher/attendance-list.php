<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$className = $_REQUEST['className'];
$class_sql="SELECT * FROM `classes` where class_name='$className'";
$class_exe=mysql_query($class_sql);
$class_fet = mysql_fetch_assoc($class_exe);

$classId = $class_fet['id'];
$sectionName = $_REQUEST['sectionName'];

//$date = "2019-04-01";
$leave='no';
$leave_msg='';
if (date('N', strtotime($date)) == 7) {
    $leave='yes';
	$leave_msg='Sunday Holiday';
}

$calendar_leave_sql="SELECT * FROM `calendar` WHERE `calendar_type`=1 AND `calendar_start_date`='$date'";
$calendar_leave_exe = mysql_query($calendar_leave_sql);
$calendar_leave_cnt = @mysql_num_rows($calendar_leave_exe);
if($calendar_leave_cnt>0)
{
	$calendar_leave_fet = @mysql_fetch_array($calendar_leave_exe);
	$leave='yes';
	$leave_msg=$calendar_leave_fet['calendar_title'].' Holiday';
}
$stu_sql = "select gen.user_id, gen.student_name, gen.photo, aca.roll_number, aca.admission_number, aca.class, aca.section, att.forenoon, att.afternoon, att.remarks, att.fn_entry_status, att.an_entry_status from student_general as gen
Left JOIN student_academic as aca on aca.user_id = gen.user_id
Left Join attendance as att on att.user_id = gen.user_id and att.attendance_date='$date'
Left JOIN users as usr on usr.id = gen.user_id
where aca.class='$classId'and aca.section_name='$sectionName' and usr.delete_status=1";
$stu_exe = mysql_query($stu_sql);
$stu_cnt = @mysql_num_rows($stu_exe);
//echo $stu_cnt; exit;
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
                        <li><a href="attendance.php">Attendance</a></li>
                        <li class="active">Student List</li>
                    </ul>
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
                                <h4 class="panel-title">Student List</h4>
                            </div>
							<?php if($leave=='yes') { ?>
								 <p class="panel-title" style="padding: 10px;text-align: center;color: green;"><?php echo $leave_msg; ?></p>
							<?php } else { ?>
                            <form method="post" action="domarkattendance.php">
                                <?php
                                if($stu_cnt>0)
                                {
                                    ?>
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Photo</th>
											<th>Admission No.</th>
                                            <th>STUDENT NAME</th>
                                            <th class="forenoon">FORENOON &nbsp;&nbsp; <input type="checkbox" class="forenoonCheck" onClick="foretoggle(this)" /></th>
                                            <th class="afternoon">AFTERNOON &nbsp;&nbsp; <input type="checkbox" class="afternoonCheck" onClick="aftertoggle(this)" /></th>
                                            <th class="remarks">REMARKS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i =1;
                                        $j=0;
                                        while($stu_fet=mysql_fetch_array($stu_exe))
                                        {
                                            ?>
                                            <?php
                                            $fnattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and fn_entry_status=1"));
                                            $anattendance_cnt = mysql_num_rows(mysql_query("select * from attendance where class_id='$classId' and section_name='$sectionName' and attendance_date='$date' and an_entry_status=1"));

											$student_id=$stu_fet['user_id'];
											$leave_sql=mysql_query("select * from student_leave where student_id='$student_id' and leave_from_date='$date' and leave_status=1 and admin_status=1");	
											$leave_cnt = @mysql_num_rows($leave_sql);
											if($leave_cnt==1) {
											$leave_fet = @mysql_fetch_array($leave_sql);
											$leave_remark=	$leave_fet ['title'];
											}
											
                                            $hr = date('H');
                                            if ($hr < 12) {
                                                if($fnattendance_cnt > 0)
                                                {
                                                    $attendance_row="red";
                                                }
                                                else{
                                                    $attendance_row="black";
                                                }
                                            }
                                            elseif ($hr > 12 && $hr < 24){
                                                if($anattendance_cnt > 0)
                                                {
                                                    $attendance_row="red";
                                                }
                                                else{
                                                    $attendance_row="black";
                                                }
                                            }
                                            ?>
                                            <tr style="color:<?php echo $attendance_row; ?>">
                                                <td><?php echo $i; ?>
												
												<?php if($leave_cnt==1) { ?>
												<input type="hidden" name="leave_status" value="1" /> 
												<?php } else { ?>
												<input type="hidden" name="leave_status" value="0" /> 
												<?php } ?>
												
												</td>
												<td>
													<img src=" <?php echo '../admin/' . $stu_fet['photo']; ?>" alt="<?php echo $stu_fet['student_name']; ?>" title="<?php echo $user_name; ?>" class="img-circle img-lgX" style="width:60px;height:60px;" />
												</td>												
                                                <td><?php echo $stu_fet['admission_number']; ?></td>
                                                <td><?php echo $stu_fet['student_name']; ?></td>
                                                <td class="forenoon">
												<?php if($leave_cnt==1) { ?>
												<input type="checkbox" name="<?php echo 'forenoon['.$j .']'; ?>" class="forenoon" <?php //if($stu_fet['forenoon'] == 'on'){ echo 'checked'; } ?>  disabled /> 
												<?php } else { ?>
												<input type="checkbox" name="<?php echo 'forenoon['.$j .']'; ?>" class="forenoon" <?php if($stu_fet['forenoon'] == 'on'){ echo 'checked'; } ?> /> 
												<?php } ?>
												</td>
                                                <td class="afternoon">
												<?php if($leave_cnt==1) { ?>
												<input type="checkbox" name="<?php echo 'afternoon['.$j . ']'; ?>" class="afternoon" <?php //if($stu_fet['afternoon'] == 'on'){ echo 'checked'; } ?>  disabled />
												<?php } else { ?>
												<input type="checkbox" name="<?php echo 'afternoon['.$j . ']'; ?>" class="afternoon" <?php if($stu_fet['afternoon'] == 'on'){ echo 'checked'; } ?> />
												<?php } ?>
												</td>
                                                <td class="remarks">
												<?php if($leave_cnt==1) { ?>
												<input type="text" name="<?php echo 'remarks['.$j . ']'; ?>" class="form-control" value="<?php echo $leave_remark; ?>"/>
												<?php } else { ?>
												<input type="text" name="<?php echo 'remarks['.$j . ']'; ?>" class="form-control" value="<?php echo $stu_fet['remarks']; ?>"/>
												<?php } ?>
												</td>
                                                <input type="hidden" name="userId[]" value="<?php echo $stu_fet['user_id']; ?>"/>
                                            </tr>
                                        <?php
                                            $i++; $j++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                <div class="row submitBtn">
                                    <div class="col-lg-5"></div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="classId" value="<?php echo $classId; ?>"/>
                                        <input type="hidden" name="sectionId" value="<?php echo $sectionName; ?>"/>
                                        <input type="submit" value="OK" class="btn btn-info form-control" onclick="return confirm('Do you want to submit?');"/>
                                    </div>
                                    <div class="col-lg-5"></div>
                                </div>
                                <?php
                                }
                                else{
                                    ?>
                                    <p><b> No Results Found. </b></p>
                                <?php
                                }
                                ?>
                            </form>
							<?php } ?>
						</div>
                        <!-- /basic datatable -->

                    </div>
                </div>

                <script>
                    function foretoggle(source) {
                        checkboxes = document.getElementsByClassName('forenoon');
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            checkboxes[i].checked = source.checked;
                        }
                    }

                    function aftertoggle(source) {
                        checkboxes = document.getElementsByClassName('afternoon');
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            checkboxes[i].checked = source.checked;
                        }
                    }
                </script>

                <script type='text/javascript'>
                    $(document).ready(function() {
                        $(function() {
                            $('.styled').uniform();
                        });
                        $(function() {

                            // DataTable setup
                            $('.datatable').DataTable({
                                autoWidth: false,
                                columnDefs: [
                                    {
                                        width: '10%',
                                        targets: 0
                                    },
                                    {
                                        width: '15%',
                                        targets: [1,3,4]
                                    },
                                    {
                                        width: '25%',
                                        targets:2
                                    },
                                    {
                                        width: '20%',
                                        targets: 5,
                                        orderable: false
                                    }
                                ],
                                order: [[ 0, 'asc' ]],
                                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                                language: {
                                    search: '<span>Search:</span> _INPUT_',
                                    lengthMenu: '<span>Show:</span> _MENU_',
                                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                                },
                                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                                displayLength: 1000
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

<script>
    /*$(document).ready(function() {
        var date = new Date();
        var hh = date.getHours();
        if (hh>8 && hh < 11) {
            $('.forenoon').show();
            $('.remarks').show();
            $('.submitBtn').show();
            $('.afternoon').hide();
        }
        if (hh>12 && hh<14) {
            $('.forenoon').hide();
            $('.remarks').show();
            $('.afternoon').show();
            $('.submitBtn').show();
        }

    });*/
</script>