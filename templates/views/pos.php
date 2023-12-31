<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS -
        <?= $page_title; ?>
    </title>

    <?= Template::partial('partials/pos/styles', $data) ?>

    <style>
        .required_field {
            color: red;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= BASE_URL; ?>/assets/dist/img/logo.png" alt="<?= WEBSITE_NAME ?>"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <?= Template::partial('partials/pos/navbar', $data) ?>
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


        <!-- Control Sidebar -->
        <?= Template::partial('partials/pos/controlsidebar') ?>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?= Template::partial('partials/pos/scripts'); ?>

    <?= Template::partial('partials/pos/toast'); ?>

    <?php if (isset($data['view_scripts'])): ?>
        <?= Template::partial('partials/pos/view_scripts', $data); ?>
    <?php endif; ?>

    <?php if (isset($data['view_fragments'])): ?>
        <?= Template::partial('partials/pos/view_fragments', $data); ?>
    <?php endif; ?>


</body>

</html>