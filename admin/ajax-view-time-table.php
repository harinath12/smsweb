<?php session_start();
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

/*
print_r($_REQUEST);
*/

$exam_sql="SELECT * FROM `time_table` where id='$examid'";
$exam_exe=mysql_query($exam_sql);
$exam_fet = mysql_fetch_assoc($exam_exe);
?>
<div class="panel-body" style="margin:15px; border: 1px grey dotted;">
    <h4><b>View Time Table # <span style="color:#02d502;" ><?php echo $exam_fet['class']; ?> <?php echo $exam_fet['section']; ?></span></b></h4>
   
   
   
<style>
	table thead tr td { font-weight:bold; }
	table tfoot tr td { font-weight:bold; }
	table tbody tr td.head { font-weight:bold; }
</style>
<div class="row"  style="overflow: scroll;">
    <table id="time-table" class="table">
	<thead>
		<tr>
				<td>Day</td>
				<td>Period I</td>
				<td>Period II</td>
				<td>Period III</td>
				<td>Period IV</td>
				<td>Period V</td>
				<td>Period VI</td>
				<td>Period VII</td>
				<td>Period VIII</td>
		<tr>
	</thead>
	<tbody>
		<tr>
				<td class="head">Monday</td>
				<td>
				<?php echo $exam_fet['day_1_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_1_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Tuesday</td>
				<td>
				<?php echo $exam_fet['day_2_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_2_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Wednesday</td>
				<td>
				<?php echo $exam_fet['day_3_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_3_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Thursday</td>
				<td>
				<?php echo $exam_fet['day_4_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_4_8']; ?>
				</td>
		<tr>
		<tr>
				<td class="head">Friday</td>
				<td>
				<?php echo $exam_fet['day_5_1']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_2']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_3']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_4']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_5']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_6']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_7']; ?>
				</td>
				<td>
				<?php echo $exam_fet['day_5_8']; ?>
				</td>
		<tr>

	
	<tbody>
	<tfoot>
		<tr>
				<td>Day</td>
				<td>Period I</td>
				<td>Period II</td>
				<td>Period III</td>
				<td>Period IV</td>
				<td>Period V</td>
				<td>Period VI</td>
				<td>Period VII</td>
				<td>Period VIII</td>
				
		<tr>
	</tfoot>
    </table>
</div>

</div>