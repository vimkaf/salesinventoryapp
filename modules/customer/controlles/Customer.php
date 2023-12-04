<?php 
class Customer extends Trongate{
    function add(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $data['page_title'] = 'Add customer';
            $data['view_file'] = 'add_customer';
            $data['view_module'] = 'customer';
            
            $this->template('dashboard', $data);
        }
        if($_SERVER['REQUEST_METHOD'] === "POST"){

        }
    }
    function list(){
        if($_SERVER['REQUEST_METHOD'] === "GET"){
            $data['page_title'] = 'View customer';
            $data['view_file'] = 'view_customer';
            $data['view_module'] = 'customer';
            
            $this->template('dashboard', $data);
        }
        if($_SERVER['REQUST_METHOD'] === "POST"){

        }
    }
}