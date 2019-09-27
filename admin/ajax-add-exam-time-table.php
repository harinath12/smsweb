<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['startdate'])){
    $startdate = $_GET['startdate'];
    if (isset($_GET['enddate'])){
        $enddate = $_GET['enddate'];
        if (isset($_GET['classes'])){
            $classes = $_GET['classes'];
        }
        else{
            exit;
        }
    }
    else{
        exit;
    }
}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$class_id = explode(',',$classes);
$class_cnt = count($class_id);

if($class_cnt == 1){
    if($class_id[0] == 100){
        $class_cnt = 15;
        for($i = 0; $i<15; $i++){
            $class_id[$i] = $i + 1;
        }
    }
}

function dateDiff ($d1, $d2) {

    // Return the number of days between the two dates:    
    return round(abs(strtotime($d1) - strtotime($d2))/86400);

}

$days_cnt=dateDiff ($startdate, $enddate);

/* 
for($i = 0; $i <= $days_cnt; $i++) {
$d=date('d-m-Y', strtotime($startdate . ' + '.$i.' days'));	
if (date('N', strtotime($d)) <= 6) {
    $examdate[] = $d;
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


/*
for($i = $startdate; $i <= $enddate; $i = date('d-m-Y', strtotime($i . ' + 1 days'))) {
if (date('N', strtotime($i)) <= 6) {
    $examdate[] = $i;
}
}
$examdate_cnt = count($examdate);
*/

/*
function dateDiff ($d1, $d2) {

    // Return the number of days between the two dates:    
    return round(abs(strtotime($d1) - strtotime($d2))/86400);

}

$examdate_cnt=dateDiff ($startdate, $enddate);

print_r($examdate);
*/
?>
<?php
$ww =  $examdate_cnt*200;
?>
<div class="row"  style="overflow: scroll;">
    <table id="exam-table" class="tableX" style="overflow: scroll;<?php echo "width:".$ww."px;"; ?>">
        <tr>
            <th style="width:150px !!important;">Class/Dates</th>
            <?php
            for($z = 0; $z < $examdate_cnt; $z++) {
                ?>
            <th style="width:150px !!important;;"><?php echo $examdate[$z]; ?></th>
            <?php
            }
            ?>
        </tr>
        <?php
        for($j=0; $j<$class_cnt; $j++) {
          ?>
            <tr>
                <td><?php
                    if($class_id[$j] == '100'){
                        echo 'All';
                    }
                    else{
                        $class_sql = mysql_query("select class_name from classes where id=$class_id[$j]");
                        $class_fet = mysql_fetch_assoc($class_sql);
                        echo $class_fet['class_name'];
                    }
                    ?></td>
                <?php
                if($class_id[$j] == '100'){
                    $sub_sql = mysql_query("select distinct subject_name from class_subject where class_subject_status=1 order by subject_name ASC");
                    $sub_results = array();
                    while($row = mysql_fetch_assoc($sub_sql)) {
                        array_push($sub_results, $row);
                    }
                }
                else{
                    $sub_sql = mysql_query("select distinct subject_name from class_subject where class_subject_status=1 and class_id=$class_id[$j] order by subject_name ASC");
                    $sub_results = array();
                    while($row = mysql_fetch_assoc($sub_sql)) {
                        array_push($sub_results, $row);
                    }
                }
                for($z = 0; $z < $examdate_cnt; $z++) {
                    ?>
                    <td>
                        <?php /* ?>
 <input type="text" name="<?php echo 'subject'.$j.$z;?>"/>
 <?php */ ?>
                        <select class="form-control" name="<?php echo 'subject'.$j.$z;?>">
                            <option value="">Select Subject</option>
                            <?php
                            foreach($sub_results as $key => $value){
                                ?>
                                <option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        &nbsp;&nbsp;

                        <input type="radio" name="<?php echo 'session'.$j.$z;?>" value="FN" checked/> FN &nbsp;&nbsp;
                        <input type="radio" name="<?php echo 'session'.$j.$z;?>" value="AN"/> AN

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