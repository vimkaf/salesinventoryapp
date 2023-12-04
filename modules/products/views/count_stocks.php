<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Count Stocks</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Count Stocks</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <div class="card-body">
                <form action="/products/stock" method="POST">
                <div class="row">
                    <div class="col-3">
                        <label for="">Warehouse *</label>
                        <div class="input-group">
                            <select name="warehouse" id="" class="form-control">
                                <option value="">warehouse1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="">Date *</label>
                        <div class="input-group">
                          <input type="date" class="form-control" name="date">                            
                        </div>
                    </div>
                    <div class="col-5">
                        <label>Reference *</label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Reference" name="reference">                            
                        </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                      <label for="">Type</label></br>
                        Fill<input type="radio" value="full" name="type">
                        Partial<input type="radio" value="partial" name="type">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12"><button type="submit" class="btn btn-primary">Submit</button></div>
                </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
