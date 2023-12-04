<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">List Warehouse</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL."/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Warehouse</li>
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
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Warehouse Name</th>
                      <th>Warehouse Code</th>
                      <th>Warehouse Location</th>
                      <th>Warehouse Adress</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $id=1; ?>
                    <?php foreach($warehouses as $warehouse):?>
                      <tr>
                        <td><?= $id.'.'?></td>
                        <td><?= $warehouse->warehouse_name;?></td>
                        <td><?= $warehouse->warehouse_code;?></td>
                        <td><?= $warehouse->warehouse_location;?></td>
                        <td><?= $warehouse->warehouse_address; ?></td>
                        <td><a href="/dashboard/warehouse/edit/<?= $warehouse->warehouse_id;?>">Edit</a></td>
                        <td><a href="/dashboard/warehouse/delete/<?= $warehouse->warehouse_id;?>">Delete</a></td>
                      </tr>
                      <?php $id++;?>
                    <?php endforeach;?>
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
