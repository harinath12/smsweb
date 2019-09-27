<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "config.php";

$user_id=$_SESSION['adminuserid'];
$user_role=$_SESSION['adminuserrole'];
$user_name=$_SESSION['adminusername'];
$user_email=$_SESSION['adminuseremail'];
$date = date("Y-m-d");


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
<!DOCTYPE html>
<html>
<head>
    <style>
        .brd{
            border-right: 1px solid grey;
        }

        th{
            text-align: center !important;
        }
    </style>
    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://resources/demos/style.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Home Work
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Home Work</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="home-work-add.php">
                                    <button type="button" class="form-control btn btn-info">Add Home Work</button>
                                </a>
                            </div>
                            <div class='col-sm-3' style="float: right">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id='datepicker' name="hwdate"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body" id="predate">
                            <?php /* ?>
                            <table id="example2" class="table datatable curdate">
                                <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Periods</th>
                                    <th>Home Work</th>
                                    <th>Attachment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                foreach($class_master_results as $key => $value){
                                    $className = $value['class_name'];
                                    $classId = $value['id'];

                                    $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
                                    $section_exe=mysql_query($section_sql);
                                    $section_results = array();
                                    while($row = mysql_fetch_assoc($section_exe)) {
                                        array_push($section_results, $row);
                                    }

                                    foreach ($section_results as $sec_key => $sec_value) {
                                        $sectionName = $sec_value['section_name'];
                                        ?>
                                        <tr>
                                            <td><?php echo $className . " " . $sectionName; ?></td>
                                            <td>I</td>
                                            <td>
                                                <?php
                                                $fet1 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='I' and date='$date'"));
                                                echo $fet1['subject'] . " " . $fet1['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet1['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet1['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>II</td>
                                            <td>
                                                <?php
                                                $fet2 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='II' and date='$date'"));
                                                echo $fet2['subject'] . " " . $fet2['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet2['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet2['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>III</td>
                                            <td>
                                                <?php
                                                $fet3 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='III' and date='$date'"));
                                                echo $fet3['subject'] . " " . $fet3['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet3['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet3['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>IV</td>
                                            <td>
                                                <?php
                                                $fet4 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='IV' and date='$date'"));
                                                echo $fet4['subject'] . " " . $fet4['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet4['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet4['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>V</td>
                                            <td>
                                                <?php
                                                $fet5 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='V' and date='$date'"));
                                                echo $fet5['subject'] . " " . $fet5['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet5['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet5['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>VI</td>
                                            <td>
                                                <?php
                                                $fet6 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VI' and date='$date'"));
                                                echo $fet6['subject'] . " " . $fet6['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet6['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet6['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>VII</td>
                                            <td>
                                                <?php
                                                $fet7 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VII' and date='$date'"));
                                                echo $fet7['subject'] . " " . $fet7['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet7['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet7['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>VIII</td>
                                            <td>
                                                <?php
                                                $fet8 = mysql_fetch_assoc(mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VIII' and date='$date'"));
                                                echo $fet8['subject'] . " " . $fet8['description'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if(isset($fet8['home_work_file_path'])) { ?>
                                                    <a href="<?php echo '../teacher/' . $fet8['home_work_file_path']; ?>" target="_blank"> <i class="fa fa-download"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php */ ?>


                            <table id="example2" class="datatable curdate">
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
                                            $exe1 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='I' and date='$date'");
                                            while($fet1 = mysql_fetch_assoc($exe1)){
                                                echo $fet1['subject'] . " " . $fet1['description'];
                                                if($fet1['home_work_file_path'])
                                                {
                                                    $file_ext_value = findexts($fet1['home_work_file_path']);
                                                    ?>
                                                    <a href="javascript:void(0);" data-href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>" class="openPopup">
                                                        <img src="assets/fileicons/<?php echo $file_ext_value; ?>" width="50px" />
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="<?php echo '../teacher/' . $fet1['home_work_file_path'];?>" download title="download"><i class="fa fa-download"></i></a>
                                                <?php
                                                }
                                                ?>
                                                <br/>
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
                                            }
                                            ?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe2 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='II' and date='$date'");
                                    while($fet2 = mysql_fetch_assoc($exe2)) {
                                        echo $fet2['subject'] . " " . $fet2['description'];
                                        if ($fet2['home_work_file_path']) {
                                            $file_ext_value = findexts($fet2['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet2['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe3 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='III' and date='$date'");
                                    while($fet3 = mysql_fetch_assoc($exe3)) {
                                        echo $fet3['subject'] . " " . $fet3['description'];
                                        if ($fet3['home_work_file_path']) {
                                            $file_ext_value = findexts($fet3['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet3['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe4 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='IV' and date='$date'");
                                    while($fet4 = mysql_fetch_assoc($exe4)) {
                                        echo $fet4['subject'] . " " . $fet4['description'];
                                        if ($fet4['home_work_file_path']) {
                                            $file_ext_value = findexts($fet4['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;

                                            <a href="<?php echo '../teacher/' . $fet4['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe5 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='V' and date='$date'");
                                    while($fet5 = mysql_fetch_assoc($exe5)) {
                                        echo $fet5['subject'] . " " . $fet5['description'];
                                        if ($fet5['home_work_file_path']) {
                                            $file_ext_value = findexts($fet5['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet5['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe6 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VI' and date='$date'");
                                    while($fet6 = mysql_fetch_assoc($exe6)) {
                                        echo $fet6['subject'] . " " . $fet6['description'];
                                        if ($fet6['home_work_file_path']) {
                                            $file_ext_value = findexts($fet6['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet6['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td class="brd">
                                            <?php
                                    $exe7 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VII' and date='$date'");
                                    while($fet7 = mysql_fetch_assoc($exe7)) {
                                        echo $fet7['subject'] . " " . $fet7['description'];
                                        if ($fet7['home_work_file_path']) {
                                            $file_ext_value = findexts($fet7['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet7['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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
                                    }
											?>
                                        </td>
                                        <td>
                                            <?php
                                    $exe8 = mysql_query("select * from home_work where class='$className' and section='$sectionName' and period='VIII' and date='$date'");
                                    while($fet8 = mysql_fetch_assoc($exe8)) {
                                        echo $fet8['subject'] . " " . $fet8['description'];
                                        if ($fet8['home_work_file_path']) {
                                            $file_ext_value = findexts($fet8['home_work_file_path']);
                                            ?>
                                            <a href="javascript:void(0);"
                                               data-href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>"
                                               class="openPopup">
                                                <img src="assets/fileicons/<?php echo $file_ext_value; ?>"
                                                     width="50px"/>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="<?php echo '../teacher/' . $fet8['home_work_file_path'];?>"
                                               download title="download"><i class="fa fa-download"></i></a>
                                        <?php
                                        }
                                        ?>
                                        <br/>
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

                            <?php
                            $hom_sql = "select * from home_work where date='$date' and admin_status='0'";
                            $hom_exe = mysql_query($hom_sql);
                            $hom_cnt = mysql_num_rows($hom_exe);
                            if($hom_cnt > 0){
                                ?>
                                <div class="row hidden">
                                    <div class='col-sm-2'>
                                        <form action="dosendhomework.php" method="post">
                                            <input type="submit" class="form-control btn btn-info" value="Send" onclick="return confirm('Do you want to send the home work?');"/>
                                            <input type="hidden" value="1" name="homeAdminStatus"/>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div><!-- /.box-body -->

                    </div><!-- /.box -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat:'yy-mm-dd',
            maxDate: 'today'
        });
    } );
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $(function() {
        // DataTable setup
            $('.datatable').DataTable({
                "bSort": false,
                autoWidth: false,
                columnDefs: [
                    {
                        width: '12%',
                        targets: 0,
                        orderable:false
                    },
                    {
                        width: '11%',
                        targets:[1,2,3,4,5,6,7,8],
                        orderable:false
                    }
                ],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
            },
                lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                displayLength: 100
        });

        $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: '60px'
        });
        });
    });
</script>
<!-- page script -->

<script>
    $( function() {
        $( "#datepicker").on( "change", function() {
            var d = $(this).val();
            $.ajax({
                url: "ajax-home-work.php?dat=" + d,
                context: document.body
            }).done(function(response) {
                $('.curdate').remove();
                $('#predate').html(response);

                $('.datatable').DataTable({
                    "bSort": false,
                    autoWidth: false,
                    columnDefs: [
                        {
                            width: '12%',
                            targets: 0,
                            orderable:false
                        },
                        {
                            width: '11%',
                            targets:[1,2,3,4,5,6,7,8],
                            orderable:false
                        }
                    ],
                    dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Search:</span> _INPUT_',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                    },
                    lengthMenu: [ 5, 10, 20, 25, 50, 75, 100],
                    displayLength: 100
                });

            });

        });
    } );


</script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            </div>
        </div>
      
    </div>
</div>
<script>
$(document).ready(function(){
    $(document).on("click", '.openPopup', function(event) { 
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal').modal({show:true});
			$('#myModal .modal-body').html('<iframe src="'+dataURL+'" width="100%" height="100%" />');
        });
    }); 
});
</script>
<style>
div.modal-dialog { width:75% !important; }
div.modal-body { height:600px !important; }
</style>
</body>
</html>