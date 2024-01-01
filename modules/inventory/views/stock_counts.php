<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inventory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>

                    <li class="breadcrumb-item active">Stock Counts</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Stock Counts</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Title</th>
                                            <th>Warehouse</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stock_counts as $index => $stockcount) : ?>
                                            <tr>
                                                <td><?= ++$index; ?></td>
                                                <td><?= $stockcount->date; ?></td>
                                                <td><?= $stockcount->reference; ?></td>
                                                <td><?= $stockcount->title; ?></td>
                                                <td><?= $stockcount->warehouse_name; ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-around ">
                                                        <a href="<?= base_url('dashboard/inventory/download_stock_count/' . $stockcount->id) ?>">
                                                            <i class="fas fa-download"></i>
                                                        </a>

                                                        <a href="<?= base_url('dashboard/inventory/delete_stock_count/' . $stockcount->id) ?>" class="text-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
</section>