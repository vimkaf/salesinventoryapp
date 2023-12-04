<?php

class Products extends Trongate{

    //list products
    function list(){
        $this->getlistproduct();
    }

    function getlistproduct(){
        $sql = "SELECT * FROM products 
        LEFT JOIN categories ON products.category_id = categories.category_id
        ORDER BY product_id DESC
        ";
        $products = $this->model->query($sql,'object');
        $data= [
            'products' => $products
        ];
        $data['page_title'] = 'List Products';
        $data['view_file'] = 'list_products';
        $data['view_module'] = 'products';
        
        $this->template('dashboard', $data);
    }

    
    //add products
    function add(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $this->addproductsform();
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->saveproducts();
        }
    }
    
    function addproductsform(){
        $sql = "SELECT * FROM categories";
        $categories = $this->model->query($sql,'object');
        $data = [
            'categories' => $categories
        ];
        $data['page_title'] = "Add Product";
        $data['view_file'] = 'add_product';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }

    function _upload_product_image($product_name){
        $image = $_FILES['product_image'];

        $originameimagename = $image['name'];
        $splitedstring = explode('.',$originameimagename);
        $exatention = '.'.$splitedstring[count($splitedstring)-1];
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
        $name = str_replace(" ","_", $product_name);
        $newimagename = $path.$name.$exatention;
        $imagename = $name.$exatention;
        
        $image_uploaded =  move_uploaded_file($image['tmp_name'],$newimagename);

        if($image_uploaded){
            return $imagename;
        }

        return false;
    }



    function saveproducts(){
    
        $image_uploaded = $this->_upload_product_image(post('product_name'));

        if($image_uploaded === false){
            set_flashdata([
                'type' => 'error',
                'message' => 'Product image failed to upload'
            ]);

            redirect('/products/add');
        }

        $data['product_name'] = post('product_name');
        $data['product_price'] = post('product_price');
        $data['product_code'] = post('product_code');    
        $data['product_image'] = $image_uploaded;
        $data['category_id'] = post('category_id');
        $data['brand'] = post('brand');
        $data['model'] = post('model');
        $data['unit'] = post('unit');

        $this->model->insert($data,'products');


        set_flashdata([
            'type' => 'success',
            'message' => 'Product has been added successfully'
        ]);
        
        redirect('/products/list');

     
    }

    //edit 
    function edit($id){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->show_edit_product_form($id);
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->_update_product($id);
        }
    }
    
    function show_edit_product_form($id){
        $product = $this->model->get_one_where('product_id',$id);
        
        $sql ="SELECT * FROM categories"; 
        $categories = $this->model->query($sql,'object');

        if($product === false){
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
        $this->template('dashboard',$data);
    }

    function _update_product($id){
        $image = $_FILES['product_image'];
        
        if($image['error'] == 0){
        
            $image_name = $this->_upload_product_image(post('product_name'));
            $data['product_image'] = $image_name;
        
        }

        $data['product_name'] = post('product_name');
        $data['product_price'] = post('product_price');
        $data['product_code'] = post('product_code');
        $data['category_id'] = post('category_id');
        $data['brand'] = post('brand');
        $data['model'] = post('model');
        $data['unit'] = post('unit');

        $this->model->update_where('product_id',$id,$data,'products');
        
        set_flashdata([
            'type' => 'success',
            'message' => 'Product has been updated successfully'
        ]);
        redirect('/dashboard/products/edit/'.$id);
    }

    //delete
    function delete($id){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->delete_product($id);
        }
    }
    function delete_product($id){
        $sql ="SELECT * FROM inventory WHERE product_id = $id";
        $product = $this->model->query($sql, 'object');
        $data = [
            'product' => $product
        ];
        if(!empty($product->product_id)){            
            set_flashdata([
                'type' => 'error',
                'message' => 'Product List failed to Delete, inventory already have products'
            ]);
            redirect('/products/list');            
        }
            $query = "DELETE FROM products WHERE product_id ='$id'";
            $da = $this->model->query($query,'object');
            set_flashdata([
                'type' => 'success',
                'message' => 'Product have been deleted'
            ]);
            redirect('/products/list');

    }
    //add_stock
    function add_stock(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_stocks();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->save_stock();
        }
    }
    function get_stocks(){
        $query ="SELECT * FROM products";       
        $products = $this->model->query($query,'object');

        $quesry2 ="SELECT * FROM warehouses";
        $warehouses = $this->model->query($quesry2,'object');

        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];

        $data['page_title'] = 'Add Stock';
        $data['view_file'] = 'add_stocks';
        $data['view_module'] = 'products'; 
       
        $this->template('dashboard', $data);
    }
    
    function save_stock(){

        $purchase_order_number = post('purchase_order_number');

        $purchase_order = false;

        if(!empty($purchase_order_number)){
            $purchase_order = $this->model->get_one_where("purchase_order_number", $purchase_order_number, "purchase_orders");
        }
                        

        $quanity_to_stock = $purchase_order === false  ? abs(post('quantity')) : $purchase_order->quantity_ordered;


        $this->module('inventory');


        $stock_added = $this->inventory->_add_to_inventory(
            $quanity_to_stock,
            post('product_id'),
            post('warehouse_id'),
            post('reorderlevel'),
            $purchase_order_number
        );

        if($stock_added){
            set_flashdata([
                'type' => 'success',
                'message' => 'Stock added to product warehouse'
            ]);

            redirect('/products/add_stock');
        }

        set_flashdata([
            'type' => 'error',
            'message' => 'Stock was not added to product warehouse'
        ]);
        
        redirect('/products/add_stock');

    }


    //import products
    function import(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->getimport_products();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->import_product();
        }
    }
    function getimport_products(){
        $data['page_title'] = 'Import Products';
        $data['view_file'] = 'import_products';
        $data['view_module'] = 'products';        
        $this->template('dashboard', $data);
    }
    function import_product(){
        $data['file'] = $_POST['file'];
        $this->model->insert($data,'table_name');
    }
    //Quantity Adjustments
    function quantity(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_quantity();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            //insert 
        }
    }
    function get_quantity(){
        $data['page_title'] = 'Quantity Adjustment';
        $data['view_file'] = 'quantity_adjustments';
        $data['view_module'] = 'products';        
        $this->template('dashboard', $data);
    }
    //Add Adjustments
    function add_adjustments(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_add_adjustment();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->save_adjustment(); 
        }
    }
    function get_add_adjustment(){
        $query ="SELECT * FROM products";       
        $products = $this->model->query($query,'object');

        $query2 ="SELECT * FROM warehouses";       
        $warehouses = $this->model->query($query2,'object');
        $data = [
            'products' => $products,
            'warehouses' => $warehouses
        ];
        $data['page_title'] = 'Add Adjustment';
        $data['view_file'] = 'add_adjustments';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }
    function save_adjustment(){
        $action = post('action');
        $warehouse_id = post('warehouse_id');
        $product_id = post('product_id');
        $quantity = post('quantity');
        $query ="SELECT * FROM inventory WHERE product_id = $product_id AND warehouse_id = $warehouse_id";
        $result = $this->model->query($query,'object');
        $old_quantity = $result[0]->quantity_on_hand;
        $new_add_quantity = $old_quantity + $quantity;
        $new_remove_quantity = $old_quantity - $quantity;
        $inventory_id = $result[0]->inventory_id;
        if($action === 'add'){
            $query2 ="UPDATE inventory SET quantity_on_hand = $new_add_quantity WHERE inventory_id = $inventory_id";
            $result2 = $this->model->query($query2,'object');
            
            //inserting to the transaction table
            $data['inventory_id'] = $inventory_id;
            $data['transaction_type'] = $action;
            $data['quantity'] = post('quantity');
            $data['transaction_date'] = date('y-m-d');
            $data['employee_id'] = $_SESSION['employee']->employee_id;
            $data['remarks'] = post('remark');
            $data['reference_id'] = "";
            $this->model->insert($data,'inventory_transactions');
            set_flashdata([
            'type' => 'success',
            'message' => 'Adjustment have been done'
            ]);

            redirect('/products/add_adjustments');
        }
        if($action === 'remove'){
            $query3 ="UPDATE inventory SET quantity_on_hand = $new_remove_quantity WHERE inventory_id = $inventory_id";
            $result3 = $this->model->query($query3,'object');
            //inserting to the transaction table
            $data['inventory_id'] = $inventory_id;
            $data['transaction_type'] = $action;
            $data['quantity'] = post('quantity');
            $data['transaction_date'] = date('y-m-d');
            $data['employee_id'] = $_SESSION['employee']->employee_id;
            $data['remarks'] = post('remark');
            $data['reference_id'] = "";
            $this->model->insert($data,'inventory_transactions');
             set_flashdata([
            'type' => 'success',
            'message' => 'Adjustment have been done'
            ]);

            redirect('/products/add_adjustments');
        }
    }

    //count stocks
    function count(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_count_stock();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            //insert
        }
    }
    function get_count_stock(){
        $data['page_title'] = 'Count Stock';
        $data['view_file'] = 'count_stocks';
        $data['view_module'] = 'products';        
        $this->template('dashboard', $data);
    }
    //stock counts
    function stock(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $this->get_stock_count();
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $this->save_stock_count();
        }
    }
    function get_stock_count(){
        $data['page_title'] = 'Stock Count';
        $data['view_file'] = 'stock_counts';
        $data['view_module'] = 'products';        
        $this->template('dashboard', $data);
    }
    function save_stock_count(){
        $data['warehouse'] = post('warehouse');
        $data['date'] = post('date');
        $date['reference'] = post('reference');
        $date['type'] = post('type');
        $this->model->insert($data,'table');
        redirect('/products/stock');
    }

}