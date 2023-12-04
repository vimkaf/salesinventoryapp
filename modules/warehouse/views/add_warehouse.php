<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add Warehouse</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Add Warehouse</li>
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
        <form action="/warehouse/add" method="post">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Warehouse</h3>
          </div>

          <div class="card-body">
            <!-- form start -->
              <div class="row justify-content-around">
                <div class="col-md-5">
                    <div class="form-group">
                      <label>Warehouse Code</label>
                      <input type="text" class="form-control" placeholder="Code" name="warehouse_code" required>
                    </div>
                    <div class="form-group">
                        <label>Warehouse Location</label>
                      <input type="text" class="form-control" placeholder="Location" name="warehouse_location" required>
                    </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                  <label>Warehouse Name</label>
                      <input type="text" class="form-control" placeholder="Name" name="warehouse_name" required>
                  </div>
                  <div class="form-group">
                    <label>Warehouse Address</label>
                    <input type="text" class="form-control" placeholder="Address" name="warehouse_address" required>
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