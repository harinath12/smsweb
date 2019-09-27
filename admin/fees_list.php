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


/*$fee_sql = "select fi.*, ft.fee_term from fee_terms as ft
left join fee_info as fi on fi.id = ft.fee_id
where fee_status='1' and fee_term_status=1";
$fee_exe = mysql_query($fee_sql); */

$fee_sql = "select * from fee_info where fee_status='1'";
$fee_exe = mysql_query($fee_sql);
?>
<!DOCTYPE html>
<html>
<head>
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
                Fees
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Fees</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    if(isset($_REQUEST['succ'])) {
                        if ($_REQUEST['succ'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Fees Added Successfully</strong>
                            </div>
                        <?php
                        }
                    }

                    if(isset($_REQUEST['del'])) {
                        if ($_REQUEST['del'] == 1) {
                            ?>
                            <div class="alert alert-success alert-dismessible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Fees Deleted Successfully</strong>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    <div class="box" style="min-height: 600px;">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="fee-add.php">
                                    <button type="button" class="form-control btn btn-info">Add Fees</button>
                                </a>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>FEE NAME</th>
                                    <th>FEE AMOUNT</th>
                                    <th>FEE TERMS</th>
                                    <th>ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i =1;
                                while($fee_fet=mysql_fetch_array($fee_exe))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $fee_fet['fee_name'];?></td>
                                        <td><?php echo $fee_fet['fee_amount'] ?></td>
                                        <td><?php echo $fee_fet['fee_terms']; ?></td>
                                        <td class="text-center">
                                            <ul class="icons-list">
                                                <li><a href="fees-view.php?fee_id=<?php echo $fee_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                                                <li><a href="fees-edit.php?fee_id=<?php echo $fee_fet['id']; ?>"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                                                <li><a href="fees_delete.php?fee_id=<?php echo $fee_fet['id']; ?>" onclick="return confirm('Do you want to delete?');"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-trash"></i></button></a></li>&nbsp;&nbsp;
                                            </ul>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
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

                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 10
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
                url: "ajax-project.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
                    "bSort": false,
                    autoWidth: false,

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

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on("click", '.openPopup', function(event) {
            var dataURL = $(this).attr('data-href');
            $('.modal-body').load(dataURL,function(){
                $('#myModal').modal({show:true});
                $('#myModal .modal-body').html('<iframe src="'+dataURL+'" width="100%" height="100%" />');
            });
        });
    });
</script>
<style>
    div.modal-dialog { width:75% !important; }
    div.modal-body { height:600px !important; }
</style>
</body>
</html>
