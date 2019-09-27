<style>
    .content-wrapper {
        min-height: 720px !important;
    }
    .sidebar-menu > li > a{
        padding: 5px 5px 5px 15px;
    }
    ol, ul {
        padding-left: 40px;
    }
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="image/logo.png" width="100%"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="image/logo.png" width="40%"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <div class="pull-right">
                <a href="logout.php" class="btn btn-info btn-flat" title="logout"><i class="ion ion-log-out"></i></a>
            </div>
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="image/user2-160x160.jpg" class="user-image" alt="User Image" />
                        <span class="hidden-xs">Admin</span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="image/user2-160x160.jpg" class="img-circle" alt="User Image" />
                            <p>
                                Admin Manager
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="admin-profile.php" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="image/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="dashboard.php">
                    <i class="ion ion-pie-graph"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#"><i class="ion ion-android-person"></i> <span>Student</span></a>
                <ul>
                    <li ><a href="student-count.php"><i class="ion ion-android-person"></i> <span>Student List</span></a></li>
                    <li><a href="student-add.php"><i class="ion ion-android-person"></i> <span>Add Student</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class="ion ion-android-person"></i> <span>Teacher</span></a>
                <ul>
                    <li><a href="teacher-list.php"><i class="ion ion-android-person"></i> <span>Teacher List</span></a></li>
                    <li><a href="teacher-add.php"><i class="ion ion-android-person"></i> <span>Add Teacher</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="home-work.php">
                    <i class="ion ion-android-person"></i> <span>Home Work List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="class-notes.php">
                    <i class="ion ion-android-person"></i> <span>Class Notes List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="project-list.php">
                    <i class="ion ion-android-person"></i> <span>Projects List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="circular-list.php">
                    <i class="ion ion-android-person"></i> <span>Circular List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#"><i class="ion ion-android-person"></i> <span>Attendance</span></a>
                <ul>
                    <li ><a href="student-attendance.php"><i class="ion ion-android-person"></i> <span>Student Attendance</span></a></li>
                    <li><a href="teacher-attendance.php"><i class="ion ion-android-person"></i> <span>Teacher Attendance</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="gallery.php">
                    <i class="ion ion-android-person"></i> <span>Gallery</span>
                </a>
            </li>

            <li class="treeview">
                <a href="teacher-remarks.php">
                    <i class="ion ion-android-person"></i> <span>Teacher Remarks</span>
                </a>
            </li>

            <li class="treeview">
                <a href="information_teacher.php">
                    <i class="ion ion-android-person"></i> <span>Parent Request</span>
                </a>
            </li>

            <li class="treeview">
                <a href="bus-tracking-view.php">
                    <i class="ion ion-android-person"></i> <span>Transport</span>
                </a>
            </li>

            <li class="treeview">
                <a href="notes.php">
                    <i class="ion ion-android-person"></i> <span>Notes</span>
                </a>
            </li>

            <li class="treeview">
                <a href="exam-time-table.php">
                    <i class="ion ion-android-person"></i> <span>Exam Time Table</span>
                </a>
            </li>

            <li class="treeview">
                <a href="classes.php">
                    <i class="ion ion-android-person"></i> <span>Class List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="chapters.php">
                    <i class="ion ion-android-person"></i> <span>Chapter List</span>
                </a>
            </li>

            <li class="treeview hidden">
                <a href="class-list.php">
                    <i class="ion ion-android-person"></i> <span>Class List</span>
                </a>
            </li>
            <li class="treeview hidden">
                <a href="section-list.php">
                    <i class="ion ion-android-person"></i> <span>Section List</span>
                </a>
            </li>
            <li class="treeview">
                <a href="subjects.php">
                    <i class="ion ion-android-person"></i> <span>Subject List</span>
                </a>
            </li>
            <li class="treeview">
                <a href="stops.php">
                    <i class="ion ion-android-person"></i> <span>Stops List</span>
                </a>
            </li>

            <li class="treeview">
                <a href="logout.php">
                    <i class="ion ion-log-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>


    </section>
    <!-- /.sidebar -->
</aside>
