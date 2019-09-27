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

$questionbank_id = $_REQUEST['question_id'];

$ques_bank_sql = mysql_query("select qb.*, c.class_name from aptitude_question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id='$questionbank_id'");
$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);
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
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="aptitude-question-bank.php">Question Bank</a></li>
                <li class="active">Aptitude Question Bank View</li>
            </ol>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    
					
					
                            <form action="doupdateaptitudequestionbank.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="questionbankid" value="<?php echo $questionbank_id; ?>" />
                                <div class="row">
									<div class="col-md-4">
									
										<div class="form-group">
											<label class="col-md-4">Class</label>
											<div class="col-md-8">
												<input type="text" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly/>
											</div>
										</div>
									
									</div>
									<div class="col-md-4">
									
										<div class="form-group">
											<label class="col-md-4">Subject</label>
											<div class="col-md-8">
												<input type="text" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
											</div>
										</div>
									
									</div>
									<div class="col-md-4">
									
										<div class="form-group">
											<label class="col-md-4">Chapter</label>
											<div class="col-md-8">
												<input type="text" value="<?php echo $ques_bank_fet['chapter']; ?>" class="form-control" readonly/>
											</div>
										</div>
										
									</div>
								</div>

                                <style>
                                    input.popitupinbox { width:90%;float:left; }
                                    input.popitupbox { width:80%;float:left; }
                                    a.popitupicon { float:left; }
                                    a.popitupicon i{ font-size: 27px; padding-top: 5px; margin-left: 5px; }
                                </style>
                                <div class="row choose-row" style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><b>Choose</b></h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info add-choose" style="float:right; padding-right: 10px;" title="Add More">+</button>
                                        </div>
                                    </div>
                                    <?php
                                    $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where question_bank_id='$questionbank_id' and question_type='Choose'");
                                    $ques_cnt = mysql_num_rows($ques_sql);
                                    if($ques_cnt> 0){
                                        ?>
                                        <?php
                                        while($ques_fet = mysql_fetch_assoc($ques_sql)){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input type="hidden" class="form-control" name="choosequestionid[]" value="<?php echo $ques_fet['id']; ?>"/>
                                                    <input type="text" class="form-control popitupinbox" name="oldchooseques[]" id="chooseques<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['question']; ?>" placeholder="Question" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('chooseques<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control popitupbox" name="oldoptiona[]" id="optiona<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['optiona']; ?>" placeholder="Option A" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optiona<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control popitupbox" name="oldoptionb[]" id="optionb<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['optionb']; ?>" placeholder="Option B" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optionb<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control popitupbox" name="oldoptionc[]" id="optionc<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['optionc']; ?>" placeholder="Option C" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optionc<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control popitupbox" name="oldoptiond[]" id="optiond<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['optiond']; ?>" placeholder="Option D" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optiond<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control popitupbox" name="oldoptione[]" id="optione<?php echo $ques_fet['id']; ?>" value="<?php echo $ques_fet['optione']; ?>" placeholder="Option E" />
                                                        <a href="javascript:void(0);" class="popitupicon" onclick="return popitup('optione<?php echo $ques_fet['id']; ?>')" ><i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label style="float: right;">Ans:</label>
                                                </div>
												<div class="col-lg-1">
													<select class="form-control" name="oldchooseans[]" required>
														<option value="">Answer</option>
														<option value="A" <?php if($ques_fet['answer']=="A") { echo "selected"; } ?>>A</option>
														<option value="B" <?php if($ques_fet['answer']=="B") { echo "selected"; } ?>>B</option>
														<option value="C" <?php if($ques_fet['answer']=="C") { echo "selected"; } ?>>C</option>
														<option value="D" <?php if($ques_fet['answer']=="D") { echo "selected"; } ?>>D</option>
														<option value="E" <?php if($ques_fet['answer']=="E") { echo "selected"; } ?>>E</option>
													</select>	
												</div>
                                                
                                            </div>
                                        <?php
                                        }
                                    }
                                    else{ ?>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="chooseques[]" placeholder="Question"/>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optiona[]" placeholder="Option A"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optionb[]" placeholder="Option B"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optionc[]" placeholder="Option C"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optiond[]" placeholder="Option D"/>
                                        </div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" name="optione[]" placeholder="Option E"/>
                                        </div>
                                        <div class="col-lg-1">
                                        <label style="float: right;">Ans:</label>
                                        </div>
                                        <div class="col-lg-2">
											<select class="form-control" name="chooseans[]" required>
												<option value="">Answer</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="C">C</option>
												<option value="D">D</option>
												<option value="E">E</option>
											</select>	
										</div>
                                        </div>
                                        </br>
                                    <?php
                                    }
                                    ?>
                                </div>
 
								<div class="form-group">
                                    <div class="col-lg-2">
                                        <input type="submit" value="OK" class="btn btn-info form-control"/>
                                    </div>
                                </div>
                            </form>

							
  
                                        <script>
                                            
                                            $(function(){
                                                var counter = 1;
                                                $('.add-choose').click(function(event){
                                                    event.preventDefault();

                                                    var newRow = $('<div class="row" style="margin-bottom:10px;"> <div class="col-lg-10"> <input type="hidden" class="form-control" name="chooseId['+
                                                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="chooseques' +
                                                    counter + '"/> </div> </div> <div class="row"><div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option A" name="optiona' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option B" name="optionb' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option C" name="optionc' +
                                                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option D" name="optiond' +
													counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option E" name="optione' +
                                                    counter + '"/> </div> <div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> <div class="col-lg-1"> <select class="form-control" name="chooseans' +
                                                    counter + '" required><option value="">Answer</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option></select></div> </div> </br>');
                                                    counter++;
                                                    $('.choose-row').append(newRow);
                                                });
                                            });

                                            
                                        </script>
					
                </div>
            </div>
        </div>
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
<script type='text/javascript'>
    $(document).ready( function () {
        $('.datatable').DataTable({

        });
    } );
</script>

<script language="javascript" type="text/javascript">

function popitup(urlvalue) {
var url = "/fullcanvas/canvas-index.php?urlvalue="+urlvalue;
newwindow=window.open(url,'name',"_blank","height=200,width=400, status=yes,toolbar=no,menubar=no,location=no");
if (window.focus) { newwindow.focus(); }
return false;
}


</script>
</body>
</html>
