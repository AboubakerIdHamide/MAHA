<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content ">
        <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden"
             data-perfect-scrollbar>
            <div class="sidebar-p-y">
                <div class="sidebar-heading">Instructor</div>
                <ul class="sidebar-menu sm-active-button-bg">
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button"
                           data-toggle="collapse"
                           href="#course_menu">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">import_contacts</i>
                            Manage Courses
                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                        </a>
                        <ul class="sidebar-submenu sm-indent collapse"
                            id="course_menu">
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?= URLROOT ?>/courses">
                                    <span class="sidebar-menu-text">Courses</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?= URLROOT ?>/courses/add">
                                    <span class="sidebar-menu-text">Add Course</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button"
                           href="instructor-quizzes.html">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">help</i> Quiz Manager
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button"
                           href="instructor-earnings.html">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">trending_up</i> Earnings
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button"
                           href="instructor-statement.html">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">receipt</i> Statement
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
