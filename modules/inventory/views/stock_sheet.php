<section class="content mt-4">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Stock Sheet</h3>

                <div class="float-right">
                    <a href="#" class="card-link" data-bs-toggle="">
                        <i class="fa fa-print"></i>
                    </a>
                    <a href="#" class="card-link" data-toggle="modal" data-target="#filterModal">
                        <i class="fa fa-calendar-alt"></i>
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 justify-content-around ">
                        <table class="table table-bordered table-sm table-striped" id="stockSheet">
                            <thead>

                                <tr class="border-0 ">
                                    <th></th>
                                    <th colspan="5">
                                        Daily Stock Sheet
                                    </th>
                                </tr>
                                <tr class="border-0">
                                    <th>Date</th>
                                    <th colspan="5">
                                        Date: <?= date("M d, Y") ?>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Code</th>
                                    <th>Product</th>
                                    <th>Opening Stock</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Closing Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stock_sheet as $ss): ?>
                                    <tr>
                                        <td><?= $ss['code'] ?></td>
                                        <td><?= $ss['product'] ?></td>
                                        <td><?= "{$ss['openingStock']} {$ss['productUnit']}"; ?></td>
                                        <td><?= "{$ss['stockIn']} {$ss['productUnit']}"; ?></td>
                                        <td><?= "{$ss['stockOut']} {$ss['productUnit']}"; ?></td>
                                        <td>
                                            <?= $ss['openingStock'] + $ss['stockIn'] - $ss['stockOut']; ?>
                                            <?= $ss['productUnit'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Prepared by</th>
                                    <th colspan="5" class="text-uppercase">
                                        <?= $_SESSION['employee']->first_name . " " . $_SESSION['employee']->last_name; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Verified by</th>
                                    <th colspan="5"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</section>

<!-- Bootstrap Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pick date</h5>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('dashboard/sales/stock_sheet') ?>" method="GET">
                    <div class="form-group">
                        <input required type="date" name="date" id="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success" data-dismiss="modal">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>