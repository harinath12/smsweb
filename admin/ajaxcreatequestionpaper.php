<?php session_start();
ob_start();

include "config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

if(isset($_REQUEST['sub'])){
    $sub = $_REQUEST['sub'];
    if(isset($_REQUEST['term'])){
        $term = $_REQUEST['term'];
        if(isset($_REQUEST['cid'])){
            $cid = $_REQUEST['cid'];
        }
        else{
            header("Location: create-question-paper.php?err=1");
        }
    }
    else{
        header("Location: create-question-paper.php?err=1");
    }
}
else{
    header("Location: create-question-paper.php?err=1");
}

$ques_sql = "select q.* from question_bank as q
where question_bank_status='1' and class_id='$cid' and subject_name='$sub' and term='$term' order by id desc";
$ques_exe = mysql_query($ques_sql);
$ques_cnt = @mysql_num_rows($ques_exe);
?>

<form action="create-question-paper-view.php" method="POST">
    <table class="table datatable">
        <thead>
        <tr>
            <th>S.No.</th>
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
			
			<input type="hidden" name="class_id" value="<?php echo $cid; ?>" />			
			<input type="hidden" name="term" value="<?php echo $term; ?>" />
            <input type="hidden" name="subject_name" value="<?php echo $sub; ?>" />
			<button type="submit" class="form-control btn btn-info" name="submit">Create Question Paper</button>
        </div>
    </div>
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
                        width: '15%',
                        targets: 2,
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
