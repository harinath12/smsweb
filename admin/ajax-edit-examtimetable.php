<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['id'])){
    $examid = $_GET['id'];
}
else
{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_sql="SELECT * FROM classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

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

for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
    if (date('N', strtotime($i)) <= 6) {
        $examdate[] = $i;
    }
}
$examdate_cnt = count($examdate);
?>
<div class="panel-body">
    <h4><b>Edit Exam Time Table</b></h4>
    <form action="doeditexamtimetable.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Exam</label>
                        <div class="col-lg-8">
                            <input type="text" name="editexamname" class="form-control" value="<?php echo $exam_fet['exam_name']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-4">Class</label>
                    <div class="col-lg-8">
                        <select class="form-control className" name="editclassName[]" id="className" multiple>
                            <option value="">Select Class</option>
                            <option value="100" <?php for($c =0; $c<$class_cnt; $c++){if($class_id[$c] == '100'){echo 'selected'; }}?>>All</option>
                            <?php
                            foreach($class_results as $key => $value){ ?>
                                <option value="<?php echo $value['id']; ?>" <?php for($c =0; $c<$class_cnt; $c++){if($class_id[$c] == $value['id']){echo 'selected'; }}?>><?php echo $value['class_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">Start Date</label>
                        <div class="col-lg-8">
                            <input type="text" name="editstartdate" class="form-control" value="<?php echo $exam_fet['start_date']; ?>" id="editstartdate"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="control-label col-lg-4">End Date</label>
                        <div class="col-lg-8">
                            <input type="text" name="editenddate" class="form-control" value="<?php echo $exam_fet['end_date']; ?>" id="editenddate"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="edittimetableentry" style="overflow-x: scroll;padding: 0px 10px;margin: 0px 20px;">
            <div class="row">
                <table class="table table-bordered" style="overflow: scroll;">
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
                                    <?php $sub_fet = mysql_fetch_assoc(mysql_query("select subject_name from exam_date_subject where exam_id='$examid' and exam_date='$examdate[$z]' and class_id='$class_id[$j]'"));
                                    ?>
                                    <input type="text" name="<?php echo 'subject'.$j.$z;?>" value="<?php echo $sub_fet['subject_name']; ?>"/>
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

            <div class="row">
                <div class="form-group">
                    <div class="col-lg-2">
                        <input type="submit" value="SAVE" class="btn btn-info form-control"/>
                    </div>
                </div>
            </div>

        </div>


    </form>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#editstartdate").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
    $( function() {
        $( "#editenddate").datepicker({
            dateFormat:'dd-mm-yy',
            minDate: 'today'
        });
    } );
</script>

<script>
    $( function() {
        $( "#editenddate").on( "change", function() {
            var className = $('#editclassName').val();
            var startdate = $('#editstartdate').val();
            var enddate = $('#editenddate').val();\
            $.ajax({
                url: "ajax-edit-exam-subject.php?startdate=" + startdate + "&enddate=" + enddate + "&classes=" + className,
                context: document.body
            }).done(function(response) {
                $('#edittimetableentry').html(response);
            });
        });
    } );
</script>
