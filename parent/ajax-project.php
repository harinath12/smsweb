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

$proj_exe = mysql_query("select * from project where class='$className' and section='$sectionName' and date='$date'");
?>

<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>SUBJECT</th>
        <th>DESCRIPTION</th>
        <th>ATTACHMENT 1</th>
        <th>ATTACHMENT 2</th>
        <th>ATTACHMENT 3</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i =1;
        while($proj_fet=mysql_fetch_array($proj_exe))
        {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <?php echo $proj_fet['subject']; ?>
                </td>
                <td>
                    <?php echo $proj_fet['description']; ?>
                </td>
                <td>
				<?php
				if($proj_fet['project1'])
				{
					$file_ext_value = findexts($proj_fet['project1']);
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project1']; ?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $proj_fet['project1']; ?>" download> <i class="fa fa-download"></i> </a>
				<?php } ?>
			</td>
			<td>
				<?php
				if($proj_fet['project2'])
				{
					$file_ext_value = findexts($proj_fet['project2']);
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project2']; ?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $proj_fet['project2']; ?>" download> <i class="fa fa-download"></i> </a>
				<?php } ?>
			</td>
			<td>
				<?php
				if($proj_fet['project3'])
				{
					$file_ext_value = findexts($proj_fet['project3']);
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $proj_fet['project3']; ?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $proj_fet['project3']; ?>" download> <i class="fa fa-download"></i> </a>
				<?php } ?>
			</td>
            </tr>
        <?php
        }
     ?>
    </tbody>

</table>
