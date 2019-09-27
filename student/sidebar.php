<?php

$user_name=$_SESSION['adminusername'];
$user_id=$_SESSION['adminuserid'];

$teacher_sql="SELECT * FROM `student_general` WHERE user_id = $user_id";

$teacher_sql="SELECT sg.*,sa.class, sa.section_name, cl.class_name FROM `student_general` AS sg 
INNER JOIN `student_academic` AS sa on sg.user_id = sa.user_id
INNER JOIN `classes` AS cl on sa.class = cl.id
WHERE 
sg.user_id = $user_id";

$teacher_exe=mysql_query($teacher_sql);
$teacher_cnt=@mysql_num_rows($teacher_exe);
$teacher_fet=mysql_fetch_array($teacher_exe);

$teacherPhoto = '../admin/' . $teacher_fet['photo'];


$class_section_value = $teacher_fet['class_name']." ".$teacher_fet['section_name'];

$teacher_info_sql="SELECT tg.teacher_name, tg.emp_no, ta.class_teacher FROM `teacher_general` AS tg 
INNER JOIN `teacher_academic` AS ta on tg.user_id = ta.user_id
WHERE 
ta.class_teacher = '$class_section_value'";

$teacher_info_exe=mysql_query($teacher_info_sql);
$teacher_info_cnt=@mysql_num_rows($teacher_info_exe);
$teacher_info_fet=mysql_fetch_array($teacher_info_exe);

?>
<div class="sidebar-content">

    <!-- User menu -->
    <div class="sidebar-user">
        <div class="category-content">
			
			<div class="media">
                <div class="media-body">
                    <span class="media-heading text-semibold">Student Admin</span>
                </div> 
            </div>
            <div class="media">
                <a href="dashboard.php" class="media-left">
                    <img src=" <?php echo '../admin/' . $teacher_fet['photo']; ?>" alt="<?php echo $user_name; ?>" title="<?php echo $user_name; ?>" class="img-circle img-sm">
                </a>
                <div class="media-body">
                    
					<span class="media-heading text-semibold"><?php echo $user_name; ?></span>
                    <div class="text-size-mini text-muted">( <?php echo $teacher_fet['admission_number']; ?> ) <?php echo $teacher_fet['class_name']." ".$teacher_fet['section_name']; ?></div>
					
                </div>

                <div class="media-right media-middle">
                    <ul class="icons-list">
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
			
			<div class="media">
                <div class="media-body">
                    <span class="media-heading text-semibold">Teacher : <?php echo $teacher_info_fet['teacher_name']; ?> ( <?php echo $teacher_info_fet['emp_no']; ?> )</span>
                </div>
            </div>
        </div>
    </div>
    <!-- /user menu -->

    <!-- Main navigation -->
    <div class="sidebar-category sidebar-category-visible">
        <div class="category-content no-padding">
            <ul class="navigation navigation-main navigation-accordion">

                <!-- Main -->
                <li class="active">
                    <a href="dashboard.php"><i class="fa fa-desktop"></i> <span>Dashboard</span></a>
                </li>
                <!-- /Main -->

                <li>
                    <a href="home-work.php"><i class="fa fa-users"></i> <span>Home Work</span></a>
                </li>

                <li>
                    <a href="class-notes.php"><i class="fa fa-users"></i> <span>Class Notes</span></a>
                </li>

                <li>
                    <a href="project-list.php"><i class="fa fa-users"></i> <span>Projects</span></a>
                </li>

                <li>
                    <a href="gallery.php"><i class="fa fa-users"></i> <span>Gallery</span></a>
                </li>

                <li>
                    <a href="exam-time-table.php"><i class="fa fa-users"></i> <span>Exam Time Table</span></a>
                </li>

                <li>
                    <a href="#"><i class="fa fa-users"></i> <span>Profile</span></a>
                    <ul>
                        <li><a href="my-profile.php"><i class="fa fa-users"></i> <span>My Profile</span></a></li>
                        <li><a href="change-password.php"><i class="fa fa-user-plus"></i> <span>Change Password</span></a></li>
                        <li><a href="logout.php"><i class="fa fa-user-plus"></i> <span>Logout</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navigation -->

</div>