<?php session_start();
ob_start();

include "config.php";
if ((isset($_GET['sectionName'])) && (isset($_GET['className']))){

print_r($_GET);

}
else{
    exit;
}

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$sectionName = $_GET['sectionName'];
$className = $_GET['className'];


$class_sql = mysql_query("SELECT `id` FROM `classes` WHERE `class_name`='$className'");
$class_fet = mysql_fetch_assoc($class_sql);
$class_id = $class_fet['id'];


$sub_sql = mysql_query("select distinct subject_name from class_subject where class_subject_status=1 and class_id=$class_id order by subject_name ASC");
$sub_results = array();
while($row = mysql_fetch_assoc($sub_sql)) {
array_push($sub_results, $row);
}
?>
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
				<select class="form-control" name="day_1_1" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_2" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_3" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_4" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_5" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_6" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_7" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_1_8" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
		<tr>
		<tr>
				<td class="head">Tuesday</td>
				<td>
				<select class="form-control" name="day_2_1" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_2" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_3" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_4" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_5" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_6" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_7" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_2_8" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
		<tr>
		<tr>
				<td class="head">Wednesday</td>
				<td>
				<select class="form-control" name="day_3_1" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_2" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_3" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_4" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_5" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_6" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_7" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_3_8" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
		<tr>
		<tr>
				<td class="head">Thursday</td>
				<td>
				<select class="form-control" name="day_4_1" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_2" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_3" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_4" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_5" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_6" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_7" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_4_8" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
		<tr>
		<tr>
				<td class="head">Friday</td>
				<td>
				<select class="form-control" name="day_5_1" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_2" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_3" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_4" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_5" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_6" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_7" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select class="form-control" name="day_5_8" required >
				<option value="">Choose</option>
				<?php
				foreach($sub_results as $key => $value){
					?>
					<option value="<?php echo $value['subject_name']; ?>"><?php echo ucwords($value['subject_name']); ?></option>
				<?php
				}
				?>
				</select>
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

<div class="row">
    <div class="form-group">
        <div class="col-lg-2">
            <input type="submit" value="SAVE" class="btn btn-info form-control"/>
        </div>
    </div>
</div>