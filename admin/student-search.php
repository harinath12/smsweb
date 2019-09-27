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

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$class_joining_sql="SELECT DISTINCT c.class_name FROM class_section as cs
LEFT JOIN `classes` as c on c.id = cs.class_id
 where class_section_status=1 order by c.id ASC";
$class_joining_exe=mysql_query($class_joining_sql);
$class_joining_results = array();
while($row = mysql_fetch_assoc($class_joining_exe)) {
    array_push($class_joining_results, $row);
}

$stop_sql="SELECT * FROM `stopping_master` where stopping_status='1' order by stopping_name ASC";
$stop_exe=mysql_query($stop_sql);
$stop_results = array();
while($row = mysql_fetch_assoc($stop_exe)) {
    array_push($stop_results, $row);
}

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req, .error{
            color : red;
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
                Students
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>

                <li class="active">Student Search</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="min-height: 600px;">
                        <div class="row hidden">
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

                        <div class="row" style="padding:10px 10px 0px 0px;">
                            <div class='col-md-2' style="float: right">
                                <div class="form-group">
                                    <a href="student-count.php"><input type="button" class="btn btn-info form-control" value="Student List"/></a>
                                </div>
                            </div>
                        </div>

                        <form class="form-horizontal" action="student-search-list.php" id="addStudentForm" method="post" enctype="multipart/form-data">
                            <div class="row" id="search-row">
                                <div class="row" style="padding: 0px 20px;">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Search By</label>
                                            <div class="col-lg-8">
                                                <select name="search[]" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="student_name">Student Name</option>
                                                    <option value="admission_number">Admission Number</option>
                                                    <option value="emis_number">EMIS Number</option>
                                                    <option value="dob">DOB</option>
                                                    <option value="doj">Date of Joining</option>
                                                    <option value="class_joining">Class Joining</option>
                                                    <option value="gender">Gender</option>
                                                    <option value="father_name">Father Name</option>
                                                    <option value="mother_name">Mother Name</option>
                                                    <option value="religion">Religion</option>
                                                    <option value="community">Community</option>
                                                    <option value="caste">Caste</option>
                                                    <option value="stop_from">Stop From</option>
                                                    <option value="mobile">Mobile</option>
                                                    <option value="email">Email</option>
                                                    <option value="city">City</option>
                                                    <option value="pincode">Pincode</option>
                                                    <option value="class">Class</option>
                                                    <option value="section_name">Section</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="text-field">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="search_value[]" />
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-info form-control" id="add-more" title="Add More">+</button>
                                    </div>
                                </div>

                            </div>

                            <script>
                                $(function(){
                                    var counter = 1;
                                    $('#add-more').click(function(event){
                                        event.preventDefault();

                                        var newRow = $('<div class="row" style="padding: 0px 20px;"> <div class="col-md-5">' +
                                        '<div class="form-group">' +
                                        '<label class="control-label col-lg-4">Search By</label>' +
                                        '<div class="col-lg-8">' +
                                        '<select name="search['+ counter +']" class="form-control">' +
                                        '<option value="">Select</option>' +
                                        '<option value="student_name">Student Name</option>' +
                                        '<option value="admission_number">Admission Number</option>' +
                                        '<option value="emis_number">EMIS Number</option>' +
                                        '<option value="dob">DOB</option>' +
                                        '<option value="doj">Date of Joining</option>' +
                                        '<option value="class_joining">Class Joining</option>' +
                                        '<option value="gender">Gender</option>' +
                                        '<option value="father_name">Father Name</option>' +
                                        '<option value="mother_name">Mother Name</option>' +
                                        '<option value="religion">Religion</option>' +
                                        '<option value="community">Community</option>' +
                                        '<option value="caste">Caste</option>' +
                                        '<option value="stop_from">Stop From</option>' +
                                        '<option value="mobile">Mobile</option>' +
                                        '<option value="email">Email</option>' +
                                        '<option value="city">City</option>' +
                                        '<option value="pincode">Pincode</option>' +
                                        '<option value="class">Class</option>' +
                                        '<option value="section_name">Section</option>' +
                                        '</select>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +

                                        '<div class="col-md-6">' +
                                        '<input type="text" class="form-control" name="search_value['+ counter +']" />' +
                                        '</div> </div>');
                                        counter++;
                                        $('#search-row').append(newRow);

                                    });
                                });
                            </script>

                            <div class="row">
                                <div class="col-md-5"></div>
                                <div class="col-md-2">
                                    <input type="submit" value="SEARCH" class="btn btn-info form-control"/>
                                </div>
                            </div>

                        </form>
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

<script>
    $(function() {
        $('#classId').change(function() {
            $('#sectionId').empty();
            $.get('sectionscript.php', {region: $(this).val()}, function(result){
                var list = "<option value=''>Select Section</option>";
                $.each(JSON.parse(result), function(i,item) {
                    list = list + "<option value='" + item.secname + "'>" + item.secname + "</option>";
                });
                $("#sectionId").html(list);
            });
        });
    });
</script>

</body>
</html>
