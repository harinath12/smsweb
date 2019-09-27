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

$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}

$grand_fet = mysql_fetch_array(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1'"));
$boys_grand_fet = mysql_fetch_array(mysql_query("select count(*) as boys_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Male'"));
$girls_grand_fet = mysql_fetch_array(mysql_query("select count(*) as girls_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where usr.delete_status='1' and gen.gender='Female'"));

/* $section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
} */
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
            <h1>
                Students Promotion
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Students Promotion</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="row hidden">
                            <div class='col-sm-3' style="float: right">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="box-body" id="predate">
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Boys</th>
                                    <th>Girls</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($class_master_results as $key => $value){
                                    $className = $value['class_name'];
                                    $classId = $value['id'];

                                    $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
                                    $section_exe=mysql_query($section_sql);
                                    $section_results = array();
                                    while($row = mysql_fetch_assoc($section_exe)) {
                                        array_push($section_results, $row);
                                    }

                                    foreach ($section_results as $sec_key => $sec_value) {
                                        $sectionName = $sec_value['section_name'];
                                        $sectionId = $sec_value['id'];
                                        ?>
                                        <tr>
                                            <td><a href="students-list-promotion.php?classId=<?php echo $classId;?>&sectionName=<?php echo $sectionName;?>"><?php echo $className . " " . $sectionName; ?></td>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Male' and usr.delete_status='1'"));
                                                echo $fet1['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and gen.gender='Female' and usr.delete_status='1'"));
                                                echo $fet2['student_count'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select count(*) as student_count from student_general as gen LEFT JOIN student_academic as aca on aca.user_id = gen.user_id LEFT JOIN users as usr on usr.id = gen.user_id where aca.class='$classId' and aca.section_name='$sectionName' and usr.delete_status='1'"));
                                                echo $fet3['student_count'];
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
								<?php /* ?>
                                <tr>
                                    <th>Grand Total</th>
                                    <td>
                                        <?php
                                        echo $boys_grand_fet['boys_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $girls_grand_fet['girls_count'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $grand_fet['student_count'];
                                        ?>
                                    </td>
                                </tr>
								<?php */ ?>
                                </tbody>

                            </table>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
        });
    } );
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
            // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,
                columnDefs: [
                    {
                        width: '25%',
                        targets: 0,
                        orderable:false
                    },
                    {
                        width: '25%',
                        targets:[1,2,3],
                        orderable:false
                    }
                ],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
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
<!-- page script -->

<script>
    $( function() {
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-home-work.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
                    "bSort": false,
                    autoWidth: false,
                    columnDefs: [
                        {
                            width: '12%',
                            targets: 0,
                            orderable:false
                        },
                        {
                            width: '11%',
                            targets:[1,2,3,4,5,6,7,8],
                            orderable:false
                        }
                    ],
                    dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Search:</span> _INPUT_',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                    },
                    lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                    displayLength: 100
                });

            });

        });
    } );


</script>

</body>
</html>
