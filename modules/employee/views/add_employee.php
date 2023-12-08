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
        <form action="/employee/add" method="post">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Employee</h3>
          </div>

          <div class="card-body">
            <!-- form start -->
              <div class="row justify-content-around">
                <div class="col-md-5">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Firs Name</label>
                      <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Last Name</label>
                      <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Email</label>
                      <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Phone Number</label>
                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" required>
                    </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Role</label>
                    <select name="role" class="form-control" required>
                      <?php foreach($roles as $role):?>
                        <option value="<?= $role->level_title;?>"><?= $role->level_title;?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Member</label>
                    <input type="number" class="form-control" placeholder="Member" name="member_id" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Trongate_user_id</label>
                    <input type="number" class="form-control" placeholder="trongate_user_id" name="trongate_user_id" required>
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