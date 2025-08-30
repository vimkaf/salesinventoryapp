<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Site Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Site</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <form action="<?= BASE_URL ?>dashboard/settings/site" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Site Settings</h3>
                        </div>

                        <div class="card-body">
                            <!-- form start -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_name">Site Name</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name"
                                            value="<?= $settings->site_name; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="short_site_name">Short Site Name</label>
                                        <input type="text" class="form-control" id="short_site_name"
                                            name="short_site_name" value="<?= $settings->short_site_name; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rc_number">RC Number</label>
                                        <input type="text" class="form-control" id="rc_number" name="rc_number"
                                            value="<?= $settings->rc_number; ?>">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="<?= $settings->phone_number; ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" name="address"
                                            id="address"><?= $settings->address; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email_address">Email Address</label>
                                        <input type="email" class="form-control" id="email_address" name="email_address"
                                            value="<?= $settings->email_address; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slogan">Slogan/Motto</label>
                                        <input type="text" class="form-control" id="slogan" name="slogan"
                                            value="<?= $settings->slogan; ?>">
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <h4>Sales</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sales_tax">Sales Tax</label>
                                        <select name="sales_tax" id="sales_tax" class="form-control">
                                            <option <?= $settings->sales_tax == 1 ? 'selected' : '' ?> value="1">Enabled
                                            </option>
                                            <option <?= $settings->sales_tax == 0 ? 'selected' : '' ?> value="0">Disabled
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sales_tax_percentage">Tax Percentage</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="sales_tax_percentage"
                                                name="sales_tax_percentage"
                                                value="<?= $settings->sales_tax_percentage; ?>">
                                            <span class="input-group-text">%</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount">Discount</label>
                                        <select name="discount" id="discount" class="form-control">
                                            <option <?= $settings->discount == 1 ? 'selected' : '' ?> value="1">Enabled
                                            </option>
                                            <option <?= $settings->discount == 0 ? 'selected' : '' ?> value="0">Disabled
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tender_mode">Tender Mode</label>
                                        <select name="tender_mode" id="tender_mode" class="form-control">
                                            <option <?= $settings->tender_mode == 'auto' ? 'selected' : '' ?> value="auto">
                                                Auto
                                            </option>
                                            <option <?= $settings->tender_mode == 'manual' ? 'selected' : '' ?>
                                                value="manual">
                                                Manual
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hold_sale">Hold Sale</label>
                                        <select name="hold_sale" id="hold_sale" class="form-control">
                                            <option <?= $settings->hold_sale == 1 ? 'selected' : '' ?> value="1">Enabled
                                            </option>
                                            <option <?= $settings->hold_sale == 0 ? 'selected' : '' ?> value="0">Disabled
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_methods">Payment Methods</label>
                                        <input type="text" name="payment_methods" id="payment_methods"
                                            class="form-control" value="<?= $settings->payment_methods ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4>Printing</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="receipt_multiple_printing">Receipts Multiple Printing</label>
                                        <select name="receipt_multiple_printing" id="receipt_multiple_printing"
                                            class="form-control">
                                            <option <?= $settings->receipt_multiple_printing == 1 ? 'selected' : '' ?>
                                                value="1">Enabled
                                            </option>
                                            <option <?= $settings->receipt_multiple_printing == 0 ? 'selected' : '' ?>
                                                value="0">Disabled
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pos_receipt_paper_size">POS receipt paper size</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="pos_receipt_paper_size"
                                                name="pos_receipt_paper_size"
                                                value="<?= $settings->pos_receipt_paper_size; ?>">
                                            <span class="input-group-text">mm</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>