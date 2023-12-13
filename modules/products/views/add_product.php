<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Products</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Product</li>
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
                <form action="<?= BASE_URL ?>dashboard/products/add" enctype="multipart/form-data" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="alert alert-info bg-light col">
                                    <p>Field marked with <span class="required_field">*</span> are required</p>
                                </div>
                            </div>

                            <!-- form start -->
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Product Name
                                            <span class="required_field">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Product Name" name="product_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Product Price <span class="required_field">*</span>
                                        </label>
                                        <input type="number" class="form-control" placeholder="Product Price" name="product_price" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Product Code <span class="required_field">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Product Code" name="product_code" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Product Image(Max size: 2MB)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_image">
                                                <label class="custom-file-label">Choose Image</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Category <span class="required_field">*</span>
                                        </label>
                                        <select name="category_id" id="" class="form-control" required>
                                            <option value="">Category</option>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?= $category->category_id; ?>"><?= $category->category_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Product Brand</label>
                                        <input type="text" class="form-control" placeholder="Product Brand" name="brand">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Product Model</label>
                                        <input type="text" class="form-control" placeholder="Product Model" name="model">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Product Unit <span class="required_field">*</span>
                                        </label>
                                        <select name="unit" id="unit" class="form-control" required>
                                            <option value="">Pick a unit for the product</option>
                                            <option value="pcs">Pieces</option>
                                            <option value="bag">Bag</option>
                                            <option value="kg">Kilogram</option>
                                            <option value="carton">Carton</option>
                                        </select>
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