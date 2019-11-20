<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$date = date("Y-m-d");
$date1 = date("Y-m-d", strtotime( '-1 days' ) );
$date2 = date("Y-m-d", strtotime( '-2 days' ) );
$date3 = date("Y-m-d", strtotime( '-3 days' ) );
$date4 = date("Y-m-d", strtotime( '-4 days' ) );

$dates = array();
$dates = [$date,$date1,$date2,$date3,$date4];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">
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
                        <h4><i class="fa fa-th-large position-left"></i> CLASS NOTES</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Class Notes</li>
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
                                <h4 class="panel-title">Class Notes- <?php echo $className . " " . $sectionName; ?></h4>
                            </div>
                            </br>
                            <div class="row">
                                <div class='col-sm-3' style="float: right">
                                    <div class="form-group">
                                        <div class='input-group date'>
                                            <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body" id="predate">
                                <table id="example2" class="table datatable curdate">
                                    <thead>
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($dates as $dat) {
                                        ?>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2"><?php echo $dat; ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='I' and date='$dat' and admin_status='1'"));
                                                echo $fet1['subject'] . " " . $fet1['description'];
                                                if($fet1['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet1['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='II' and date='$dat' and admin_status='1'"));
                                                echo $fet2['subject'] . " " . $fet2['description'];
                                                if($fet2['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet2['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='III' and date='$dat' and admin_status='1'"));
                                                echo $fet3['subject'] . " " . $fet3['description'];
                                                if($fet3['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet3['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet4 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='IV' and date='$dat' and admin_status='1'"));
                                                echo $fet4['subject'] . " " . $fet4['description'];
                                                if($fet4['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet4['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet5 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='V' and date='$dat' and admin_status='1'"));
                                                echo $fet5['subject'] . " " . $fet5['description'];
                                                if($fet5['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet5['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet6 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VI' and date='$dat' and admin_status='1'"));
                                                echo $fet6['subject'] . " " . $fet6['description'];
                                                if($fet6['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet6['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet7 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VII' and date='$dat' and admin_status='1'"));
                                                echo $fet7['subject'] . " " . $fet7['description'];
                                                if($fet7['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet7['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $fet8 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VIII' and date='$dat' and admin_status='1'"));
                                                echo $fet8['subject'] . " " . $fet8['description'];
                                                if($fet8['class_notes_file_path'])
                                                {
                                                    ?>
                                                    <a href="<?php echo '../teacher/' . $fet8['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>

                                </table>
                            </div><!-- /.box-body -->
                        </div>
                        <!-- /basic datatable -->

                    </div>
                </div>

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
                url: "ajax-class-notes.php?dat=" + d,
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