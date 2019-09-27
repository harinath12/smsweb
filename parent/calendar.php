<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Parent</title>
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Calendar</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body" style="padding-left: 20px;"> 
						
						<?php  //include "../fullcalendar/demos/admin-index.php"; ?>
							<iframe src="../fullcalendar/demos/admin-index.php" width="100%" height="800px" border="0" style="border: none;" ></iframe>
							
                        </div>
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
        $( "#datepicker1").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
        });
		$( "#datepicker2").datepicker({
            dateFormat:'yy-mm-dd',
            minDate: 'today'
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
                        width: '15%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets:[1,2,4]
                    },
                    {
                        width: '25%',
                        targets: 3
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
        $( "#datepicker1").on( "change", function() {
            var d = $(this).val();
        });
		$( "#datepicker2").on( "change", function() {
            var d = $(this).val();
        });
    } );
</script>



<script>
    $(function() {
        $('.className').change(function() {
            var clsId = $('#className').val();
            $('#sectionName').empty();
            
			$.get('ajaxsection.php', {cid: clsId}, function(result){
				console.log(result);
                var sublist = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.section_name + "'>" + item.section_name + "</option>";
                });
                $("#sectionName").html(sublist);
            });
        });
    });

    $(function() {
        $('#duration').change(function() {
            var dura = $('#duration').val();
            if(dura == 'More Than One Day'){
                $('#leavefromdate').show();
                $('#leavetodate').show();
            }
            else{
                $('#leavefromdate').show();
                $('#leavetodate').hide();
            }
        });

        $('.leaveType').change(function() {
            var rType = $('input[name="leaveType"]:checked').val();
            if(rType == 'Text'){
                $('#leaveaudio').hide();
                $('#leavetext').show();
            }
            else if(rType == 'Audio'){
                $('#leavetext').hide();
                $('#leaveaudio').show();
            }
        });
    });
</script>


<script>
    $(function() {
        $('#addHomeWorkBtn').click(function() {
            $('#addHomeWork').toggle();
            $('#editHomeWork').css("display","none");
        });
    });
</script>

<script>
    $(function() {
        $('.editHomeWorkBtn').click(function() {
            $('#addHomeWork').hide();
            $('#editHomeWork').toggle();
            var id = $(this).siblings('.homeworkId').val();
            $.ajax({
                url: "ajax-edit-home-work.php?id=" + id,
                context: document.body
            }).done(function(response) {
                $('#editHomeWork').html(response);
            });
        });
    });
</script>
<script type="text/javascript">
    function show_confirm() {
        var txt = 'HI';
        var From_Message =  'From Date::'+$('#className').val();
        var To_Message =  'To Date::'+$('#sectionName').val();
        var title_Message =  'Title::'+$('#title').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to apply the Leave?'+'\n'+From_Message+'\n'+To_Message+'\n'+title_Message+'\n'+details_Message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
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