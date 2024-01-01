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
                    <li class="breadcrumb-item active">Stocks</li>
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
                        <div class="card card-primary collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Filter</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="<?= base_url('dashboard/inventory/filter_stocks') ?>" method="get">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <select name="warehouse" class="form-control">
                                                <option value="">Choose a warehouse</option>
                                                <?php foreach ($warehouses as $warehouse): ?>
                                                    <option value="<?= $warehouse->warehouse_id ?>">
                                                        <?= $warehouse->warehouse_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <select name="product" class="form-control select2">
                                                <option value="">Choose a product</option>

                                                <?php foreach ($products as $product): ?>
                                                    <option value="<?= $product->product_id ?>">
                                                        <?= $product->product_code; ?> -
                                                        <?= $product->product_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <button type="submit" class="btn btn-primary ">Filter</button>
                                        </div>
                                    </div>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Stocks</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Warehouse</th>
                                            <th>Product</th>
                                            <th class="bg-primary text-center">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($inventories as $index => $inventory): ?>

                                            <tr>
                                                <td>
                                                    <?= ++$index; ?>
                                                </td>

                                                <td>
                                                    <?= $inventory->warehouse_name; ?>
                                                </td>
                                                <td>
                                                    <?= $inventory->product_code; ?>
                                                    <span> - </span>
                                                    <?= $inventory->product_name; ?>
                                                </td>

                                                <td class="table-primary text-center">
                                                    <?= number_format($inventory->quantity_on_hand); ?>
                                                    [
                                                    <?= $inventory->unit; ?>]

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