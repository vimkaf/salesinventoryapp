<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Employee</li>
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
                <form action="<?= base_url('dashboard/employee/add') ?>" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Employee</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light  text-info ">
                                <p>
                                    The last 4 digits of this employees phone number will be used as the login password
                                    while the username is the complete phone number
                                </p>
                            </div>
                            <!-- form start -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input type="text" class="form-control" placeholder="First Name"
                                            name="first_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Last Name" name="last_name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Warehouse</label>
                                        <select name="warehouse" class="form-control">
                                            <?php foreach ($warehouses as $warehouse): ?>
                                                <option value="<?= $warehouse->warehouse_id ?>">
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
                                                <option value="<?= $role->id; ?>">
                                                    <?= strtoupper($role->level_title); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone Number"
                                            name="phone_number" required>
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