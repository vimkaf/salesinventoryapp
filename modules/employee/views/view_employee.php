<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">View Employee</li>
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
                                <h3 class="card-title">Employees</h3>

                                <div class="card-tools"></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Role</th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $id = 1; ?>
                                        <?php foreach ($employees as $employee): ?>
                                            <tr>
                                                <td>
                                                    <?= $id . '.' ?>
                                                </td>
                                                <td>
                                                    <?= $employee->first_name; ?>
                                                </td>
                                                <td>
                                                    <?= $employee->last_name; ?>
                                                </td>
                                                <td>
                                                    <?= $employee->email; ?>
                                                </td>
                                                <td>
                                                    <?= $employee->phone_number; ?>
                                                </td>
                                                <td>
                                                    <?= strtoupper($employee->role); ?>
                                                </td>

                                                <td><a
                                                        href="<?= BASE_URL ?>dashboard/employee/edit/<?= $employee->employee_id; ?>">Edit</a>

                                                </td>
                                                <td><a
                                                        href="<?= BASE_URL ?>dashboard/employee/reset_password/<?= $employee->employee_id; ?>">Reset
                                                        password</a>
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