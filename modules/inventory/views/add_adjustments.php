<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Adjustment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Adjustment</li>
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
                <form action="/products/add_adjustments" enctype="multipart/form-data" method="POST">
                <div class="row" enc>
                    <div class="col-3">
                        <label for="">product *</label>
                        <div class="input-group">
                            <select class="form-control" name="product_id">                                
                                <?php foreach($products as $product):?>
                                    <option value="<?= $product->product_id;?>"><?= $product->product_name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="">warehuse *</label>
                        <div class="input-group">
                            <select name="warehouse_id" class="form-control">
                                <?php foreach($warehouses as $warehouse):?>
                                    <option value="<?= $warehouse->warehouse_id;?>"><?= $warehouse->warehouse_name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="">Action *</label>
                        <div class="input-group">
                            <select name="action" class="form-control">
                                <option value="add">ADD</option>
                                <option value="remove">REMOVE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="">Quantity *</label>
                        <div class="input-group">
                                <input type="number" placeholder="Number Quantity" class="form-control" name="quantity">                              
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group">
                            <input type="text" class="form-control mt-3" placeholder="Remark Note" name="remark">
                        </div>
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
