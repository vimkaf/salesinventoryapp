<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Import Product</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Import Product</li>
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
                <form action="<?= base_url('dashboard/products/import') ?>" enctype="multipart/form-data" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>

                            <div class="card-tools">
                                <a download="template.csv" href="<?= base_url('uploads/template.csv') ?>">
                                    <i class="fas fa-download"></i> Download Template
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="alert alert-info bg-light col">
                                    <p>
                                        <a class="text-primary" download="template.csv" href="<?= base_url('uploads/template.csv') ?>">
                                            Download
                                        </a>
                                        the template and upload
                                    </p>
                                </div>
                            </div>

                            <!-- form start -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">
                                            Product Category
                                            <span class="required_field">*</span>
                                        </label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value=""></option>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?= $category->category_id; ?>"><?= $category->category_name; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            File
                                            <span class="required_field">*</span>
                                        </label>
                                        <div class="custom-file">
                                            <input required accept=".csv" name="file" type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Start Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>