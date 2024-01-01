<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-olive text-white ">
    <!-- Left navbar links -->
    <ul class="navbar-nav d-none">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

    </ul>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-olive elevation-4">
        <!-- Brand Logo -->
        <a href="<?= BASE_URL . "dashboard/sales/pos" ?>" class="brand-link bg-olive">
            <img src="<?= BASE_URL; ?>/<?= SITE_LOGO ?>" alt="POS" class="brand-image" style="opacity: .8">
            <span class="brand-text">
                POS
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <?= Template::partial('partials/pos/sidebar', $data); ?>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Right navbar links -->
    <?= Template::partial('partials/pos/rightnavbar', $data); ?>

</nav>