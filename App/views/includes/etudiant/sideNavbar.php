<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
    <div class="mdk-drawer__content ">
        <div class="sidebar sidebar-left sidebar-dark bg-dark o-hidden"
             data-perfect-scrollbar>
            <div class="sidebar-p-y">
                <div class="sidebar-heading">Student</div>
                <ul class="sidebar-menu sm-active-button-bg">
                    <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant' ? 'active' : '' ?>">
                        <a class="sidebar-menu-button"
                           href="<?= URLROOT ?>/etudiant">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">school</i> Mes cours
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button"
                           data-toggle="collapse"
                           href="#course_menu">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">desktop_mac</i>
                            Manage Courses
                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                        </a>
                        <ul class="sidebar-submenu sm-indent collapse"
                            id="course_menu">
                            <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/courses' ? 'active' : '' ?>">
                                <a class="sidebar-menu-button"
                                   href="<?= URLROOT ?>/courses">
                                    <span class="sidebar-menu-text">Courses</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/courses/add' ? 'active' : '' ?>">
                                <a class="sidebar-menu-button"
                                   href="<?= URLROOT ?>/courses/add">
                                    <span class="sidebar-menu-text">Add Course</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant/earnings' ? 'active' : '' ?>">
                        <a class="sidebar-menu-button"
                           href="<?= URLROOT ?>/etudiant/earnings">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">trending_up</i> Earnings
                        </a>
                    </li>
                    <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant/transactions' ? 'active' : '' ?>">
                        <a class="sidebar-menu-button"
                           href="<?= URLROOT ?>/etudiant/transactions">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">receipt</i> Transactions
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
