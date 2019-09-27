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


$remark_sql = "select info.*, gen.student_name from information_teacher as info
LEFT JOIN student_general as gen on gen.user_id = info.student_id
where remarks_date='$date' and remarks_status='1'";
$remark_exe = mysql_query($remark_sql);
?>

<table class="table datatable">
    <thead>
    <tr>
        <th>S.No.</th>
        <th>STUDENT NAME</th>
        <th>TEACHER NAME</th>
        <th>TITLE</th>
        <th>DETAILS</th>
        <th style="text-align: center;">ATTACHMENT</th>
        <th>ACTION</th>
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
            <td>
                <?php echo $remark_fet['student_name'];?>
            </td>
            <td><?php echo $remark_fet['teacher_name']; ?></td>
            <td><?php echo $remark_fet['title']; ?></td>
            <td><?php echo $remark_fet['remark_details']; ?></td>
            <td style="text-align: center;">
                <?php
                if($remark_fet['remark_filepath'])
                {
                    $file_ext_value = findexts($remark_fet['remark_filepath']);
                    ?>
                    <a href="javascript:void(0);" data-href="<?php echo '../parent/' . $remark_fet['remark_filepath']; ?>" class="openPopup">
                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo '../parent/' . $remark_fet['remark_filepath']; ?>" target="_blank"> <i class="fa fa-microphone"></i> </a>
                <?php } ?>
            </td>
            <td>
                <?php
                if($remark_fet['admin_status'] == 1){
                    ?>
                    <div class='row'>
                        <button class="form-control btn btn-info">SENT</button>
                    </div>
                <?php
                }
                else if($remark_fet['admin_status'] == 2){
                    ?>
                    <div class='row'>
                        <button class="form-control btn btn-primary">BLOCKED</button>
                    </div>
                <?php
                }
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>