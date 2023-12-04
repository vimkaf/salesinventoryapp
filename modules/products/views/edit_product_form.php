<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= BASE_URL . "/" ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Edit Product</li>
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
        <form action="/dashboard/products/edit/<?= $product->product_id?>" enctype="multipart/form-data" method="post">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Product</h3>
            </div>

            <div class="card-body">
              <!-- form start -->
                <div class="row justify-content-around">
                  <div class="col-md-5">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Product Name</label>
                        <input value="<?= $product->product_name?>" type="text" class="form-control" placeholder="Product Name" name="product_name" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Product Price</label>
                        <input value="<?= $product->product_price?>" type="number" class="form-control" placeholder="Product Price" name="product_price" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Product Code</label>
                        <input value="<?= $product->product_code?>" type="text" class="form-control" placeholder="Product Code" name="product_code" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile">Product Image</label></br>
                        <img class="profile-user-img img-fluid mb-2" 
                        src="<?= BASE_URL;?>/uploads/<?=$product->product_image?>" alt="User profile picture">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="product_image">
                            <label class="custom-file-label">Choose Image</label>
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="col-md-5">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Category</label>
                      <select name="category_id" id="" class="form-control" required>
                        <option value="">Category</option>
                        <?php foreach ($categories as $category) : ?>
                          <option <?= $product->category_id === $category->category_id ? 'selected':'';?> value="<?= $category->category_id?>">
                          <?= $category->category_name; ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Product Brand</label>
                      <input value="<?= $product->brand?>" type="text" class="form-control" placeholder="Product Brand" name="brand" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Product Model</label>
                      <input value="<?= $product->model?>" type="text" class="form-control" placeholder="Product Model" name="model" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Product Unit</label>
                      <input value="<?= $product->unit?>" type="text" class="form-control" placeholder="Product Unit" name="unit" required>
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