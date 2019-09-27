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

if(isset($_REQUEST['class_id']))
{
    $class_id=$_REQUEST['class_id'];
}
else
{
    exit;
}

$class_sql="SELECT * FROM `classes` where class_status=1";
$class_exe=mysql_query($class_sql);
$class_results = array();
while($row = mysql_fetch_assoc($class_exe)) {
    array_push($class_results, $row);
}

$section_sql="SELECT * FROM `section` where section_status=1";
$section_exe=mysql_query($section_sql);
$section_results = array();
while($row = mysql_fetch_assoc($section_exe)) {
    array_push($section_results, $row);
}

$class_section_sql="SELECT cs.*, c.class_name, s.section_name FROM `class_section` as cs
LEFT JOIN classes as c on c.id = cs.class_id
LEFT JOIN section as s on s.id = cs.section_id
WHERE cs.`id`='$class_id'";

$class_section_sql="SELECT cs.*, c.class_name FROM `class_section` as cs
LEFT JOIN classes as c on c.id = cs.class_id
WHERE cs.`id`='$class_id'";
$class_section_exe=mysql_query($class_section_sql);
$class_section_cnt=@mysql_num_rows($class_section_exe);
$class_section_fet=mysql_fetch_array($class_section_exe);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .req{
            color : red;
        }
    </style>

    <meta charset="UTF-8">
    <title>Admin Panel </title>
    <?php include "head1.php"; ?>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "header.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Class
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Class</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-9">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Class Details</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="doeditclass.php?class_id=<?php echo $class_section_fet['id']; ?>" method="post">
                            <div class="box-body">

                                <div class="col-md-12">
                                    <style>.control-label{line-height:32px;} .form-group{line-height:32px;}</style>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Class Name<span class="req"> *</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="className" id="className" required>
                                                <option value="">Select Class</option>
                                                <?php
                                                foreach($class_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($class_section_fet['class_id'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['class_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div id="errClassName" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Section Name<span class="req"> *</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="sectionName" id="sectionName" value="<?php echo $class_section_fet['section_name'];?>" required/>
                                            <?php /* ?>
                                            <select class="form-control" name="sectionName" id="sectionName" required>
                                                <option value="">Select Section</option>
                                                <?php
                                                foreach($section_results as $key => $value){ ?>
                                                    <option value="<?php echo $value['id']; ?>" <?php if($class_section_fet['section_id'] == $value['id']) { echo 'selected'; } ?>><?php echo $value['section_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <?php */ ?>
                                            <div id="errSectionName" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Class Status<span class="req"> *</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="2">Select Class Status</option>
                                                <option value="1" <?php if($class_section_fet['class_section_status'] == 1){ echo 'selected'; } ?>>Active</option>
                                                <option value="0" <?php if($class_section_fet['class_section_status'] == 0){ echo 'selected'; } ?>>Inactive</option>
                                            </select>
                                            <div id="errClassStatus" style="color:red"></div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat save-class">Save Changes</button>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col (left) -->

                <!-- right column -->
                <div class="col-md-3">
                    <!-- Horizontal Form -->
                    <div class="box box-danger" >
                        <div class="box-header with-border">
                            <h3 class="box-title">Class</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group col-md-12">
                                <a href="classes.php"><button type="submit" class="btn btn-warning col-md-12" style="margin-bottom:10px;" >Back to Classes List</button></a>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include "footer.php"; ?>

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".save-class").click(function(){
            $("div#errClassName").html( " " );
            $("div#errSectionName").html( " " );
            $("div#errClassStatus").html( " " );
            var className = $('#className').val();
            if(!className){
                $("div#errClassName").html( "This field is required" );
                return false;
            }
            var sectionName = $('#sectionName').val();
            if(!sectionName){
                $("div#errSectionName").html( "This field is required" );
                return false;
            }
            var status = $('#status').val();
            if(status == 2){
                $("div#errClassStatus").html( "This field is required" );
                return false;
            }
        });
    });
</script>
</body>
</html>
