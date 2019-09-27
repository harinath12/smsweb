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

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$sub_sql = "SELECT cs.* FROM class_subject as cs WHERE class_id = '$classId' and class_subject_status='1'";
$sub_exe = mysql_query($sub_sql);
$sub_results = array();
while($row = mysql_fetch_assoc($sub_exe)) {
    array_push($sub_results, $row);
}

$date = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS - Student</title>
    <?php include "head-inner.php"; ?>
    <style>
        .req{
            color: red;
        }
    </style>
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
                        <h4><i class="fa fa-th-large position-left"></i> VIDEO BOOKS</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active">Video Books</li>
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
                                <h4 class="panel-title">Video Books- <?php echo $className . " " . $sectionName; ?></h4>
                            </div>
                            </br>

                            <div class="panel-body">

                                <form action="" method="post">
                                    <div class="col-md-12">
									<?php /* ?>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="className" value="<?php echo $className;?>" readonly/>
                                                <input type="hidden" class="form-control" name="classId" id="classId" value="<?php echo $classId;?>" readonly/>
                                            </div>
                                        </div>
									<?php */ ?>
									
									
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="term" id="term" required >
                                                    <option value="">Select Term</option>
                                                    <option value="Term 1">Term 1</option>
                                                    <option value="Term 2">Term 2</option>
                                                    <option value="Term 3">Term 3</option>
                                                </select>
                                            </div>
                                        </div>
										
										<?php /* ?>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control subjectName" name="subjectName" id="subjectId">
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                    foreach($sub_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['subject_name']; ?>"><?php echo $value['subject_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
										<?php */ ?>	

										<br/><br/>
										<div id="showsubject" style="display:none;">
										<?php foreach($sub_results as $key => $value){ ?> 
										<div class="form-group">
                                            <div class="col-lg-2"> 
                                                <input onclick="javascript:showvideos('<?php echo $value['subject_name']; ?>','<?php echo $className; ?>');" type="button" value="<?php echo $value['subject_name']; ?>" class="btn btn-info form-control" style="height: 100px;width: 100px;padding: 10px;margin: 10px;border:2px solide #666"/>
                                            </div>
                                        </div>                                              
										<?php } ?>
										</div>
										
                                         
                                    </div>

                                </form>

                            </div>
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
<script>
    $(function() {
        $('#term').change(function() {
			var term  = $('#term').val();
			if(term!="") 
			{
				$('#showsubject').show();
			}
			else
			{
				$('#showsubject').hide();
			}
			
		});
		
		
		
		/*
		$('#term').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });

        $('#subjectId').change(function() {
            $('#chapter').empty();
            var classId  = $('#classId').val();
            var subject  = $('#subjectId').val();
            var term  = $('#term').val();
            if((classId != null) && (classId != "") && (subject != null) && (subject != "") && (term != null) && (term != "") ){
                $.get('chapterscript.php', {cid: classId, sub: subject, term: term}, function(result){
                    var chaplist = "<option value=''>Select Chapter</option>";
                    $.each(JSON.parse(result), function(i,item) {
                        chaplist = chaplist + "<option value='" + item.cname + "'>" + item.cname + "</option>";
                    });
                    $("#chapter").html(chaplist);
                });
            }
            else{
                return false;
            }
        });
		*/
    });
	
	function showvideos(subjectid,classid) {
		 var subjectName = subjectid;
		 var className = classid;
		 var termName  = $('#term').val();
		 
		 
		 window.location = 'video-books-view.php?subjectName='+subjectName+'&className='+className+'&term='+termName;
		
	}
</script>

</body>
</html>