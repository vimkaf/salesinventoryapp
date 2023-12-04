<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Sales</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Sales</li>
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
                <form action="/sales/save_sales" method="POST">
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <label for="">Costomer *</label>
                            <div class="input-group">
                                <select name="customer_id" id="" class="form-control">
                                    <?php foreach($customers as $customer):?>
                                        <option value="<?= $customer->customer_id ?>"><?= $customer->first_name." ".$customer->last_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="">Warehouse *</label>
                            <div class="input-group">
                                <select name="warehouse_id" class="form-control">
                                    <?php foreach($warehouses as $warehouse):?>
                                        <option value="<?= $warehouse->warehouse_id;?>"><?= $warehouse->warehouse_name;?></option>
                                    <?php  endforeach;?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 justify-content-around ">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <td>S/N</td>
                                        <td>PRODUCT</td>
                                        <td>QUANTITY</td>
                                        <td>PRICE</td>
                                        <td>TOTAL</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sn = 1;?>
                                    <tr>
                                        <th><?php echo $sn;?></th>
                                        <th>
                                            <select name="product[]" id="" class="form-control">
                                                <?php foreach($products as $product):?>
                                                    <option value=""><?= $product->product_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </th>
                                        <th><input type="text" name="quantity[]"></th>
                                        <th><input type="text" name="price[]"></th>
                                        <th><input type="text" name="total[]"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <label for="">Amount *</label>
                            <div class="input-group">
                                <input type="text" name="amount[]">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="">Method *</label>
                            <div class="input-group">
                                <select name="status" id="" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="POS">POST</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12"><button type="submit" class="btn btn-primary">Save</button></div>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
