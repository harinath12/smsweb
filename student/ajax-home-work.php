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
                                            $exe1 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='I' and date='$date'");
                                            while($fet1 = mysql_fetch_assoc($exe1)) {
                                                echo $fet1['subject'] . " " . $fet1['description'];
                                                if ($fet1['home_work_file_path']) {

                                                    $file_ext = findexts($fet1['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet1['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet1['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe2 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='II' and date='$date'");
                                            while($fet2 = mysql_fetch_assoc($exe2)) {
                                                echo $fet2['subject'] . " " . $fet2['description'];
                                                if ($fet2['home_work_file_path']) {

                                                    $file_ext = findexts($fet2['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet2['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet2['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe3 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='III' and date='$date'");
                                            while($fet3 = mysql_fetch_assoc($exe3)) {
                                                echo $fet3['subject'] . " " . $fet3['description'];
                                                if ($fet3['home_work_file_path']) {

                                                    $file_ext = findexts($fet3['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet3['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet3['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe4 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='IV' and date='$date'");
                                            while($fet4 = mysql_fetch_assoc($exe4)) {
                                                echo $fet4['subject'] . " " . $fet4['description'];
                                                if ($fet4['home_work_file_path']) {

                                                    $file_ext = findexts($fet4['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet4['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet4['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe5 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='V' and date='$date'");
                                            while($fet5 = mysql_fetch_assoc($exe5)) {
                                                echo $fet5['subject'] . " " . $fet5['description'];
                                                if ($fet5['home_work_file_path']) {

                                                    $file_ext = findexts($fet5['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet5['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet5['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe6 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VI' and date='$date'");
                                            while($fet6 = mysql_fetch_assoc($exe6)) {
                                                echo $fet6['subject'] . " " . $fet6['description'];
                                                if ($fet6['home_work_file_path']) {

                                                    $file_ext = findexts($fet6['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet6['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet6['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe7 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VII' and date='$date'");
                                            while($fet7 = mysql_fetch_assoc($exe7)) {
                                                echo $fet7['subject'] . " " . $fet7['description'];
                                                if ($fet7['home_work_file_path']) {

                                                    $file_ext = findexts($fet7['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet7['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet7['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                        <td>
                                            <?php
                                            $exe8 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VIII' and date='$date'");
                                            while($fet8 = mysql_fetch_assoc($exe8)) {
                                                echo $fet8['subject'] . " " . $fet8['description'];
                                                if ($fet8['home_work_file_path']) {

                                                    $file_ext = findexts($fet8['home_work_file_path']);

                                                    if ($file_ext == "png" || $file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "bmp" || $file_ext == "tif" || $file_ext == "gif") {
                                                        $file_ext_value = "image.png";
                                                    }

                                                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "txt") {
                                                        $file_ext_value = "word.png";
                                                    }

                                                    if ($file_ext == "pdf") {
                                                        $file_ext_value = "pdf.png";
                                                    }

                                                    if ($file_ext == "ppt" || $file_ext == "pptx") {
                                                        $file_ext_value = "ppt.png";
                                                    }

                                                    if ($file_ext == "xls" || $file_ext == "xlsx") {
                                                        $file_ext_value = "excell.png";
                                                    }

                                                    if ($file_ext == "mov" || $file_ext == "mp4" || $file_ext == "3gp" || $file_ext == "wmv" || $file_ext == "flv" || $file_ext == "avi") {
                                                        $file_ext_value = "video.png";
                                                    }


                                                    if ($file_ext == "mp3" || $file_ext == "wav" || $file_ext == "wma") {
                                                        $file_ext_value = "voice.png";
                                                    }

                                                    ?>
                                                    <a href="javascript:void(0);"
                                                       data-href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>"
                                                       class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                             width="50px"/>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>"
                                                       target="_blank" title="download"><i
                                                            class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($fet8['home_work_test_names'] != "") {
                                                    $test_array = explode(",", $fet8['home_work_test_names']);
                                                    foreach ($test_array as $test_id) {
                                                        ?>
                                                        <a href="preview-daily-test.php?test_id=<?php echo $test_id; ?>">
                                                            <button type="button" class="btn btn-info btn-xs"><i
                                                                    class="fa fa-eye"></i> Preview
                                                            </button>
                                                        </a>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }
                                                }
                                                echo "</br>";
                                            }
											?>
                                        </td>
                                    </tr>
                                    
									
                                    </tbody>

                                </table>
                            