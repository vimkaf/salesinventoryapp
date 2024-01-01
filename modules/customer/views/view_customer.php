<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View Customers</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">View Customers</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customers</h3>

                                <div class="card-tools">

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Customer Name</th>
                                            <th>Customer Email</th>
                                            <th>Customer Phone Number</th>
                                            <th>Customer Address</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $id = 1; ?>
                                        <?php foreach ($customers as $customer): ?>
                                            <tr>
                                                <td>
                                                    <?= $id . '.' ?>
                                                </td>
                                                <td>
                                                    <?= $customer->first_name . "  " . $customer->last_name; ?>
                                                </td>
                                                <td>
                                                    <?= $customer->email; ?>
                                                </td>
                                                <td>
                                                    <?= $customer->phone_number; ?>
                                                </td>
                                                <td>
                                                    <?= $customer->address; ?>
                                                </td>
                                                <td>
                                                    <a
                                                        href="<?= base_url('dashboard/customer/edit/' . $customer->customer_id); ?>">
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <a
                                                        href="<?= base_url('dashboard/customer/delete/' . $customer->customer_id) ?>">Delete</a>
                                                </td>
                                            </tr>
                                            <?php $id++; ?>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
</section>