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
                <form action="<?= BASE_URL ?>dashboard/products/add_category" method="post">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product Category</h3>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="alert alert-info bg-light col">
                                    <p>Field marked with <span class="required_field">*</span> are required</p>
                                </div>
                            </div>

                            <!-- form start -->
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Category Name
                                            <span class="required_field">*</span>
                                        </label>
                                        <input type="text" class="form-control" placeholder="Example: Stationaries" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Description <span class="required_field">*</span>
                                        </label>
                                        <textarea class="form-control" name="description" id="" cols="10" rows="5"></textarea>
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