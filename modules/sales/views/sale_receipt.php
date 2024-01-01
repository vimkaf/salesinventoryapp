<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard/sales/list') ?>">Sales</a></li>

                    <li class="breadcrumb-item active">Receipt</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header d-print-none">
                <h3 class="card-title">Sale Receipt</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-secondary " onclick="javascript:window.print()">
                        <i class="fas fa-print"></i>
                        Print
                    </button>

                    <a target="_blank" href="<?= base_url('dashboard/receipts/pos_receipt/' . $receipt->receipt_id) ?>"
                        class="btn btn-secondary">
                        <i class="fas fa-print"></i>
                        POS Receipt
                    </a>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-7 d-flex" style="gap:10px;">
                        <div>
                            <img class="img-thumbnail d-block" src="<?= base_url(SITE_LOGO) ?>" alt="Site Logo"
                                width="100px" height="100px">
                            <small>
                                RC:
                                <?= RC_NUMBER; ?>
                            </small>
                        </div>
                        <div class="text-left">
                            <h4 class="font-weight-bold m-0">
                                <?= SITE_NAME; ?>
                            </h4>
                            <small style="font-size:1em">
                                <?= SLOGAN ?>
                            </small>
                        </div>
                    </div>

                    <div class="col-5">
                        <h4 class="text-secondary font-weight-bolder text-right">Sales Receipt</h4>
                        <table style="border:1px solid black;width:80%;float:right;">
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Date
                                </td>
                                <td style="border:1px solid black;">
                                    <?= date("M d, Y", strtotime($sale->date_of_sale)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Receipt #
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $receipt->receipt_number; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col-6">
                        <table style="border:1px solid black;width:80%;">
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Customer
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $customer->first_name; ?>
                                    <?= $customer->last_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Phone
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $customer->phone_number; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-6">
                        <table style="border:1px solid black;width:80%;float:right;">
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Branch
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $warehouse->warehouse_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;font-weight:bold;">
                                    Address
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $warehouse->warehouse_address; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-12 justify-content-around ">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="bg-dark ">
                                    <th>Code</th>
                                    <th>Product</th>
                                    <th class="text-center ">Quantity</th>
                                    <th class="text-center ">Unit price</th>
                                    <th class="text-center ">Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($saleItems as $item): ?>
                                    <tr>
                                        <td style="border:1px solid black;">
                                            <?= $item->product_code; ?>
                                        </td>
                                        <td style="border:1px solid black;">
                                            <?= $item->product_name; ?>
                                        </td>
                                        <td style="border:1px solid black;" class="text-center ">
                                            <?= number_format($item->quantity_sold); ?>
                                            <?= $item->unit; ?>
                                        </td>
                                        <td style="border:1px solid black;" class="text-center ">
                                            <?= numfmt_format_currency($numberFormat, $item->price, "NGN"); ?>
                                        </td>
                                        <td class="text-center " style="border:1px solid black;">
                                            <?= numfmt_format_currency($numberFormat, $item->quantity_sold * $item->price, "NGN"); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border:1px solid black;border-bottom:0;" colspan="3"></td>
                                    <td class="text-right " style="border:1px solid black;">
                                        <strong>Sub-Total</strong>
                                    </td>
                                    <td class="text-center " style="border:1px solid black;">
                                        <?= numfmt_format_currency($numberFormat, $sale->total_price, "NGN"); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid black;border-bottom:0;" colspan="3"></td>
                                    <td class="text-right " style="border:1px solid black;">
                                        <strong>Tax</strong>
                                    </td>
                                    <td class="text-center " style="border:1px solid black;">
                                        <?= numfmt_format_currency($numberFormat, $sale->tax, "NGN"); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid black;" colspan="3"></td>
                                    <td class="text-right " style="border:1px solid black;">
                                        <strong>Discount</strong>
                                    </td>
                                    <td class="text-center " style="border:1px solid black;">
                                        <?= numfmt_format_currency($numberFormat, $sale->discount, "NGN"); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="border:1px solid black;"></td>
                                    <td class="text-right " style="border:1px solid black;">
                                        <strong>Grand Total</strong>
                                    </td>
                                    <td class="text-center " style="border:1px solid black;">
                                        <?= numfmt_format_currency($numberFormat, ($sale->total_price + $sale->tax) - $sale->discount, "NGN"); ?>

                                    </td>
                                </tr>

                            </tfoot>
                        </table>


                    </div>

                    <div class="col-6">
                        <table style="width:80%;" class="float-left">
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="font-weight-bold ">Sale made by: </span>
                                </td>
                                <td style="border:1px solid black;">
                                    <?= $employee->first_name ?>
                                    <?= $employee->last_name ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="font-weight-bold ">Payment Status </span>
                                </td>
                                <td style="border:1px solid black;">
                                    <?= strtoupper($sale->status); ?>
                                </td>
                            </tr>
                        </table>


                    </div>

                    <div class="col-6">
                        <table style="width:80%" class="float-right">
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="font-weight-bold ">
                                        Amount paid:
                                    </span>
                                </td>
                                <td style="border:1px solid black;">
                                    <?= numfmt_format_currency($numberFormat, $receipt->amount, 'NGN') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="font-weight-bold ">
                                        Total Payments:
                                    </span>
                                </td>
                                <td style="border:1px solid black;">
                                    <?= numfmt_format_currency($numberFormat, $total_payments, 'NGN') ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="font-weight-bold ">
                                        Balance
                                    </span>
                                </td>
                                <td style="border:1px solid black;">
                                    <?= numfmt_format_currency($numberFormat, $receipt->balance, 'NGN') ?>
                                </td>
                            </tr>


                        </table>
                    </div>

                </div>

                <div class="row">
                    <div class="col-6">
                        <table style="width:80%">
                            <tr>
                                <td style="border:1px solid black;" colspan="2"><strong>Payment Method</strong></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="">
                                        Cash
                                    </span>
                                </td>
                                <td style="border:1px solid black;text-align:center;">
                                    <?php if ($receipt->payment_method === 'cash'): ?>
                                        <i class="fas fa-check"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="">
                                        Bank Transfer
                                    </span>
                                </td>
                                <td style="border:1px solid black;text-align:center;">
                                    <?php if ($receipt->payment_method === 'bank'): ?>
                                        <i class="fas fa-check"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid black;">
                                    <span class="">
                                        Card
                                    </span>
                                </td>
                                <td style="border:1px solid black;text-align:center;">
                                    <?php if ($receipt->payment_method === 'card'): ?>
                                        <i class="fas fa-check"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-md" style="text-align:center;padding:10px;">
                        <span>
                            Should you have any enquiries about this receipt you can reach out to us through any of
                            the medium below
                        </span>
                        <hr style="margin:0">
                        <p style="margin:0;">
                            <?= ADDRESS ?>
                        </p>
                        <span>Tel:
                            <?= PHONE_NUMBER; ?>
                        </span>
                        |
                        <span>Email:
                            <?= EMAIL_ADDRESS; ?>
                        </span>
                        |
                        <span>
                            Website:
                            <?= BASE_URL; ?>

                        </span>
                        <hr style="margin:0">
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
        </div>
    </div>

</section>