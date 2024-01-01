<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Update Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Update Employee</li>
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
                <form action="<?= base_url('dashboard/employee/edit/' . $employee[0]->employee_id) ?>" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Employee</h3>
                        </div>

                        <div class="card-body">
                            <!-- form start -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input value="<?= $employee[0]->first_name; ?>" type="text" class="form-control"
                                            placeholder="First Name" name="first_name" required>
                                        <input value="<?= $employee[0]->employee_id; ?>" type="hidden"
                                            name="employee_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Last Name</label>
                                        <input value="<?= $employee[0]->last_name; ?>" type="text" class="form-control"
                                            placeholder="Last Name" name="last_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Warehouse</label>
                                        <select name="warehouse" class="form-control">
                                            <?php foreach ($warehouses as $warehouse): ?>
                                                <option <?= $warehouse->warehouse_id === $employee[0]->warehouse_id ? 'selected' : ''; ?> value="<?= $warehouse->warehouse_id ?>">
                                                    <?= $warehouse->warehouse_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Role</label>
                                        <select name="role" class="form-control" required>
                                            <?php foreach ($roles as $role): ?>
                                                <option <?= $employee[0]->role === $role->level_title ? 'selected' : ''; ?>
                                                    value="<?= $role->id; ?>">
                                                    <?= $role->level_title; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email</label>
                                        <input value="<?= $employee[0]->email; ?>" type="email" class="form-control"
                                            placeholder="Email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Phone Number</label>
                                        <input value="<?= $employee[0]->phone_number; ?>" type="text"
                                            class="form-control" placeholder="Phone Number" name="phone_number"
                                            required>
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