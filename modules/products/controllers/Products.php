<?php

use League\Csv\Reader;

class Products extends Trongate
{

    //list products
    function _list()
    {
        $this->getlistproduct();
    }

    function getlistproduct()
    {
        $sql = "SELECT * FROM products 
        LEFT JOIN categories ON products.category_id = categories.category_id
        ORDER BY product_id DESC
        ";
        $products = $this->model->query($sql, 'object');

        $pagination_data['total_rows'] = count($products);
        $pagination_data['page_num_segment'] = 4;
        $pagination_data['limit'] = 1;
        $pagination_data['pagination_root'] = 'dashboard/products/list';
        $pagination_data['include_showing_statement'] = true;
        $pagination_data['record_name_plural'] = 'products';
        $pagination_data['include_css'] = true;

        $data['pagination_data'] = $pagination_data;

        $data['products'] = $products;
        $data['page_title'] = 'Products List';
        $data['view_file'] = 'list_products';
        $data['view_module'] = 'products';


        $this->template('dashboard', $data);
    }


    //add products
    function _add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->addproductsform();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveproducts();
        }
    }

    function addproductsform()
    {

        $sql = "SELECT * FROM categories";
        $categories = $this->model->query($sql, 'object');

        $data = [
            'categories' => $categories
        ];
        $data['page_title'] = "Add Product";
        $data['view_file'] = 'add_product';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }

    function _upload_product_image($product_name, $product_code = null)
    {

        $imageName = is_null($product_code) ? $product_name : $product_code;

        $image = $_FILES['product_image'];

        $originameimagename = $image['name'];
        $splitedstring = explode('.', $originameimagename);
        $extension = '.' . $splitedstring[count($splitedstring) - 1];
        $path = 'uploads/products/';
        $name = str_replace(" ", "_", $imageName);
        $newimagename = $path . $name . $extension;
        $imagename = $name . $extension;

        $image_uploaded =  move_uploaded_file($image['tmp_name'], $newimagename);

        if ($image_uploaded) {
            return $imagename;
        }

        return false;
    }



    /**
     * Insert the product data into the database
     */
    function saveproducts()
    {

        if ($_FILES['product_image']['size'] === 0) {
            $image_uploaded = "blank.jpg";
        } else {
            $image_uploaded = $this->_upload_product_image(post('product_name'),  post('product_code'));
        }


        if ($image_uploaded === false) {
            set_flashdata([
                'type' => 'error',
                'message' => 'Product image failed to upload'
            ]);

            redirect('products/add');
        }

        $data['product_name'] = post('product_name');
        $data['product_price'] = post('product_price');
        $data['product_code'] = post('product_code');
        $data['product_image'] = $image_uploaded;
        $data['category_id'] = post('category_id');
        $data['brand'] = post('brand');
        $data['model'] = post('model');
        $data['unit'] = post('unit');

        $this->model->insert($data, 'products');


        set_flashdata([
            'type' => 'success',
            'message' => 'Product has been added successfully'
        ]);

        redirect('dashboard/products/list');
    }

    //edit 
    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->show_edit_product_form($id);
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_update_product($id);
        }
    }

    function show_edit_product_form($id)
    {
        $product = $this->model->get_one_where('product_id', $id);

        $sql = "SELECT * FROM categories";
        $categories = $this->model->query($sql, 'object');

        if ($product === false) {
            redirect('/dashboard/products/list');
            exit();
        }

        $data = [
            'product' => $product,
            'categories' => $categories
        ];
        $data['page_title'] = "Edit Product";
        $data['view_file'] = "edit_product_form";
        $data['view_module'] = "products";
        $this->template('dashboard', $data);
    }

    function _update_product($id)
    {
        $image = $_FILES['product_image'];


        if ($image['error'] == 0) {

            $image_name = $this->_upload_product_image(post('product_name'), post('product_code'));

            if (is_bool($image_name)) {

                set_flashdata([
                    'type' => 'error',
                    'message' => 'Product image could not be uploaded'
                ]);

                redirect('dashboard/products/edit/' . $id);
            }

            $data['product_image'] = $image_name;
        }



        $data['product_name'] = post('product_name');
        $data['product_price'] = post('product_price');
        $data['product_code'] = post('product_code');
        $data['category_id'] = post('category_id');
        $data['brand'] = post('brand');
        $data['model'] = post('model');
        $data['unit'] = post('unit');



        $this->model->update_where('product_id', $id, $data, 'products');

        set_flashdata([
            'type' => 'success',
            'message' => 'Product has been updated successfully'
        ]);

        redirect('dashboard/products/edit/' . $id);
    }

    //delete
    function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->_delete_product($id);
        }
    }
    function _delete_product($id)
    {
        $sql = "SELECT * FROM inventory WHERE product_id = :id";

        $data = [
            'id' => $id
        ];

        $product = $this->model->query_bind($sql, $data, 'object');

        $data = [
            'product' => $product
        ];

        if (!empty($product->product_id)) {

            set_flashdata([
                'type' => 'error',
                'message' => 'Product List failed to Delete, inventory already have products'
            ]);

            redirect('dashboard/products/list');
        }

        $query = "DELETE FROM products WHERE product_id = :id";

        $this->model->query_bind($query, ['id' => $id], 'object');

        set_flashdata([
            'type' => 'success',
            'message' => 'Product have been deleted'
        ]);

        redirect('dashboard/products/list');
    }

    //import products
    function _import()
    {

        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->getimport_products();
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->import_product();
        }
    }
    function getimport_products()
    {
        $categories = $this->model->query('SELECT * FROM categories', 'object');

        $data['page_title'] = 'Import Products';
        $data['view_file'] = 'import_products';
        $data['view_module'] = 'products';
        $data['categories'] = $categories;

        $this->template('dashboard', $data);
    }

    function import_product()
    {

        $category_id = post('category');

        //upload the file
        $config['destination'] = '../public/uploads/temp';
        $config['make_rand_name'] = true;

        //upload file
        $fileInfo = $this->upload_file($config);

        //load the CSV document from a file path
        $path = CONFIG_PATH . DIRECTORY_SEPARATOR . $fileInfo['file_path'];
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object
        $recordsCount = $csv->count();

        $data = [];

        foreach ($records as $record) {

            $data[] = [
                'product_code' => $record['Product Code'],
                'product_name' => $record['Product Name'],
                'product_price' => $record['Price'],
                'product_image' => 'blank.jpg',
                'category_id' => $category_id,
                'brand' => $record['Brand'],
                'model' => $record['Model'],
                'unit' => $record['Unit']
            ];
        }

        $rowCount = $this->model->insert_batch('products', $data);

        set_flashdata([
            'type' => 'success',
            'message' => "{$rowCount} out of {$recordsCount} was imported successfully"
        ]);

        unlink($path);

        redirect('dashboard/products/import');
    }

    public function add_category()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->show_add_category_form();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_save_product_category();
        }
    }

    public function categories()
    {

        $categories = $this->model->query('SELECT * FROM categories', 'object');

        $data['page_title'] = 'Product categories';
        $data['view_file'] = 'list_categories';
        $data['view_module'] = 'products';
        $data['categories'] = $categories;

        $this->template('dashboard', $data);
    }

    public function show_add_category_form()
    {
        $data['page_title'] = 'Add product category';
        $data['view_file'] = 'add_product_category';
        $data['view_module'] = 'products';
        $this->template('dashboard', $data);
    }

    private function _save_product_category()
    {
        $categoryInserted = $this->model->insert([
            'category_name' => post('name'),
            'category_description' => post('description')
        ], 'categories');

        if (!$categoryInserted) {

            set_flashdata([
                'type' => 'error',
                'message' => 'Product category not saved'
            ]);

            redirect('dashboard/products/categories');
        }

        set_flashdata([
            'type' => 'success',
            'message' => 'Product category saved successfully'
        ]);

        redirect('dashboard/products/categories');
    }

    public function edit_category(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->show_edit_category_form($id);
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->_update_product_category($id);
        }
    }

    public function show_edit_category_form(int $id)
    {
        $data['page_title'] = 'Edit product category';
        $data['view_file'] = 'edit_product_category';
        $data['view_module'] = 'products';
        $data['category'] = $this->model->get_one_where('category_id', $id, 'categories');

        $this->template('dashboard', $data);
    }

    public function _update_product_category(int $id)
    {

        try {
            $this->model->update_where('category_id', $id, [
                'category_name' => post('name'),
                'category_description' => post('description')
            ], 'categories');
        } catch (\Exception) {

            set_flashdata([
                'type' => 'error',
                'message' => 'Product category not updated'
            ]);

            redirect('dashboard/products/categories');
        }

        set_flashdata([
            'type' => 'success',
            'message' => 'Product category updated.'
        ]);

        redirect('dashboard/products/categories');
    }


    public function delete_category(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $this->_delete_category($id);
        }
    }

    private function _delete_category(int $id)
    {
        $productCount = $this->model->count_where(
            column: 'category_id',
            value: $id,
            order_by: 'product_id'
        );

        if ($productCount > 0) {
            set_flashdata([
                'type' => 'warning',
                'message' => 'Cannot remove this category has it has one or more products'
            ]);
        } else {

            $query = "DELETE FROM categories WHERE category_id = :id";

            $this->model->query_bind($query, ['id' => $id]);

            set_flashdata([
                'type' => 'success',
                'message' => 'Product category removed.'
            ]);
        }

        redirect('dashboard/products/categories');
    }
}
