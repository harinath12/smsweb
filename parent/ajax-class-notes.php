<?php session_start();
ob_start();

include "config.php";

if (isset($_GET['dat'])){
    $date = $_GET['dat'];
}
else{
    $date = date("Y-m-d");
}
$user_id=$_SESSION['adminuserid'];


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
?>


<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
        <th>8</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td>
            <?php
            $fet1 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='I' and date='$date'"));
            echo $fet1['subject'] . " " . $fet1['description'];
            if($fet1['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet1['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet1['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet1['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet2 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='II' and date='$date'"));
            echo $fet2['subject'] . " " . $fet2['description'];
            if($fet2['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet2['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet2['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet2['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet3 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='III' and date='$date'"));
            echo $fet3['subject'] . " " . $fet3['description'];
            if($fet3['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet3['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet3['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet3['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet4 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='IV' and date='$date'"));
            echo $fet4['subject'] . " " . $fet4['description'];
            if($fet4['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet4['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet4['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet4['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet5 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='V' and date='$date'"));
            echo $fet5['subject'] . " " . $fet5['description'];
            if($fet5['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet5['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet5['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet5['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet6 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VI' and date='$date'"));
            echo $fet6['subject'] . " " . $fet6['description'];
            if($fet6['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet6['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet6['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet6['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet7 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VII' and date='$date'"));
            echo $fet7['subject'] . " " . $fet7['description'];
            if($fet7['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet7['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet7['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet7['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
        <td>
            <?php
            $fet8 = mysql_fetch_assoc(mysql_query("select * from class_notes where class='$className' and section='$sectionName' and period='VIII' and date='$date'"));
            echo $fet8['subject'] . " " . $fet8['description'];
            if($fet8['class_notes_file_path'])
            {
				$file_ext_value = findexts($fet8['class_notes_file_path']);	
                ?>
				<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet8['class_notes_file_path']; ?>" class="openPopup">
				<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
				</a>
				&nbsp;&nbsp;&nbsp; 
                <a href="<?php echo '../teacher/' . $fet8['class_notes_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
            <?php
            }
            ?>
        </td>
    </tr>

    </tbody>

</table>


