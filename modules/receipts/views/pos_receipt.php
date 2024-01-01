<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        <?= $page_title ?>
    </title>

    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width:
                <?= POS_RECEIPT_PAPER_SIZE ?>
            ;
            background: #FFF;
        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: 0.7em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        p {
            font-size: 0.7em;
            color: #666;
            line-height: 1.2em;
        }

        #invoice-POS #top,
        #invoice-POS #mid,
        #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS #top {
            min-height: 100px;
            text-align: center;
        }

        #invoice-POS #mid {
            text-align: center;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .logo {
            height: 50px;
            width: 50px;
            background: url(<?= base_url(SITE_LOGO); ?>) no-repeat;
            background-size: 50px 50px;
            margin: 0 auto;
            border-radius: 50px;

        }



        #invoice-POS .info {
            display: block;
            margin-left: 0;

        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: 0.5em;
            background: #EEE;
        }

        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS .border-double-bottom {
            border-bottom: 1px double #000;
        }

        #invoice-POS .border-double-top {
            border-top: 1px double #000;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .itemtext {
            font-size: 0.5em;
            margin: 0;
        }

        #invoice-POS #legalcopy {
            margin-top: 5mm;
            text-align: center;
            font-size: 0.8em;

        }
    </style>
</head>

<body>
    <div id="invoice-POS">

        <div id="top">
            <div class="logo"></div>
            <div class="info">
                <h2>
                    <?= SITE_NAME ?>
                </h2>
            </div><!--End Info-->
        </div><!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <p class="itemtext" style="text-align:left;">
                    Branch:
                    <?= $warehouse->warehouse_name; ?></br>
                    Address :
                    <?= $warehouse->warehouse_address; ?></br>
                </p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">

            <div id="table">
                <table>
                    <tr>
                        <td class="itemtext" style="float:left">
                            #
                            <?= $receipt->receipt_number; ?>
                        </td>
                        <td class="itemtext" style="float:right">
                            Date:
                            <?= date("M d, Y", strtotime($receipt->date)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="itemtext" style="float:left">
                            Customer:
                            <?= "{$customer->first_name} {$customer->last_name}"; ?>
                        </td>

                    </tr>

                </table>
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Product</h2>
                        </td>
                        <td class="Hours">
                            <h2>Qty</h2>
                        </td>
                        <td class="Rate">
                            <h2>Total</h2>
                        </td>
                    </tr>

                    <?php foreach ($saleItems as $item): ?>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">
                                    <?= $item->product_name; ?>
                                </p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">
                                    <?= $item->quantity_sold; ?>
                                    <small>
                                        <?= $item->unit; ?>
                                    </small>
                                </p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">
                                    <?= numfmt_format_currency($numberFormat, $item->price * $item->quantity_sold, 'NGN'); ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr class="service border-double-top border-double-bottom">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                S/Total
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $sale->total_price, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="service">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                Tax
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $sale->tax, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="service">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                Discount
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $sale->discount, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="service border-double-top border-double-bottom">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                G/Total
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, ($sale->total_price + $sale->tax) - $sale->discount, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr class="service">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                AP
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $receipt->amount, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="service">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                TP
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $total_payments, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="service border-double-top border-double-bottom">
                        <td></td>
                        <td>
                            <p class="itemtext">
                                Balance
                            </p>
                        </td>
                        <td>
                            <p class="itemtext">
                                <?= numfmt_format_currency($numberFormat, $receipt->balance, 'NGN'); ?>
                            </p>
                        </td>
                    </tr>



                </table>

                <table>
                    <tr>

                        <td class="itemtext" style="float:left">
                            Received by:
                            <?= "{$employee->first_name} {$employee->last_name}"; ?>
                        </td>

                    </tr>
                </table>

            </div><!--End Table-->

            <div id="legalcopy">
                <p class="legal">
                    <strong>Thank you for your patronage!</strong>
                    <br>
                    <span>
                        Should you have any enquiries about this receipt you can reach out to us through any of
                        the medium below
                    </span>
                    <br>
                    <span>Tel:
                        <?= PHONE_NUMBER; ?>
                    </span>
                    <br>
                    <span>Email:
                        <?= ADDRESS; ?>
                    </span>
                    <br>
                    <span>
                        Website:
                        <?= BASE_URL; ?>

                    </span>
                </p>

            </div>

        </div><!--End InvoiceBot-->
    </div><!--End Invoice-->
</body>

</html>


<script>
    document.addEventListener('DOMContentLoaded', (ev) => {
        window.print();
    });
</script>