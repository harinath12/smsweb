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
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color: red;
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
                Add Home Work
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="home-work.php"> Home Work</a></li>
                <li class="active">Add Home Work </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Add Home Work
                            </h4>
                        </div>
                        <div class="panel-body no-padding-bottom">
                            <div class="col-md-6">
                                <form action="doaddhomework.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="className" id="classId" required>
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_master_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" class="form-control" name="clsName" id="clsName" value=""/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Section<span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control sectionName" name="sectionName[]" id="sectionId" multiple style="height: 100px;">
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Subject <span class="req"> *</span> </label>
                                            <div class="col-lg-8">
                                                <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Period</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="period" id="period">
                                                    <option value="">Select Period</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
                                                    <option value="VI">VI</option>
                                                    <option value="VII">VII</option>
                                                    <option value="VIII">VIII</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group hidden">
                                            <label class="control-label col-lg-4">Title</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="title" id="title" value=""/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Home Work Details</label>
                                            <div class="col-lg-8">
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Attachment</label>
                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="homeWorkFile">
                                            </div>
                                        </div>
										
										<div class="form-group">
											<label class="control-label col-lg-4">Daily Test</label>
											<div class="col-lg-8">
												<select class="form-control testName" name="testName[]" id="testName" multiple style="height: 100px;">
													<option value="">Select Test</option>
												</select>
											</div>
										</div>


                                        <div class="form-group">
                                            <div class="col-lg-2">
                                                <input type="submit" value="ADD" class="btn btn-info form-control" onclick="return show_confirm();"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.row -->
            </div>
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

<script type="text/javascript">
    $(function() {
        $('#classId').change(function() {
            var cid =  $('#classId').val();
            $.get('ajax-class-name.php', {cid: cid}, function(result){
                $("#clsName").val(result.trim());
            });
        });
    });
	
    function show_confirm() {
        var className_Message =  'Class::'+$('#clsName').val();
        var sectionName_Message =  'Section::'+$('#sectionId').val();
        var subjectName_Message =  'Subject::'+$('#subjectId').val();
        var period_Message =  'Period::'+$('#period').val();
        //var title_Message =  'Title::'+$('#title').val();
        var details_Message =  'Details::'+$('#description').val();

        if(confirm('Do you want to add the Home Work?'+'\n'+className_Message+'\n'+sectionName_Message+'\n'+subjectName_Message+'\n'+period_Message+'\n'+details_Message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<script>
    $(function() {
        $('#classId').change(function() {
            $('#sectionId').empty();
            $.get('sectionscript.php', {region: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionId").html(list);
            });
        });

        $('#classId').change(function() {
            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var list = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(list);
            });
        });
		
        $('#subjectId').change(function() {
            $('#testName').empty();
			var cid =  $('#classId').val();
			var subid =  $('#subjectId').val();
			
            $.get('ajax-test-name.php', {cid: cid,subid: subid}, function(result){
				var list = "<option value=''>Select Test</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.testid + "'>" + item.testname + "</option>";
                });
                $("#testName").html(list);
            });
        });

    });
</script>

</body>
</html>
