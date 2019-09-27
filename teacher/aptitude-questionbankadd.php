<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}
 
include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT distinct c.* FROM `class_section` as cs LEFT JOIN classes as c on c.id = cs.class_id where c.class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$className = null;
$teacher_sql="SELECT * FROM `teacher_academic` where user_id='$user_id'";
$teacher_exe=mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$classTeacher = $teacher_fet['class_teacher'];
$clsteacher = explode(" ", $classTeacher);
$className = $clsteacher[0];
$sectionName = $clsteacher[1];

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


$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
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

    <style>
        span.req{
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="aptitude-question-bank.php"> Aptitude Question Bank</a></li>
                        <li class="active">Add Aptitude Question Bank</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">

                            <form action="dosaveaptitudequestionbank.php" method="post" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Class <span class="req"> *</span></label>
                                        <div class="col-lg-8">
											<select class="form-control" name="classId" id="classId" required>
                                                    <option value="">Select Class</option>
                                                    <?php
                                                    foreach($class_master_results as $key => $value){ ?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['class_name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                            </select>
                                            <input type="hidden" class="form-control" name="className" id="clsName" value=""/>
											<input type="hidden" class="form-control" name="term" id="term" value=""/>
                                        </div>
                                    </div>
									
									
									<div class="form-group">
                                        <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control subjectName" name="subjectName" id="subjectId" value="" required />
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control chapter" name="chapter" id="chapter" value="" required />
                                        </div>
                                    </div>
									
									
									<?php /* ?>		
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Subject <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control subjectName" name="subjectName" id="subjectId" required>
                                                <option value="">Select Subject</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-lg-4">Term <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="term" id="term" required>
                                                <option value="">Select Term</option>
                                                <option value="Term 1">Term 1</option>
                                                <option value="Term 2">Term 2</option>
                                                <option value="Term 3">Term 3</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-lg-4">Chapter <span class="req"> *</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control chapter" name="chapter" id="chapter" required>
                                                <option value="">Select Chapter</option>
                                            </select>
                                        </div>
                                    </div>
									<?php */ ?>
                                    
                                </div>

                                <div class="row" style="padding:10px;">
                                    <div class="col-md-12">
  
    
                                        <div class="row">
                                            <h6><b>Choose</b></h6>
                                            <div class="form-group hidden">
                                                <div class="col-lg-2">
                                                    <label>Question</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option A</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option B</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option C</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Option D</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Answer</label>
                                                </div>
                                            </div>
   <style>
                                                input.popitupinbox { width:90%;float:left; }
                                                input.popitupbox { width:80%;float:left; }
                                                a.popitupicon { float:left; }
                                                a.popitupicon i{ font-size: 27px; padding-top: 5px; margin-left: 5px; }
                                            </style>
                                            <div class="form-group choose-row">
                                                <div class="row" style="margin-bottom:10px;">
                                                    <div class="col-lg-10">
                                                        <input type="hidden" class="form-control" name="chooseId[0]">
                                                        <input type="text" class="form-control popitupinbox" name="chooseques0" id="chooseques0" placeholder="Question" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('chooseques0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
													<div class="col-lg-1">
                                                    </div>
													<div class="col-lg-1">
                                                        <button type="button" class="btn btn-info add-choose" title="Add More">+</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control popitupbox" name="optiona0" id="optiona0" placeholder="Option A" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optiona0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control popitupbox" name="optionb0" id="optionb0" placeholder="Option B" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optionb0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control popitupbox" name="optionc0" id="optionc0" placeholder="Option C" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optionc0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="form-control popitupbox" name="optiond0" id="optiond0" placeholder="Option D" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optiond0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
													<div class="col-lg-2">
                                                        <input type="text" class="form-control popitupbox" name="optione0" id="optione0" placeholder="Option E" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optione0')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label style="float: right;">Ans:</label>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <select class="form-control" name="chooseans0" required>
															<option value="">Answer</option>
															<option value="A">A</option>
															<option value="B">B</option>
															<option value="C">C</option>
															<option value="D">D</option>
															<option value="D">E</option>
														</select>	
                                                    </div>
                                                    
                                                </div>
                                                </br>
                                            </div>
                                        </div>

   
  
                                         <script> 

                                            $(function(){
                                                var counter = 1;
                                                $('.add-choose').click(function(event){
                                                    event.preventDefault();

                                                    var newRow = $('<div class="row" style="margin-bottom:10px;"> <div class="col-lg-10"> <input type="hidden" class="form-control" name="chooseId['+
                                                    counter + ']" /><input type="text" class="form-control popitupinbox" placeholder="Question" name="chooseques' +
                                                    counter + '" id="chooseques' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'chooseques' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> </div> <div class="row"><div class="col-lg-2"> <input type="text" class="form-control popitupbox" placeholder="Option A" name="optiona' +
                                                    counter + '" id="optiona' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'optiona' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> <div class="col-lg-2"> <input type="text" class="form-control popitupbox" placeholder="Option B" name="optionb' +
                                                    counter + '" id="optionb' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'optionb' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> <div class="col-lg-2"> <input type="text" class="form-control popitupbox" placeholder="Option C" name="optionc' +
                                                    counter + '" id="optionc' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'optionc' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> <div class="col-lg-2"> <input type="text" class="form-control popitupbox" placeholder="Option D" name="optiond' +
													counter + '" id="optiond' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'optiond' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> <div class="col-lg-2"> <input type="text" class="form-control popitupbox" placeholder="Option E" name="optione' +
                                                    counter + '" id="optione' + counter + '" /><a href="javascript:void(0);" class="popitupicon" onclick="return popitup(\'optione' + counter + '\')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a> </div> <div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> <div class="col-lg-1"> <select class="form-control" name="chooseans' +
                                                    counter + '" required><option value="">Answer</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option></select></div> </div> </br>');
                                                    counter++;
													
                                                    $('.choose-row').append(newRow);
                                                });
                                            });
 
                                        </script>

                                        <div class="form-group">
                                            <div class="col-lg-2">
                                                <input type="submit" value="OK" class="btn btn-info form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

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
</body>
</html>

<script>
    $(function() {
        $('#classId').change(function() {
            $('#subjectId').empty();
            $.get('subjectscript.php', {cid: $(this).val()}, function(result){
                var sublist = "<option value=''>Select Subject</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.subname + "'>" + item.subname + "</option>";
                });
                $("#subjectId").html(sublist);
            });
        });
    });
</script>

<script>
    $(function() {
        $('#term').change(function() {
            var clsId = $('#classId').val();
            var sub = $('#subjectId').val();
            var term = $('#term').val();
            $('#chapter').empty();
            $.get('ajaxchapter.php', {cid: clsId, sub: sub, term: term}, function(result){
                var sublist = "<option value=''>Select Chapter</option>";
                $.each(JSON.parse(result), function(i,item) {
                    sublist = sublist + "<option value='" + item.chaptername + "'>" + item.chaptername + "</option>";
                });
                $("#chapter").html(sublist);
            });
        });
    });
</script>

<script>
    /*$(function() {
     $('#questionType').change(function() {
     var qtype = $('#questionType').val();
     //alert(qtype);
     if(qtype == 'Other'){
     $('#othertype').show();
     }
     else{
     $('#othertype').hide();
     }

     $.ajax({
     url: "ajax-questions.php?qtype=" + qtype,
     context: document.body
     }).done(function(response) {
     $('#questions').html(response);
     });
     });
     });*/
</script>

<script language="javascript" type="text/javascript">

function popitup(urlvalue) {
var url = "/fullcanvas/canvas-index.php?urlvalue="+urlvalue;
newwindow=window.open(url,'name',"_blank","height=200,width=400, status=yes,toolbar=no,menubar=no,location=no");
if (window.focus) { newwindow.focus(); }
return false;
}


</script>
