<?php 
class Products extends Trongate{
    function add_product(){
        $this->view('add_product');
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