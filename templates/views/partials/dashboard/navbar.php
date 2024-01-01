<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

    </ul>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= BASE_URL . "/dashboard" ?>" class="brand-link">
            <img src="<?= BASE_URL; ?>/<?= SITE_LOGO ?>" alt="Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">
                <?= SHORT_SITE_NAME; ?>
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <!-- <img src="<?= BASE_URL; ?>/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                </div>
                <div class="info">
                    <a href="#" class="d-block">
                        <?= ucwords($_SESSION['employee']->first_name . " " . $_SESSION['employee']->last_name); ?>
                    </a>
                    <span class="badge bg-red">
                        <?= ucfirst($_SESSION['employee']->role); ?>
                    </span>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <?= Template::partial('partials/dashboard/sidebar', $data); ?>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Right navbar links -->
    <?= Template::partial('partials/dashboard/rightnavbar', $data); ?>

</nav>