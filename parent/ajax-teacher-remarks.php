<?php session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
if (isset($_GET['dat'])){
    $date = $_GET['dat'];
}
else{
    $date = date("Y-m-d");
}


// Finds extensions of files
function findexts($filename) {
	$filename=strtolower($filename);
	$exts=split("[/\\.]", $filename);
	$n=count($exts)-1;
	$exts=$exts[$n];
	
	$file_ext = $exts;
	$file_ext_value = "image.png";
	
	if($file_ext=="png" || $file_ext=="jpg" || $file_ext=="jpeg" || $file_ext=="bmp" || $file_ext=="tif" || $file_ext=="gif")
	{ $file_ext_value = "image.png"; }

	if($file_ext=="doc" || $file_ext=="docx" || $file_ext=="txt")
	{ $file_ext_value = "word.png"; }

	if($file_ext=="pdf")
	{ $file_ext_value = "pdf.png"; }

	if($file_ext=="ppt" || $file_ext=="pptx")
	{ $file_ext_value = "ppt.png"; }

	if($file_ext=="xls" || $file_ext=="xlsx")
	{ $file_ext_value = "excell.png"; }

	if($file_ext=="mov" || $file_ext=="mp4" || $file_ext=="3gp" || $file_ext=="wmv" || $file_ext=="flv" || $file_ext=="avi")
	{ $file_ext_value = "video.png"; }

	if($file_ext=="mp3" || $file_ext=="wav" || $file_ext=="wma")
	{ $file_ext_value = "voice.png"; }

	return $file_ext_value;
}


$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];
$classTeacher = $className . " " . $sectionName;

$teacher_sql = "select aca.* from teacher_academic as aca
Left JOIN users as usr on usr.id = aca.user_id
where delete_status='1' and class_teacher='$classTeacher'";
$teacher_exe = mysql_query($teacher_sql);
$teacher_fet = mysql_fetch_assoc($teacher_exe);
$teacherId = $teacher_fet['user_id'];

$remark_sql = "select re.*, tgen.teacher_name from teacher_remarks as re
LEFT JOIN teacher_general as tgen on tgen.user_id = re.teacher_id
where (re.student_id = '$user_id' or (re.student_id = 'all' and tgen.user_id='$teacherId')) and remarks_date='$date' and remarks_status='1'";
$remark_exe = mysql_query($remark_sql);
?>

<table class="table datatable">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>TEACHER NAME</th>
        <th>TITLE</th>
        <th>DETAILS</th>
        <th>ATTACHMENT</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $i =1;
    while($remark_fet=mysql_fetch_array($remark_exe))
    {
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $remark_fet['teacher_name']; ?></td>
            <td><?php echo $remark_fet['title']; ?></td>
            <td><?php echo $remark_fet['remark_details']; ?></td>
            <td>
				<?php if($remark_fet['remark_filepath']) {
				$file_ext_value = findexts($remark_fet['remark_filepath']);	
				?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
				<a href="<?php echo '../teacher/' . $remark_fet['remark_filepath']; ?>" download> <i class="fa fa-microphone"></i> </a>
				<?php } ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>