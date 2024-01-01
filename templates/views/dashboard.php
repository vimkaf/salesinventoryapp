<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - <?= $page_title; ?></title>

    <?= Template::partial('partials/dashboard/styles', $data) ?>

    <style>
        .required_field {
            color: red;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= BASE_URL; ?>/assets/dist/img/logo.png" alt="<?= WEBSITE_NAME ?>" height="60" width="60">
        </div>

        <!-- Navbar -->
        <?= Template::partial('partials/dashboard/navbar', $data) ?>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <!-- /.content-header -->

            <!-- Main content -->
            <?= Template::display($data) ?>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?= Template::partial('partials/dashboard/footer') ?>


        <!-- Control Sidebar -->
        <?= Template::partial('partials/dashboard/controlsidebar') ?>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?= Template::partial('partials/dashboard/scripts'); ?>

    <?= Template::partial('partials/dashboard/toast'); ?>

    <?php if (isset($data['view_scripts'])) : ?>
        <?= Template::partial('partials/dashboard/view_scripts', $data); ?>
    <?php endif; ?>

    <?php if (isset($data['view_fragments'])) : ?>
        <?= Template::partial('partials/dashboard/view_fragments', $data); ?>
    <?php endif; ?>


</body>

</html>