<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales Receipts</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Sales</a></li>
                    <li class="breadcrumb-item active">Receipts</li>
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
                                <h3 class="card-title">Sale Receipts</h3>

                                <div class="card-tools">
                                    <?php if ($sale->status !== "full"): ?>
                                        <button data-toggle="modal" data-target="#paymentModal"
                                            class="btn btn-sm btn-secondary " type="button">Add payment</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-sm mb-3">
                                    <tr>
                                        <td>Sale Total</td>
                                        <td>
                                            <?= numfmt_format_currency($numberFormat, $sale->total_price, 'NGN'); ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td>
                                            <?= numfmt_format_currency($numberFormat, $sale->tax, 'NGN'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>
                                            <?= numfmt_format_currency($numberFormat, $sale->discount, 'NGN'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grand Total</td>
                                        <td>
                                            <?= numfmt_format_currency($numberFormat, ($sale->total_price + $sale->tax) - $sale->discount, 'NGN'); ?>
                                        </td>
                                    </tr>
                                </table>

                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Receipt Number</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($receipts as $receipt): ?>

                                            <?php
                                            $total_amount += $receipt->amount;
                                            $total_balance += $receipt->balance;
                                            ?>


                                            <tr>
                                                <td>
                                                    <?= date("M d, Y", strtotime($receipt->date)) ?>
                                                </td>
                                                <td>
                                                    <a
                                                        href="<?= base_url('dashboard/sales/receipt/' . $receipt->receipt_id) ?>">
                                                        <?= "{$receipt->receipt_number}" ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= numfmt_format_currency($numberFormat, $receipt->amount, 'NGN'); ?>
                                                </td>
                                                <td>
                                                    <?= numfmt_format_currency($numberFormat, $receipt->balance, 'NGN'); ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th>
                                                <?= numfmt_format_currency($numberFormat, $total_amount, 'NGN'); ?>
                                            </th>
                                            <th>
                                                <?= numfmt_format_currency($numberFormat, $total_balance, 'NGN'); ?>
                                            </th>
                                            <th>
                                                <?= numfmt_format_currency($numberFormat, $sale->grand_total - $total_amount, 'NGN'); ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


    </div>

    <div class="modal fade" id="paymentModal">
        <form action="<?= base_url('dashboard/sales/add_payment/'); ?>" method="post">

            <input type="hidden" name="sale_id" value="<?= $sale->sale_id; ?>">
            <div class="modal-dialog modal-dialog-centered ">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Payment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                </div>

                                <input required type="date" name="date" class="form-control">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&#8358;</span>
                                </div>

                                <input required type="text" name="amount" class="form-control currency-mask">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Payment Method</label>

                            <select name="method" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="transfer">Bank Transfer</option>
                                <option value="card">Card</option>
                            </select>
                        </div>
                    </div>


                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add payment</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>

    </div>
    <!-- /.modal -->
</section>