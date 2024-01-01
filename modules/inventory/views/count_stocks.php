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
                    <li class="breadcrumb-item active">Count Stocks</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Count Stock</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/inventory/count_stock') ?>" method="POST">
                    <div class="row">
                        <div class="col-3">
                            <label for="">Warehouse *</label>
                            <div class="input-group">
                                <select name="warehouse" id="" class="form-control">
                                    <?php foreach ($warehouses as $warehouse) : ?>
                                        <option value="<?= $warehouse->warehouse_id ?>">
                                            <?= $warehouse->warehouse_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="">Date *</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="col-5">
                            <label>Reference *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Reference" name="reference">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12"><button type="submit" class="btn btn-primary">Submit</button></div>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>