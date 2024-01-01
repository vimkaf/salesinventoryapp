<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Stock</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Stock</li>
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
                <form action="<?= base_url('dashboard/inventory/add_stocks') ?>" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Stock to Inventory</h3>
                        </div>

                        <div class="card-body">
                            <!-- form start -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Product Name</label>
                                        <select name="product_id" id="" class="form-control select2">
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?= $product->product_id ?>">
                                                    <?= $product->product_code; ?> -
                                                    <?= $product->product_name; ?> [
                                                    <?= $product->unit; ?>]
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Quantity</label>
                                        <input type="number" class="form-control" placeholder="Quantity to stock"
                                            name="quantity" required>
                                    </div>
                                    <div class="form-group d-none">
                                        <label for="exampleInputPassword1">Purchase Order Number</label>
                                        <input type="number" class="form-control" placeholder="Purchase Order Number"
                                            name="purchase_order_number">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Warehouse</label>
                                        <select name="warehouse_id" id="" class="form-control" required>
                                            <?php foreach ($warehouses as $warehouse): ?>
                                                <option value="<?= $warehouse->warehouse_id; ?>">
                                                    <?= $warehouse->warehouse_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Reorder Level</label>
                                        <input type="text" class="form-control" placeholder="Reorder Level"
                                            name="reorderlevel">
                                    </div>
                                </div>
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