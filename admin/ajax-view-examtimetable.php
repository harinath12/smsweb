<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['id'])){
    $examid = $_GET['id'];
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$exam_sql="SELECT * FROM `exam_time_table` where id='$examid'";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);

$exam_class_sql = "SELECT DISTINCT class_id FROM `exam_date_subject` where exam_id='$examid'";
$exam_class_exe = mysql_query($exam_class_sql);
$exam_class_cnt = mysql_num_rows($exam_class_exe);
while($exam_class_fet = mysql_fetch_assoc($exam_class_exe)){
    $class_id[] = $exam_class_fet['class_id'];
}
$class_cnt = count($class_id);

$startdate = $exam_fet['start_date'];
$enddate = $exam_fet['end_date'];

/*
for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
*/


$start = strtotime($startdate);
$end = strtotime($enddate);
$days_between = ceil(abs($end - $start) / 86400);
for($i=0;$i <= $days_between; $i++)
{
	$si = date('d-m-Y', strtotime($startdate . ' + '.$i.' days'));
	
	if (date('N', strtotime($si)) <= 6) {
        $examdate[] = $si;
    }
	
}

$examdate_cnt = count($examdate);
?>
<?php
$ww =  $examdate_cnt*200;
?>
<div class="panel-body" style="margin:15px; border: 1px grey dotted;">
    <h4><b>View Exam Time Table</b></h4>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Exam</label>
                        <div class="col-lg-8">
                            <?php echo $exam_fet['exam_name']; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Start Date</label>
                        <div class="col-lg-8">
                            <?php echo $exam_fet['start_date']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">End Date</label>
                        <div class="col-lg-8">
                            <?php echo $exam_fet['end_date']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		
		 <div style="overflow-x: scroll;padding: 0px 10px;margin: 0px 20px;">
            <div class="row">


        <table class="table table-bordered" style="overflow: scroll;<?php echo "width:".$ww."px;"; ?>">
            <tr>
                <th>Class/Dates</th>
                <?php
                for($z = 0; $z < $examdate_cnt; $z++) {
                    ?>
                    <th><?php echo $examdate[$z]; ?></th>
                <?php
                }
                ?>
            </tr>
            <?php
            for($j=0; $j<$class_cnt; $j++) {
                ?>
                <tr>
                    <td>
                        <?php
                        if($class_id[$j] == '100'){
                            echo 'All';
                        }
                        else{
                            $class_fet = mysql_fetch_assoc(mysql_query("Select class_name from classes where id=$class_id[$j]"));
                            echo $class_fet['class_name'];
                        }
                        ?>
                    </td>
                    <?php
                    for($z = 0; $z < $examdate_cnt; $z++) {
                        ?>
                        <td>
                            <?php $sub_fet = mysql_fetch_assoc(mysql_query("select subject_name, exam_session, syllabus from exam_date_subject where exam_id='$examid' and exam_date='$examdate[$z]' and class_id='$class_id[$j]'"));
                            echo $sub_fet['subject_name'] . ' - ' . $sub_fet['exam_session'];
                            if(!empty($sub_fet['syllabus'])){
                                echo '</br><b>Syllabus: </b>' . $sub_fet['syllabus'];
                            }
                            ?>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>

        </table>
    
			</div>
		</div>
			
	</form>
</div>