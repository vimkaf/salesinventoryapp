<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard/sales') ?>">Sales</a></li>

                    <li class="breadcrumb-item active">Add Sales</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add a sale</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/sales/add') ?>" method="POST" id="salesForm">
                    <div class="row mb-2">

                        <div class="col-md-6">
                            <label for="">Customer <span class="required_field">*</span></label>
                            <div class="input-group">
                                <select name="customer" id="" class="form-control select2">
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer->customer_id ?>">
                                            <?= $customer->first_name . " " . $customer->last_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">Warehouse <span class="required_field">*</span></label>
                            <select name="warehouse" id="warehouse" class="form-control">
                                <?php foreach ($warehouses as $warehouse): ?>
                                    <option value="<?= $warehouse->warehouse_id; ?>">
                                        <?= $warehouse->warehouse_name; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 justify-content-around ">
                            <table class="table table-bordered table-sm table-striped" id="salesTable">
                                <thead>

                                    <tr class="border-0 ">
                                        <th colspan="2"></th>
                                        <th colspan="2">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" id="newItem"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-plus-square"></i>
                                                    New Item
                                                </button>

                                                <?php if (DISCOUNT): ?>
                                                    <button data-toggle="modal" data-target="#discountModal" type="button"
                                                        class="btn btn-sm btn-outline-dark">
                                                        <i class="fas fa-percent"></i>
                                                        Apply Discount
                                                    </button>
                                                <?php endif; ?>

                                                <?php if (HOLD_SALE): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary ">
                                                        <i class="far fa-pause-circle"></i>
                                                        Hold Sale
                                                    </button>
                                                <?php endif; ?>
                                            </div>

                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center bg-light ">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-row-id='1'>
                                        <td>
                                            <select name="product[]" class="form-control select2 products"
                                                data-product-id="1">
                                                <option value="">Search or select a product</option>
                                                <?php foreach ($products as $product): ?>
                                                    <option data-item-price="<?= $product->product_price; ?>"
                                                        value="<?= $product->product_id ?>">
                                                        <?= $product->product_code ?> -
                                                        <?= $product->product_name; ?>
                                                        [
                                                        <?= $product->unit; ?>]
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" value="1"
                                                class="form-control text-center quantity" data-qty-id="1"
                                                name="quantity[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control text-center" readonly
                                                data-price-id="1">
                                        </td>
                                        <td class="bg-light">
                                            <input type="text" class="form-control text-center" readonly name="total[]"
                                                data-total-id="1">
                                        </td>
                                        <td class="text-center align-middle">
                                            <i class="far fa-trash-alt text-danger deleteItem"></i>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="border-bottom-0"></th>
                                        <th class="text-right">
                                            Sub Total
                                        </th>
                                        <th colspan="2" class="text-center">
                                            <input type="hidden" id="subTotal" name="subTotal">
                                            <span></span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th class="text-right">
                                            Tax
                                        </th>
                                        <th colspan="2" class="text-success text-center">
                                            <span>+</span>
                                            <input type="hidden" id="tax" name="tax">
                                            <span></span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th class="text-right">
                                            Discount
                                        </th>
                                        <th colspan="2" class="text-danger text-center">
                                            <span>-</span>
                                            <input type="hidden" id="discount" name="discount">
                                            <span></span>
                                        </th>
                                    </tr>
                                    <tr style="border-top:1px double black;border-bottom:1px double black;">
                                        <th colspan="2"></th>
                                        <th class="text-right">
                                            Grand Total
                                        </th>
                                        <th colspan="2" class="text-center">
                                            <input type="hidden" id="grandTotal" name="grandTotal">
                                            <span></span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Amount Tendered<span class="required_field">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&#8358;</span>
                                </div>
                                <input required <?= TENDER_MODE === 'auto' ? 'readonly' : '' ?>
                                    class="form-control currency-mask" type="text" inputmode="decimal" id="amount_paid"
                                    name="amount_paid">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="">Method *</label>
                            <div class="input-group">
                                <select name="method" class="form-control" required>
                                    <?php $paymentMethods = explode(",", setting('payment_methods')); ?>
                                    <?php foreach ($paymentMethods as $method): ?>
                                        <option value="<?= strtolower($method) ?>"><?= strtoupper($method) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <div class="modal fade" id="discountModal">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apply Discount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&#8358;</span>

                            </div>

                            <input type="number" id="discountValue" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="applyDiscount" class="btn btn-primary">Apply Discount</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>