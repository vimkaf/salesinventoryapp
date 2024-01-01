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
                    <li class="breadcrumb-item active">Quantity Adjustment</li>
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
                                <h3 class="card-title">Filter Adjustments</h3>

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
                                <form action="<?= base_url('dashboard/inventory/filter_adjustments') ?>" method="get">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <select name="warehouse" class="form-control">
                                                <option value="">Choose a warehouse</option>
                                                <?php foreach ($warehouses as $warehouse) : ?>
                                                    <option value="<?= $warehouse->warehouse_id ?>"><?= $warehouse->warehouse_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <select name="product" class="form-control select2">
                                                <option value="">Choose a product</option>

                                                <?php foreach ($products as $product) : ?>
                                                    <option value="<?= $product->product_id ?>"><?= $product->product_code; ?> - <?= $product->product_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input name="date" type="text" class="form-control float-right date-range">
                                            </div>
                                            <!-- /.input group -->
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
                                <h3 class="card-title">Quantity Adjustments</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Date</th>
                                            <th>Warehouse</th>
                                            <th>Product</th>
                                            <th>Employee</th>
                                            <th class="text-center ">Old Stock</th>
                                            <th class="text-center ">Adjustment</th>
                                            <th class="bg-primary">Stock</th>

                                            <th>Note</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($adjustments as $index => $adjustment) : ?>

                                            <tr>
                                                <td>
                                                    <?= ++$index; ?>
                                                </td>
                                                <td>
                                                    <?= date("M d,Y", strtotime($adjustment->transaction_date)); ?>
                                                </td>
                                                <td>
                                                    <?= $adjustment->warehouse_name; ?>
                                                </td>
                                                <td>
                                                    <?= $adjustment->product_name ?>
                                                </td>
                                                <td>
                                                    <?= "{$adjustment->first_name} {$adjustment->last_name}"; ?>
                                                </td>
                                                <td class="text-center ">
                                                    <?= number_format($adjustment->previous_quantity) ?>
                                                </td>

                                                <td class="text-center ">

                                                    <?php if ($adjustment->transaction_type === "ADD") : ?>
                                                        <span class='text-success'>+</span>
                                                        <?= number_format($adjustment->quantity) ?>

                                                    <?php endif; ?>

                                                    <?php if ($adjustment->transaction_type === "REMOVE") : ?>
                                                        <span class='text-danger'>-</span>
                                                        <?= number_format($adjustment->quantity) ?>

                                                    <?php endif; ?>

                                                </td>

                                                <td class="table-primary text-center">
                                                    <?php if ($adjustment->transaction_type === "ADD") : ?>
                                                        <?= number_format($adjustment->quantity + $adjustment->previous_quantity) ?>
                                                    <?php endif; ?>

                                                    <?php if ($adjustment->transaction_type === "REMOVE") : ?>
                                                        <?= number_format($adjustment->previous_quantity - $adjustment->quantity) ?>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?= $adjustment->remarks; ?>
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