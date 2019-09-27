<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}
 
if(isset($_REQUEST['chapter']))
{
$chapter_array = $_REQUEST['chapter'];
$questionbank_id = implode(",", $chapter_array);
}
else
{
	header("Location: create-aptitude-test.php?error=1");
}	
include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

/*
$questionbank_id = $_REQUEST['question_id'];

$ques_bank_sql = mysql_query("select qb.*, c.class_name from question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id='$questionbank_id'");
*/

$ques_bank_sql = mysql_query("select qb.*, c.class_name from aptitude_question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id IN ($questionbank_id)");


$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);

$ques_bank_chapter_name = "";
$ques_bank_chapter_sql = mysql_query("select qb.*, c.class_name from aptitude_question_bank as qb
left join classes as c on c.id = qb.class_id
where qb.id IN ($questionbank_id)");
while($ques_bank_chapter_fet = mysql_fetch_assoc($ques_bank_chapter_sql))
{
		$ques_bank_chapter_name .= $ques_bank_chapter_fet['chapter'].',';
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
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="aptitude-test.php">Test</a></li>
						<li><a href="create-aptitude-test.php">Create Aptitude Test</a></li>
                        <li class="active">Aptitude Test View</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="panel panel-flat">
                        <div class="panel-body">
							<form action="do-aptitude-test.php" method="POST" >
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Class</label>
                                        <div class="col-md-8">
											<input type="text" name="class_name" value="<?php echo $ques_bank_fet['class_name']; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Subject</label>
                                        <div class="col-md-8">
                                            <input type="text" name="subject_name" value="<?php echo $ques_bank_fet['subject_name']; ?>" class="form-control" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-md-4">Test Name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_name" value="<?php echo $ques_bank_fet['class_name']; ?>-<?php echo $ques_bank_fet['subject_name']; ?>-<?php echo date("Y-m-d"); ?>" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4">Remarks</label>
                                        <div class="col-md-8">
                                            <input type="text" name="daily_test_remark" value="<?php echo $ques_bank_chapter_name; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
								
								
                            </div>

 
                            <?php
                            $ques_sql=mysql_query("SELECT * FROM `aptitude_question_answer` where question_bank_id IN ($questionbank_id) and question_type='Choose'");
                            $ques_cnt = mysql_num_rows($ques_sql);
                            if($ques_cnt> 0){
                                $m = 1;
                                ?>
                                <h6><b>Choose</b>  <input type="checkbox" onClick="toggle(this,'choose')" /> Check All / Uncheck All<br/> </h6>
                                <?php
								$chapter="";
                                while($choose_fet = mysql_fetch_assoc($ques_sql)){
                                    ?>
									<?php
									$bank_id=$choose_fet['question_bank_id'];
									$chap_sql=mysql_query("SELECT * FROM `question_bank` where id=$bank_id");
									$chap_fet=mysql_fetch_assoc($chap_sql);
									
									if($chapter!=$chap_fet['chapter'])
									{
									$chapter=$chap_fet['chapter'];	
									echo "<strong>".$chapter."</strong>";
									}
									?>
                                    <div class="row" style="margin-left: 20px;">
                                        <input class="choose" type="checkbox" name="questions[]" value="<?php echo $choose_fet['id']; ?>" />
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php
                                        $mean_ques = $choose_fet['question'];
                                        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond']. " E) " . $choose_fet['optione'];
                                        $mean_ans = $choose_fet['answer'];
                                        echo $m . ') ' . $mean_ques . '<br>' . $mean_opt . '<br> <b>Ans:</b> ' . $mean_ans;
                                        ?>
									</div>
                                    <?php
                                    $m++;
                                }
                            }
                            ?>
 
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <input type="hidden" name="class_id" value="<?php echo $ques_bank_fet['class_id']; ?>" />
											<input type="hidden" name="questionbank_id" value="<?php echo $questionbank_id; ?>" />
											<button type="submit" class="form-control btn btn-info" name="submit">Generate</button>
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
<script language="JavaScript">
function toggle(source,classname) {
  checkboxes = document.getElementsByClassName(classname);
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<script type='text/javascript'>
/*
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
                        width: '20%',
                        targets: 0
                    },
                    {
                        width: '40%',
                        targets:[ 1,2]
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
                displayLength: 10
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
	*/
</script>
</html>
