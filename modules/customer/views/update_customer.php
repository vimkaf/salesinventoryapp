<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Update Custoer</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Update Customer</li>
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
        <form action="/customer/update" method="post">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Update Customer</h3>
          </div>

          <div class="card-body">
            <!-- form start -->
              <div class="row justify-content-around">
                <div class="col-md-5">
                    <div class="form-group">
                      <label for="exampleInputEmail1">First Name</label>
                      <input value="<?= $customer[0]->first_name;?>" type="text" class="form-control" placeholder="First Name" name="first_name" required>
                      <input value="<?= $customer[0]->customer_id;?>" type="hidden" name="customer_id">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Last Name</label>
                      <input value="<?= $customer[0]->last_name;?>" type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Email</label>
                      <input value="<?= $customer[0]->email;?>" type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone Number</label>
                    <input value="<?= $customer[0]->phone_number;?>" type="text" class="form-control" placeholder="Phone Number" name="phone_number" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input value="<?= $customer[0]->address;?>" type="text" class="form-control" placeholder="Address" name="address" required>
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