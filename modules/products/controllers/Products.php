<?php

class Products extends Trongate{

    function list(){

        echo "Products list should appeare here";
    }

    function add(){
    
        $data['page_title'] = "Add Product";
        $data['view_file'] = 'add_product';
        $data['view_module'] = 'products';

        $this->template('dashboard', $data);
    }
    function list_product(){
        $this->view('list_products');
    }
    function import_product(){
        $this->view('import_products');
    }
    function count_stock(){
        $this->view('count_stocks');
    }
    function stock_count(){
        $this->view('stock_counts');
    }
}