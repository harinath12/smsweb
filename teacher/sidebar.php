<?php

$user_name=$_SESSION['adminusername'];
$user_id=$_SESSION['adminuserid'];

$teacher_sql="SELECT * FROM `teacher_general` WHERE user_id = $user_id";
$teacher_exe=mysql_query($teacher_sql);
$teacher_cnt=@mysql_num_rows($teacher_exe);
$teacher_fet=mysql_fetch_array($teacher_exe);

$teacherPhoto = '../admin/' . $teacher_fet['photo'];
?>
<div class="sidebar-content">

    <!-- User menu -->
    <div class="sidebar-user">
        <div class="category-content">
            <div class="media">
                <a href="dashboard.php" class="media-left">
                    <img src=" <?php echo '../admin/' . $teacher_fet['photo']; ?>" alt="<?php echo $user_name; ?>" title="<?php echo $user_name; ?>" class="img-circle img-sm">
                </a>
                <div class="media-body">
                    <span class="media-heading text-semibold">Teacher Admin</span>
                    <div class="text-size-mini text-muted">
                        <?php echo $user_name; ?>
                    </div>
                </div>

                <div class="media-right media-middle">
                    <ul class="icons-list">
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out"></i></a>
                        </li>
                    </ul>
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
                    <a href="#"><i class="fa fa-users"></i> <span>Student</span></a>
                    <ul>
                        <li><a href="student.php"><i class="fa fa-users"></i> <span>Student List</span></a></li>
                    </ul>
                </li>

                <li>
                    <a href="class-notes.php"><i class="fa fa-users"></i> <span>Class Notes</span></a>
                </li>

                <li>
                    <a href="home-work.php"><i class="fa fa-users"></i> <span>Home Work</span></a>
                </li>

                <li>
                    <a href="project-list.php"><i class="fa fa-users"></i> <span>Project</span></a>
                </li>

                <li>
                    <a href="gallery.php"><i class="fa fa-users"></i> <span>Gallery</span></a>
                </li>

                <li>
                    <a href="attendance.php"><i class="fa fa-users"></i> <span>Attendance</span></a>
                </li>

                <li>
                    <a href="circular.php"><i class="fa fa-users"></i> <span>Circular</span></a>
                </li>

                <li>
                    <a href="teacher-remarks.php"><i class="fa fa-users"></i> <span>Teacher remarks</span></a>
                </li>

                <li>
                    <a href="information_teacher.php"><i class="fa fa-users"></i> <span>Parent Request</span></a>
                </li>

                <li>
                    <a href="question-bank.php"><i class="fa fa-users"></i> <span>Question Bank</span></a>
                </li>

                <li>
                    <a href="notes.php"><i class="fa fa-users"></i> <span>Notes</span></a>
                </li>

                <li>
                    <a href="exam-time-table.php"><i class="fa fa-users"></i> <span>Exam Time Table</span></a>
                </li>

                <li>
                    <a href="marks-list.php"><i class="fa fa-users"></i> <span>Mark Entry</span></a>
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