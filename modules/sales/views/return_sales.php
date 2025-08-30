<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Return Sale</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard/sales') ?>">Sales</a></li>
                    <li class="breadcrumb-item active">Return Sales</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">

        <form action="<?= base_url('dashboard/sales/returnsale') ?>" method="GET">
            <div class="row mb-4">
                <div class="col-md-3">
                    <input autofocus type="text" name="sale_number" id="sale_number"
                        class="form-control form-control-sm" placeholder="Sale Number"
                        value="<?= out($_GET['sale_number'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-primary">Submit</button>
                </div>
            </div>
        </form>

        <hr>

        <?php if (isset($sale_products)): ?>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Return a sale</h3>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('dashboard/sales/returnsale') ?>" method="POST" id="salesForm">
                        <input type="hidden" name="sale_id" value="<?= $saleRecord->sale_id; ?>">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span class="font-weight-bolder">Reference</span>
                                <p class="text-uppercase"><?= $saleRecord->sale_number; ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <span class="font-weight-bolder">Customer</span>
                                <p class="text-uppercase"><?= "{$customer->first_name} {$customer->last_name}"; ?>
                                </p>
                            </div>

                            <div class="col-md-4">
                                <span class="font-weight-bolder">Warehouse</span>
                                <p class="text-uppercase"><?= $warehouse->warehouse_name; ?></p>
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
                                                </div>

                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Qty Solda</th>
                                            <th class="text-center">Qty Returned</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center bg-light ">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = $saleTotal = 0; ?>
                                        <?php foreach ($data['sale_products'] as $key => $sale): ?>
                                            <?php
                                            $total = $sale->price * $sale->quantity_sold;
                                            $saleTotal += $total;
                                            ?>
                                            <tr data-row-id='<?= $key ?>'>
                                                <td style="width:40%">
                                                    <?= "{$sale->product_code} - {$sale->product_name}"; ?>
                                                    <input data-product="<?= $key ?>" type="hidden" name="product[]"
                                                        value="<?= $sale->product_id ?>">
                                                </td>
                                                <td class="text-center" style="width: 15%; vertical-align: center;">
                                                    <input type="hidden" name="quantity_sold[]" value="<?= $sale->quantity_sold; ?>" data-qs="<?= $key ?>">
                                                    <?= $sale->quantity_sold; ?>
                                                </td>
                                                <td style="width: 15%;">
                                                    <input type="number" min="1" max="<?= $sale->quantity_sold ?>"
                                                        value="<?= $sale->quantity_sold; ?>"
                                                        class="form-control text-center quantity" data-qr="<?= $key; ?>"
                                                        name="quantity_returned[]">
                                                </td>
                                                <td>
                                                    <input data-price="<?= $key; ?>" type="hidden" name="price[]" value="<?= $sale->price; ?>">
                                                    <input type="text"
                                                        class="form-control text-center" readonly
                                                        value="<?= number_format($sale->price, 2); ?>" />
                                                </td>
                                                <td class="bg-light">
                                                    <input data-total="<?= $key; ?>" type="text"
                                                        class="form-control text-center" readonly name="total[]"
                                                        value="<?= number_format($sale->quantity_sold * $sale->price, 2); ?>">
                                                </td>
                                                <td>
                                                     <td class="text-center align-middle">
                                                        <i class="far fa-trash-alt text-danger deleteItem"></i>
                                                     </td>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="border-bottom-0"></th>
                                            <th class="text-right">
                                                Total
                                            </th>
                                            <th colspan="2" class="text-center">
                                                <input type="hidden" id="returnTotal" name="returnTotal">
                                                <span>
                                                    <?=
                                                        numfmt_format_currency(
                                                            formatter: new NumberFormatter('en_NG', NumberFormatter::CURRENCY),
                                                            amount: $saleTotal,
                                                            currency: 'NGN'
                                                        );
                                                    ?>
                                                </span>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th colspan="3"></th>
                                            <th class="text-right">
                                                Sale Total
                                            </th>
                                            <th colspan="2" class="text-success text-center">
                                                <input type="hidden" id="saleTotal" name="saleTotal" value="<?= $saleRecord->total_price; ?>">
                                                <span>
                                                    <?=
                                                        numfmt_format_currency(
                                                            formatter: new NumberFormatter('en_NG', NumberFormatter::CURRENCY),
                                                            amount: $saleRecord->total_price,
                                                            currency: 'NGN'
                                                        );
                                                    ?>
                                                </span>
                                            </th>
                                        </tr>

                                        <tr>
                                            <th colspan="3"></th>
                                            <th class="text-right">
                                                Less
                                            </th>
                                            <th colspan="2" class="text-danger text-center">
                                                <span>-</span>
                                                <input type="hidden" id="less" name="less">
                                                <span>
                                                    <?=
                                                        numfmt_format_currency(
                                                            formatter: new NumberFormatter('en_NG', NumberFormatter::CURRENCY),
                                                            amount: $saleRecord->total_price,
                                                            currency: 'NGN'
                                                        );
                                                    ?>
                                                </span>
                                            </th>
                                        </tr>


                                        <tr style="border-top:1px double black;border-bottom:1px double black;">
                                            <th colspan="3"></th>
                                            <th class="text-right">
                                                Net Total
                                            </th>
                                            <th colspan="2" class="text-center">
                                                <input type="hidden" id="netTotal" name="netTotal" value="">
                                                <span>
                                                    <?=
                                                        numfmt_format_currency(
                                                            formatter: new NumberFormatter('en_NG', NumberFormatter::CURRENCY),
                                                            amount: $saleRecord->total_price - $saleTotal,
                                                            currency: 'NGN'
                                                        );
                                                    ?>
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
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
        <?php endif; ?>
    </div>

</section>