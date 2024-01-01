<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">

            <a href="<?= base_url('dashboard/sales/pos') ?>"
                class="nav-link <?= segment(3) === 'pos' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>

        </li>

        <li class="nav-item">
            <a href="<?= base_url('dashboard/sales/pos_report'); ?>"
                class="nav-link <?= segment(3) === 'pos_report' || segment(3) === 'filter_pos_report' ? 'active' : '' ?>">
                <i class="nav-icon far fa-file-alt"></i>
                <p>Sales Report</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= BASE_URL; ?>dashboard/logout" class="nav-link">
                <i class="nav-icon fas fa-power-off text-danger"></i>
                <p>Logout</p>
            </a>
        </li>

    </ul>
</nav>