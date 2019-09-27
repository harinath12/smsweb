<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['examid'])) {
    $examid = $_GET['examid'];
}

$class_master_sql="SELECT * FROM `classes` where class_status=1";
$class_master_exe=mysql_query($class_master_sql);
$class_master_results = array();
while($row = mysql_fetch_assoc($class_master_exe)) {
    array_push($class_master_results, $row);
}
?>
<table id="example2" class="table datatable curdate">
    <thead>
    <tr>
        <th style="border-right: 1px solid black;">Class</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($class_master_results as $key => $value)
    {
        $className = $value['class_name'];
        $classId = $value['id'];

        $section_sql="SELECT cs.* FROM `class_section` as cs where cs.class_section_status=1 and cs.class_id='$classId'";
        $section_exe=mysql_query($section_sql);
        $section_results = array();
        while($row = mysql_fetch_assoc($section_exe))
        {
            array_push($section_results, $row);
        }

        foreach ($section_results as $sec_key => $sec_value)
        {
            $sectionName = $sec_value['section_name'];
            $sectionId = $sec_value['id'];
            ?>
            <tr>
                <td style="border-right: 1px solid black;">
                    <a href="student-mark-list.php?classid=<?php echo $classId;?>&sectionname=<?php echo $sectionName;?>&examid=<?php echo $examid;?>"><?php echo $className . " " . $sectionName; ?></a>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>
</table>