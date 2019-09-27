<?php
session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

if(isset($_REQUEST['sub'])){
    $sub = $_REQUEST['sub'];
    if(isset($_REQUEST['term'])){
        $term = $_REQUEST['term'];
    }
    else{
        header("Location: create-self-test.php?err=1");
    }
}
else{
    header("Location: create-self-test.php?err=1");
}

$student_sql = "select c.class_name, aca.section_name from student_academic as aca
left join classes as c on c.id = aca.class
where user_id='$user_id'";
$student_exe = mysql_query($student_sql);
$student_cnt = @mysql_num_rows($student_exe);
$student_fet = mysql_fetch_assoc($student_exe);

$className = $student_fet['class_name'];
$sectionName = $student_fet['section_name'];

$cls_sql="SELECT * FROM `classes` where class_name='$className'";
$cls_exe=mysql_query($cls_sql);
$cls_fet = mysql_fetch_assoc($cls_exe);
$classId = $cls_fet['id'];

$ques_sql = "select q.*, c.class_name from question_bank as q
left join classes as c on c.id = q.class_id
where question_bank_status='1' and class_id='$classId' and subject_name='$sub' and term='$term' order by id desc";
//echo $ques_sql; exit;
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
?>

<form action="self-test-view.php" method="POST">
    <table class="table datatable">
        <thead>
        <tr>
            <th>S.No.</th>
            <th>CLASS</th>
            <th>SUBJECT</th>
            <th>TERM</th>
            <th>CHAPTER</th>
            <th>ACTION</th>
        </tr>
        </thead>
        <?php
        if($ques_cnt>0)
        {
            ?>
            <tbody>
            <?php
            $i =1;
            while($ques_fet=mysql_fetch_array($ques_exe))
            {
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $ques_fet['class_name']; ?></td>
                    <td><?php echo $ques_fet['subject_name'] ?></td>
                    <td><?php echo $ques_fet['term'] ?></td>
                    <td><?php echo $ques_fet['chapter']; ?></td>
                    <td class="text-center">
                        <ul class="icons-list">

                            <li> <input type="checkbox" name="chapter[]" value="<?php echo $ques_fet['id']; ?>" /> <?php //echo $ques_fet['id']; ?></li>&nbsp;&nbsp;

                        </ul>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        <?php
        }
        ?>
    </table>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-3" style="float: right">
        </div>
        <div class="col-md-3" style="float: right">
            <button type="submit" class="form-control btn btn-info" name="submit">Write Self Test</button>
        </div>
    </div>
    </br>
</form>

<script>
    $(document).ready(function() {
        $(function() {
            $('.styled').uniform();
        });
        $(function() {

            // DataTable setup
            $('.datatable').DataTable({
                autoWidth: false,
                columnDefs: [
                    {
                        width: '10%',
                        targets: 0
                    },
                    {
                        width: '15%',
                        targets:[1,2,3]
                    },
                    {
                        width: '25%',
                        targets:4
                    },
                    {
                        width: '10%',
                        targets: 5,
                        orderable: false
                    }
                ],
                order: [[ 0, 'asc' ]],
                dom: '<"datatable-header"fl><"datatable-scroll-lg"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
                },
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                displayLength: 10
            });

            $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: '60px'
            });
        });
    });
</script>
