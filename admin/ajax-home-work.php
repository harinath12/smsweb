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


$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}

/* $section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
} */
?>

<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th class="brd">Class</th>
        <th class="brd">1</th>
        <th class="brd">2</th>
        <th class="brd">3</th>
        <th class="brd">4</th>
        <th class="brd">5</th>
        <th class="brd">6</th>
        <th class="brd">7</th>
        <th>8</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($class_master_results as $key => $value){
        $className = $value['class_name'];
        $classId = $value['id'];

        $section_sql="SELECT cs.* FROM `class_section` as cs  where cs.class_section_status=1 and cs.class_id='$classId'";
        $section_exe=mysql_query($section_sql);
        $section_results = array();
        while($row = mysql_fetch_assoc($section_exe)) {
            array_push($section_results, $row);
        }

        foreach ($section_results as $sec_key => $sec_value) {
            $sectionName = $sec_value['section_name'];
            ?>
            <tr>
                <td class="brd"><?php echo $className . " " . $sectionName; ?></td>
                <td class="brd">
                    <?php
                    $fet1 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='I' and date='$date'"));
                    echo $fet1['subject'] . " " . $fet1['description'];
                    if($fet1['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet1['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 

					<a href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet1['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet1['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet2 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='II' and date='$date'"));
                    echo $fet2['subject'] . " " . $fet2['description'];
                    if($fet2['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet2['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 

                        <a href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet2['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet2['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet3 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='III' and date='$date'"));
                    echo $fet3['subject'] . " " . $fet3['description'];
                    if($fet3['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet3['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 

					<a href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet3['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet3['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet4 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='IV' and date='$date'"));
                    echo $fet4['subject'] . " " . $fet4['description'];
                    if($fet4['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet4['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet4['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet4['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet5 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='V' and date='$date'"));
                    echo $fet5['subject'] . " " . $fet5['description'];
                    if($fet5['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet5['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet5['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet5['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet6 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VI' and date='$date'"));
                    echo $fet6['subject'] . " " . $fet6['description'];
                    if($fet6['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet6['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
                    <a href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet6['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet6['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td class="brd">
                    <?php
                    $fet7 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VII' and date='$date'"));
                    echo $fet7['subject'] . " " . $fet7['description'];
                    if($fet7['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet7['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet7['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet7['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
                <td>
                    <?php
                    $fet8 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VIII' and date='$date'"));
                    echo $fet8['subject'] . " " . $fet8['description'];
                    if($fet8['home_work_file_path'])
                    {
					$file_ext_value = findexts($fet8['home_work_file_path']);	
					?>
					<a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>" class="openPopup">
					<img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
					</a>
					&nbsp;&nbsp;&nbsp; 
					<a href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>" target="_blank" title="download"><i class="fa fa-download"></i></a>
                    <?php
                    }
                    ?>
					<?php 
					if($fet8['home_work_test_names']!="") 
					{ 
					$test_array=explode(",",$fet8['home_work_test_names']); 
						foreach($test_array as $test_id) {
					?>   
						<a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
						<button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Preview</button>
						</a>&nbsp;&nbsp;&nbsp;  												
					<?php 
						}
					} 
					?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>

</table>