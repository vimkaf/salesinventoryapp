<section class="content pt-2">
    <div class="container-fluid">
        <form action="<?= base_url('dashboard/sales/add') ?>" method="POST" id="salesForm">


            <div class="row">
                <div class="col-md-6">
                    <div class="mb-1">
                        <div class="input-group">
                            <select name="customer" id="customer" class="form-control select2">
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer->customer_id ?>">
                                        <?= $customer->first_name . " " . $customer->last_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a data-toggle="modal" data-target="#customerModal" href="#"
                                    class="input-group-text text-primary ">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-1">

                        <select name="warehouse" id="warehouse" class="form-control">
                            <?php foreach ($warehouses as $warehouse): ?>
                                <option value="<?= $warehouse->warehouse_id; ?>">
                                    <?= $warehouse->warehouse_name; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 ">
                    <div class="mb-1 p-2">
                        <table class="table table-sm text-sm table-striped" id="salesTable">
                            <thead>
                                <tr class="border-0 ">
                                    <th colspan="2"></th>
                                    <th colspan="2">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="newItem" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus-square"></i>
                                                New Item
                                            </button>

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
                                        <input type="number" min="1" value="1" class="form-control text-center quantity"
                                            data-qty-id="1" name="quantity[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center" readonly data-price-id="1">
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

            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Amount Tendered<span class="required_field">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">&#8358;</span>
                        </div>
                        <input required class="form-control currency-mask" type="text" inputmode="decimal"
                            name="amount_paid">
                    </div>
                </div>
                <div class="col-4">
                    <label for="">Method *</label>
                    <div class="input-group">
                        <select name="method" class="form-control" required>
                            <option value="cash">Cash</option>
                            <option value="transfer">Bank Transfer</option>
                            <option value="card">CARD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" name="save_action" value="save" class="btn btn-primary">
                        Save
                    </button>
                    <button type="submit" name="save_action" value="print" class="btn btn-primary">
                        <i class="fas fa-print"></i>
                        Save and Print
                    </button>
                </div>
            </div>
        </form>
    </div><!-- /.container-fluid -->


    <div class="modal fade" id="customerModal">
        <div class="modal-dialog modal-dialog-centered ">
            <form action="#" id="customerForm" method="post">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="#">First Name
                                    <span class="required_field">*</span>
                                </label>
                                <input required type="text" name="first_name" id="" class="form-control">
                            </div>

                            <div class="col-md">
                                <label for="#">Last Name<span class="required_field">*</span></label>
                                <input required type="text" name="last_name" id="" class="form-control">
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="#">Email</label>
                                <input type="email" name="email" id="" class="form-control">
                            </div>

                            <div class="col-md">
                                <label for="#">Phone Number<span class="required_field">*</span></label>
                                <input required type="text" name="phone_number" id="" class="form-control">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="#">Address<span class="required_field">*</span></label>
                            <textarea required name="address" class="form-control" cols="5" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>