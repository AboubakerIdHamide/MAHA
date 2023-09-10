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
                    <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant/bookmarks' ? 'active' : '' ?>">
                        <a class="sidebar-menu-button"
                           href="<?= URLROOT ?>/etudiant/bookmarks">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">bookmark</i> Mes Bookmarks
                        </a>
                    </li>
                    <li class="sidebar-menu-item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/maha/etudiant/transactions' ? 'active' : '' ?>">
                        <a class="sidebar-menu-button"
                           href="<?= URLROOT ?>/etudiant/messages">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">message</i> Messages
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
