<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales Record</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Sales</a></li>

                    <li class="breadcrumb-item active">Sales Record</li>
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
                                <form action="<?= base_url('dashboard/sales/filter_pos_report') ?>" method="get">
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <input type="text" name="salenumber" class="form-control"
                                                placeholder="Enter sale number">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <input type="text" name="receipt_number" class="form-control"
                                                placeholder="Enter receipt number">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <input type="date" name="from_date" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <input type="date" name="to_date" class="form-control">

                                        </div>

                                        <div class="form-group col-md-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
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
                                <h3 class="card-title">
                                    <?= $page_title ?>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>WareHouse</th>
                                            <th>Total</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $totalSales = 0; ?>
                                        <?php foreach ($sales as $key => $sale): ?>
                                            <?php $totalSales += $sale->grand_total; ?>

                                            <tr data-row-id="<?= $sale->sale_id; ?>">
                                                <td>
                                                    <a href="#" class="saleRow" data-sale-id="<?= $sale->sale_id; ?>">
                                                        <?= $sale->sale_number; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= date("M d, Y", strtotime($sale->date_of_sale)) ?>
                                                </td>
                                                <td>
                                                    <?= "{$sale->customer_first_name} {$sale->customer_last_name}" ?>
                                                </td>
                                                <td>
                                                    <?= $sale->warehouse_name ?>
                                                </td>
                                                <td>
                                                    <?= numfmt_format_currency($numberFormat, $sale->grand_total, 'NGN'); ?>
                                                </td>
                                                <td>
                                                    <?= numfmt_format_currency($numberFormat, $sale->total_amount_paid, 'NGN'); ?>
                                                </td>
                                                <td>
                                                    <?= numfmt_format_currency($numberFormat, $sale->grand_total - $sale->total_amount_paid, 'NGN'); ?>
                                                </td>
                                                <td>
                                                    <?= strtoupper($sale->status) ?>
                                                </td>
                                                <td>
                                                    <a target="_blank"
                                                        href="<?= base_url('dashboard/receipts/pos_receipt/' . $sale->receipt_id) ?>">
                                                        <i class="fas fa-file-alt"></i>
                                                        Receipts
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <th>
                                                <?= numfmt_format_currency($numberFormat, $totalSales, 'NGN'); ?>
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
</section>

<div class="modal fade" id="saleItemsModal">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sale Items</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped" id="saleItemsTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->