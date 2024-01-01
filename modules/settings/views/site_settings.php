<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Site Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Site</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <form action="<?= BASE_URL ?>dashboard/settings/site" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Site Settings</h3>
                        </div>

                        <div class="card-body">
                            <!-- form start -->
                            <div class="row">

                                <?php foreach ($settings as $setting): ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">
                                                <?= strtoupper(str_replace("_", " ", $setting->setting_name)); ?>
                                            </label>
                                            <input type="text" class="form-control" name="<?= $setting->setting_name; ?>"
                                                value="<?= $setting->setting_value; ?>" required>
                                        </div>

                                    </div>
                                <?php endforeach; ?>



                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>