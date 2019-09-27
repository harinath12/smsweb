<?php session_start();
ob_start();

include "config.php";

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


$circu_sql="SELECT * FROM `circular` where circular_date='$date' and circular_status=1 order by circular_date DESC ";
$circu_exe=mysql_query($circu_sql);
$circu_cnt=@mysql_num_rows($circu_exe);
?>

<table id="example2" class="table datatable">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>Date</th>
        <th>Title</th>
        <th>Circular To</th>
        <th>Description</th>
		<th>Attachment</th>
        <th class="text-center">ACTIONS</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i =1;
    while($circu_fet=mysql_fetch_array($circu_exe))
    {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $circu_fet['circular_date'] ?></td>
            <td><?php echo $circu_fet['circular_title']; ?></td>
            <td><?php echo $circu_fet['circular_to'] ?></td>
            <td><?php echo $circu_fet['circular_message']; ?></td>
			<td>
			<?php
				if($circu_fet['circular_file_path'])
				{
					
						
					$file_ext_value = findexts($circu_fet['circular_file_path']);	
					?>
						<a href="javascript:void(0);" data-href="<?php echo '../admin/' . $circu_fet['circular_file_path']; ?>" class="openPopup">
						<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
						</a>
						&nbsp;&nbsp;&nbsp; 
						
					<a href="<?php echo '../admin/' . $circu_fet['circular_file_path'];?>" download title="download">
						<i class="fa fa-download form-controlX"></i>
					</a>
				<?php
				}
				?>
			</td>
            <td class="text-center">
                <ul class="icons-list">
                    <li><a href="circular-view.php?circular_id=<?php echo $circu_fet['id']; ?>" title="view"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button></a></li>&nbsp;&nbsp;
                    <?php if($circu_fet['circular_date'] == $date) { ?>
                        <li><a href="circular-edit.php?circular_id=<?php echo $circu_fet['id']; ?>" title="edit"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></button></a></li>&nbsp;&nbsp;
                    <?php
                    }
                    else{
                        ?>
                        <li><button type="button" class="btn btn-info btn-xs" title="Only today's circular can be modified."><i class="fa fa-pencil"></i></button></li>&nbsp;&nbsp;
                    <?php
                    }
                    ?>
                </ul>
            </td>
        </tr>
        <?php
        $i++;
    }
    ?>
    </tbody>

</table>
